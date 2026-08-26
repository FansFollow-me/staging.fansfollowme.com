<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUsers extends Command
{
    protected $signature = 'ffm:import-users';
    protected $description = 'Import users from TMD';

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('SET SQL_MODE = ""');
        $sql = file_get_contents('https://fansfollow.me/ffm_table_data/users.sql');
        $sql = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $sql);
        DB::unprepared($sql);
        $count = DB::select('SELECT COUNT(*) as c FROM users');
        $this->info('Users: ' . $count[0]->c);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        return 0;
    }
}
