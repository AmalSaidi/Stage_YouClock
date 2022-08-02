<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepassementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depassements', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('identifiant');
            $table->string('idFiche');
            $table->string('semaine');
            $table->float('nombreH');
            $table->string('motif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depassements');
    }
}
