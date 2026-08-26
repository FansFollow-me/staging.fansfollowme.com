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
            'creator_subscriptions','deposits','email_notifications',
            'favorites','followers','gifts','hashtags','languages','likes',
            'live_streamings','media','messages','notifications','pages',
            'payment_gateways','products','subscriptions','transactions',
            'updates','users','verification_requests','withdrawals'];

        $imported = 0;
        $failed = 0;

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('SET SQL_MODE = ""');

        foreach ($tables as $table) {
            // Drop and recreate from schema if it has wrong columns
            $url = "https://fansfollow.me/ffm_table_data/{$table}.sql";
            $sql = @file_get_contents($url);
            if ($sql && strlen($sql) > 10) {
                // Convert INSERT to INSERT IGNORE
                $sql = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $sql);
                try {
                    DB::unprepared($sql);
                    $count = DB::select("SELECT COUNT(*) as c FROM `{$table}`");
                    $c = $count[0]->c ?? 0;
                    $imported++;
                    $this->line("OK: {$table} ({$c} rows)");
                } catch (\Exception $e) {
                    $failed++;
                    $this->warn("ERR: {$table} - " . substr($e->getMessage(), 0, 80));
                }
            } else {
                $this->warn("SKIP: {$table}");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $this->info("\nDone: {$imported} imported, {$failed} failed");
        return 0;
    }
}
