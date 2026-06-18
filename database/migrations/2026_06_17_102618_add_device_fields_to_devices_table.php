<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {

            $table->string('device_id')->unique()->after('id');

            $table->string('device_name')->nullable();

            $table->string('device_type')->nullable();

            $table->timestamp('last_seen')->nullable();

            $table->boolean('is_online')->default(false);

        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {

            $table->dropColumn([
                'device_id',
                'device_name',
                'device_type',
                'last_seen',
                'is_online'
            ]);

        });
    }
};