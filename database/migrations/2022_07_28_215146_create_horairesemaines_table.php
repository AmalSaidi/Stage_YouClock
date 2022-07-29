<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorairesemainesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horairesemaines', function (Blueprint $table) {
            $table->id();
            $table->integer('idSem');
            $table->string('idJour');
            $table->time('DebutMat');
            $table->time('FinMat');
            $table->time('DebutAprem');
            $table->time('FinAprem');
            $table->string('typeM');
            $table->string('typeAP');
            $table->string('typeS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horairesemaines');
    }
}
