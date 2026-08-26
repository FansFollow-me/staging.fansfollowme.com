<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        \DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"');
        
        $sql = file_get_contents(base_path('database/schema.sql'));
        
        // Split by semicolons and execute each statement
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            fn($s) => !empty($s) && !preg_match('/^--/', $s) && !preg_match('/^\/\*/', $s)
        );
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && $statement !== 'SET FOREIGN_KEY_CHECKS = 0') {
                try {
                    \DB::statement($statement);
                } catch (\Exception $e) {
                    // Skip errors for existing tables
                    if (str_contains($e->getMessage(), 'already exists')) {
                        continue;
                    }
                    \Log::warning('Schema import: ' . $e->getMessage());
                }
            }
        }
        
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $tables = \DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            \DB::statement('DROP TABLE IF EXISTS `' . reset($table) . '`');
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
