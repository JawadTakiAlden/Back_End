<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_id');
            $table->foreignId('day_id');
            $table->foreignId('work_time_id');
            $table->time('time_start');
            $table->time('time_end');
            $table->boolean('isBooking')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_times');
    }
};
