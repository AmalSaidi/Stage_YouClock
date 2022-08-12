<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichehorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichehors', function (Blueprint $table) {
            $table->id();
            $table->string('statutF')->default('EnCours');
            $table->string('state')->default('NR');
            $table->string('Date')->nullable();
            $table->float('Diff')->nullable();
            $table->string('mois')->nullable();
            $table->integer('year')->nullable();
            $table->string('semaine')->nullable();
            $table->string('typeJour')->nullable();
            $table->string('activite1')->nullable();
            $table->string('matin')->nullable();
            $table->string('activite2')->nullable();
            $table->string('aprem')->nullable();
            $table->string('activite3')->nullable();
            $table->string('soir')->nullable();
            $table->float('heuresEffectu')->nullable();
            $table->float('Poids')->nullable();
            $table->float('ecart')->nullable();
            $table->string('idfiche');
            $table->string('idUser')->nullable();
            $table->float('matinD')->nullable();
            $table->float('matinF')->nullable();
            $table->float('apremD')->nullable();
            $table->float('apremF')->nullable();
            $table->float('soirD')->nullable();
            $table->float('soirF')->nullable();
            $table->float ('FRASAD')->nullable();
            $table->float ('EntraideFamiliale')->nullable();
            $table->float ('Federation')->nullable();
            $table->float ('Prestataire')->nullable();
            $table->float ('Voisineurs')->nullable();
            $table->float ('ADUservices')->nullable();
            $table->float ('Mandataires')->nullable();
            $table->float ('SOSgarde')->nullable();
            $table->float ('ADVM')->nullable();
            $table->float ('DELEGATION')->nullable();
            $table->float ('AI')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichehors');
    }
}
