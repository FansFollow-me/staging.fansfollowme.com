<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('age_verified_at');
                $table->timestamp('age_confirmed_at')->nullable()->after('date_of_birth');
                $table->string('age_confirmation_ip', 45)->nullable()->after('age_confirmed_at');
            }
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('withdrawal_requests', 'status_reason')) {
                $table->string('status_reason')->nullable()->after('status');
                $table->timestamp('requested_at')->nullable()->after('status_reason');
                $table->string('payout_method', 40)->nullable()->after('admin_note');
                $table->date('estimated_arrival')->nullable()->after('payout_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'age_confirmed_at', 'age_confirmation_ip']);
        });
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropColumn(['status_reason', 'requested_at', 'payout_method', 'estimated_arrival']);
        });
    }
};
