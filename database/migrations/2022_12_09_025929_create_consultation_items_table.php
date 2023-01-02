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
        Schema::create('consultation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_id');
            $table->foreignId('type_id');
            $table->string('excerpt');
            $table->string('body');
            $table->double('rate')->default(0);
            $table->double('price');
            $table->integer('number_of_rating')->default(0);
            $table->time('consultation_time')->default('00:30:00');
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
        Schema::dropIfExists('consultation_items');
    }
};
