<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUsersChunked extends Command
{
    protected $signature = 'ffm:import-users-chunked';
    protected $description = 'Import users in chunks from TMD';

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('SET SQL_MODE = ""');
        
        $chunks = range('aa', 'az');
        $imported = 0;
        
        foreach ($chunks as $suffix) {
            $url = "https://fansfollow.me/ffm_table_data/users_chunk_{$suffix}";
            $sql = @file_get_contents($url);
            if ($sql && strlen($sql) > 100) {
                $sql = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $sql);
                try {
                    DB::unprepared($sql);
                    $imported++;
                    $this->line("OK: chunk_{$suffix}");
                } catch (\Exception $e) {
                    $this->warn("ERR: chunk_{$suffix} - " . substr($e->getMessage(), 0, 60));
                }
            }
        }
        
        // Also try ba-bz
        foreach (range('ba', 'bz') as $suffix) {
            $url = "https://fansfollow.me/ffm_table_data/users_chunk_{$suffix}";
            $sql = @file_get_contents($url);
            if ($sql && strlen($sql) > 100) {
                $sql = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $sql);
                try {
                    DB::unprepared($sql);
                    $imported++;
                    $this->line("OK: chunk_{$suffix}");
                } catch (\Exception $e) {
                    $this->warn("ERR: chunk_{$suffix} - " . substr($e->getMessage(), 0, 60));
                }
            }
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        $count = DB::select('SELECT COUNT(*) as c FROM users');
        $this->info("Done: {$imported} chunks, " . ($count[0]->c ?? 0) . " users total");
        return 0;
    }
}
