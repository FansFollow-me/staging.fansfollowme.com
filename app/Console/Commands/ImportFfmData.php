<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportFfmData extends Command
{
    protected $signature = 'ffm:import-data';
    protected $description = 'Import FFM data from TMD server';

    public function handle()
    {
        $tables = ['admin_settings','blocked_users','blogs','bookmarks','categories',
            'comments','comments_likes','conversations','countries','creator_status',
            'creator_subscriptions','deposits','email_notifications','failed_jobs',
            'favorites','followers','gifts','hashtags','languages','likes',
            'live_streamings','media','messages','notifications','pages',
            'password_resets','payment_gateways','personal_access_tokens','posts',
            'products','reports','reels','saved_cards','settings',
            'shared_posts','stories','subscriptions','tax_rates','tips',
            'transactions','updates','users','verification_requests','withdrawals',
            'advertising','blocked_countries','gifts','reels'];

        $tables = array_unique($tables);
        $imported = 0;
        $failed = 0;

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($tables as $table) {
            $url = "https://fansfollow.me/ffm_table_data/{$table}.sql";
            $sql = @file_get_contents($url);
            if ($sql && strlen($sql) > 10) {
                try {
                    DB::unprepared($sql);
                    $imported++;
                    $this->line("OK: {$table}");
                } catch (\Exception $e) {
                    $failed++;
                    $this->warn("ERR: {$table} - " . substr($e->getMessage(), 0, 80));
                }
            } else {
                $this->warn("SKIP: {$table} - no data");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $this->info("\nDone: {$imported} imported, {$failed} failed");
        return 0;
    }
}
