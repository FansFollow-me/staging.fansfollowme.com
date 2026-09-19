<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            if (! Schema::hasColumn('tips', 'thanked_at')) {
                $table->timestamp('thanked_at')->nullable()->after('provider');
            }
            if (! Schema::hasColumn('tips', 'reaction')) {
                $table->string('reaction', 40)->nullable()->after('thanked_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['thanked_at', 'reaction']);
        });
    }
};
