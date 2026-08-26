<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Read the SQL file and execute it
        $sql = file_get_contents(base_path('database/schema.sql'));
        \DB::unprepared($sql);
    }

    public function down()
    {
        // Drop all tables
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $tables = \DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = reset($table);
            Schema::dropIfExists($tableName);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
