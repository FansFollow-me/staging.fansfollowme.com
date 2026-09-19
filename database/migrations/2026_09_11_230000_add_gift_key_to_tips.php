<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tips', 'gift_key')) {
            Schema::table('tips', function (Blueprint $table) {
                $table->string('gift_key', 40)->nullable()->after('message');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tips', 'gift_key')) {
            Schema::table('tips', function (Blueprint $table) {
                $table->dropColumn('gift_key');
            });
        }
    }
};
