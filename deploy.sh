#!/bin/bash
# FFM Staging Deploy Script
# Runs on the persistent app container after each deploy

set -e

echo "=== FFM Deploy ==="

# 1. Create storage directories
mkdir -p storage/logs storage/framework/views storage/framework/cache storage/framework/sessions
chmod -R 777 storage bootstrap/cache

# 2. Create public/public symlink (for /public/uploads/ URLs)
cd public && ln -sf . public && cd ..

# 3. Uploads are on R2 (S3 driver). Skip TMD download (fansfollow.me is down).
echo "Uploads: using R2 storage (FILESYSTEM_DRIVER=s3)"

# 3b. Run pending migrations
php artisan migrate --force 2>&1 | tail -3

# 4. Fix missing database columns (idempotent)
php artisan tinker --execute="
\$fixes = [
  ['post_views', 'updates_id', 'INT UNSIGNED'],
  ['post_views', 'user_id', 'INT UNSIGNED'],
  ['post_views', 'ip', 'VARCHAR(50)'],
  ['updates', 'post_views', 'INT DEFAULT 0'],
  ['updates', 'scheduled_date', 'DATETIME'],
  ['updates', 'likes_extras', 'INT DEFAULT 0'],
  ['updates', 'crowdfund_goal', 'DECIMAL(10,2)'],
  ['updates', 'funds_raised', 'DECIMAL(10,2)'],
  ['updates', 'finalized', 'TINYINT(1) DEFAULT 0'],
  ['admin_settings', 'disable_creators_section', 'TINYINT(1) DEFAULT 0'],
];
foreach (\$fixes as \$f) {
  try { Schema::table(\$f[0], function(\$t) use (\$f) { 
    \$t->addColumn(new Illuminate\Database\Schema\ColumnDefinition(['name' => \$f[1], 'type' => \$f[2]])); 
  }); } catch (Exception \$e) {}
}
DB::table('admin_settings')->where('id',1)->update(['captcha' => 'off', 'disable_contact' => 0]);
echo 'Schema fixes applied';
" 2>&1 | tail -1

# 4b. Create missing tables and columns (moved from fix-laravel-cloud.php)
php artisan tinker --execute="
// Create video_calls and audio_calls tables if missing
foreach (['video_calls', 'audio_calls'] as \$table) {
    if (!Schema::hasTable(\$table)) {
        Schema::create(\$table, function (\$t) {
            \$t->id();
            \$t->integer('seller_id');
            \$t->integer('buyer_id');
            \$t->decimal('price', 10, 2)->default(0);
            \$t->string('status')->default('pending');
            \$t->integer('minutes')->default(0);
            \$t->string('token')->nullable();
            \$t->timestamp('started_at')->nullable();
            \$t->timestamp('joined_at')->nullable();
            \$t->timestamp('ended_at')->nullable();
            \$t->tinyInteger('paid')->default(0);
            \$t->timestamps();
        });
        echo \"Created \$table\n\";
    }
}

// Add missing columns
\$cols = [
    ['notifications', 'context', fn(\$t) => \$t->text('context')->nullable()],
    ['users', 'allow_comments', fn(\$t) => \$t->string('allow_comments', 10)->default('yes')],
    ['users', 'display_list_donors', fn(\$t) => \$t->string('display_list_donors', 10)->default('yes')],
    ['subscriptions', 'creator_id', fn(\$t) => \$t->integer('creator_id')->nullable()],
];
foreach (\$cols as [\$table, \$col, \$add]) {
    if (Schema::hasTable(\$table) && !Schema::hasColumn(\$table, \$col)) {
        Schema::table(\$table, \$add);
        echo \"Added \$col to \$table\n\";
    }
}

// Ensure public access to profiles
DB::table('admin_settings')->where('who_can_see_content', 'users')->update(['who_can_see_content' => 'all']);
echo 'Extra schema fixes applied';
" 2>&1 | tail -1

# 5. Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "=== Deploy complete ==="
