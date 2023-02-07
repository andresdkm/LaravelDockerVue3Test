<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('date');
            $table->string('hour');
            $table->string('status');
            $table->string('competition_id');
            $table->string('home_team', 100);
            $table->string('home_team_crest', 150);
            $table->string('away_team', 100);
            $table->string('away_team_crest', 150);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
