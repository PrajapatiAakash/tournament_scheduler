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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('group_id');
            $table->string('name');
            $table->integer('points')->default(0);
            $table->integer('total_number_of_matches')->default(0);
            $table->integer('total_number_of_winning_matches')->default(0);
            $table->integer('total_number_of_losing_matches')->default(0);
            $table->boolean('is_extra_team')->default(0);
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
        Schema::dropIfExists('teams');
    }
};
