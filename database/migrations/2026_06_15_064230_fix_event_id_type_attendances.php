<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->dropColumn('event_id');

        });

        Schema::table('attendances', function (Blueprint $table) {

            $table->unsignedBigInteger('event_id')
                  ->nullable()
                  ->after('user_id');

        });
    }

    public function down(): void
    {
        //
    }
};