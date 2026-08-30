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
    ['updates', 'created_at', fn(\$t) => \$t->timestamp('created_at')->nullable()],
    ['updates', 'updated_at', fn(\$t) => \$t->timestamp('updated_at')->nullable()],
    ['admin_settings', 'allow_vault', fn(\$t) => \$t->boolean('allow_vault')->default(0)],
    ['admin_settings', 'allow_crowdfund', fn(\$t) => \$t->boolean('allow_crowdfund')->default(0)],
    ['admin_settings', 'allow_scheduled_posts', fn(\$t) => \$t->boolean('allow_scheduled_posts')->default(0)],
    ['admin_settings', 'video_call_status', fn(\$t) => \$t->string('video_call_status', 10)->default('off')],
    ['admin_settings', 'audio_call_status', fn(\$t) => \$t->string('audio_call_status', 10)->default('off')],
    ['admin_settings', 'gifts', fn(\$t) => \$t->boolean('gifts')->default(0)],
    ['admin_settings', 'disable_creators_section', fn(\$t) => \$t->boolean('disable_creators_section')->default(0)],
    ['admin_settings', 'google_tag_manager_head', fn(\$t) => \$t->text('google_tag_manager_head')->nullable()],
    ['admin_settings', 'google_tag_manager_body', fn(\$t) => \$t->text('google_tag_manager_body')->nullable()],
    ['admin_settings', 'theme_color_pwa', fn(\$t) => \$t->string('theme_color_pwa', 20)->default('#450ea7')],
    ['admin_settings', 'age_verification_status', fn(\$t) => \$t->string('age_verification_status', 10)->default('0')],
    ['admin_settings', 'age_verification', fn(\$t) => \$t->string('age_verification', 10)->default('18')],
    ['admin_settings', 'websockets', fn(\$t) => \$t->boolean('websockets')->default(0)],
    ['admin_settings', 'story_status', fn(\$t) => \$t->boolean('story_status')->default(0)],
];
foreach (\$cols as [\$table, \$col, \$add]) {
    if (Schema::hasTable(\$table) && !Schema::hasColumn(\$table, \$col)) {
        Schema::table(\$table, \$add);
        echo \"Added \$col to \$table\n\";
    }
}

// Populate updates.created_at from date column if null
DB::table('updates')->whereNull('created_at')->update(['created_at' => DB::raw('date'), 'updated_at' => DB::raw('date')]);

// Ensure public access to profiles
DB::table('admin_settings')->where('who_can_see_content', 'users')->update(['who_can_see_content' => 'all']);
echo 'Extra schema fixes applied';
" 2>&1 | tail -1

# 5. Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "=== Deploy complete ==="
