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
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doing_booking');
            $table->foreignId('booking_on');
            $table->foreignId('consultation_item_id');
            $table->foreignId('day_id');
            $table->time('time_start');
            $table->time('time_end');
            $table->boolean('is_Begin')->default(false);
            $table->boolean('isInProgress')->default(false);
            $table->boolean('isFinish')->default(false);
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
        Schema::dropIfExists('dates');
    }
};
