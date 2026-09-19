<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('video_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('video_requests', 'tier')) {
                $table->unsignedTinyInteger('tier')->nullable()->after('occasion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('video_requests', function (Blueprint $table) {
            $table->dropColumn('tier');
        });
    }
};
