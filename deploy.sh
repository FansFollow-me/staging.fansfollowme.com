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

# 3. Download uploads if missing (only on first deploy)
if [ ! -d public/uploads/avatar ] || [ $(ls public/uploads/avatar/ 2>/dev/null | wc -l) -lt 100 ]; then
    echo "Downloading uploads from TMD..."
    curl -sL https://fansfollow.me/essential-uploads.tar | tar x -C public/
    curl -sL https://fansfollow.me/more-uploads.tar | tar x -C public/
    curl -sL https://fansfollow.me/videos.tar | tar x -C public/
    echo "Uploads downloaded ($(ls public/uploads/avatar/ | wc -l) avatars)"
else
    echo "Uploads exist ($(ls public/uploads/avatar/ | wc -l) avatars)"
fi

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

# 5. Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "=== Deploy complete ==="
