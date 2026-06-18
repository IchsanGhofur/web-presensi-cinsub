<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->string('qr_data')
                  ->nullable()
                  ->after('device_id');

            $table->timestamp('check_in_time')
                  ->nullable()
                  ->after('qr_data');

        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->dropColumn([
                'qr_data',
                'check_in_time'
            ]);

        });
    }
};