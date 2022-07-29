<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemainetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semainetypes', function (Blueprint $table) {
            $table->id();
            $table->string('iduser');
            $table->string('jour');
            $table->float('poidsJour')->nullable();
            $table->time('DM')->nullable();
            $table->time('FM')->nullable();
            $table->time('DA')->nullable();
            $table->time('FA')->nullable();
            $table->time('DS')->nullable();
            $table->time('FS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semainetypes');
    }
}
