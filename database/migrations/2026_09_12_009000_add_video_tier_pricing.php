<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('creator_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('creator_settings', 'video_tier1_price')) {
                $table->unsignedInteger('video_tier1_price')->default(5000)->after('audio_call_price');
                $table->unsignedInteger('video_tier2_price')->default(10000)->after('video_tier1_price');
                $table->unsignedInteger('video_tier3_price')->default(20000)->after('video_tier2_price');
                $table->boolean('video_messages_enabled')->default(true)->after('video_tier3_price');
                $table->boolean('brand_promo_enabled')->default(true)->after('video_messages_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('creator_settings', function (Blueprint $table) {
            $table->dropColumn([
                'video_tier1_price',
                'video_tier2_price',
                'video_tier3_price',
                'video_messages_enabled',
                'brand_promo_enabled',
            ]);
        });
    }
};
