<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {

            $table->string('title')->after('id');

            $table->date('event_date')->nullable();

            $table->boolean('is_active')
                  ->default(false);

        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {

            $table->dropColumn([
                'title',
                'event_date',
                'is_active'
            ]);

        });
    }
};