<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('access', 20)->default('free')->after('is_paid');
        });

        // Existing paid posts were lock-for-everyone-until-buy → PPV
        DB::table('posts')
            ->where('is_paid', true)
            ->update(['access' => 'ppv']);

        DB::table('posts')
            ->where('is_paid', false)
            ->update(['access' => 'free']);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('access');
        });
    }
};
