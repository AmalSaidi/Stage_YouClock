<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;


class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('idS')->nullable();
            $table->text('nom');
            $table->text('prenom');
            $table->string('mail')->nullable();
            $table->integer('tel')->nullable();
            $table->string('TypeContrat');
            $table->string('TempTra')->nullable();
            $table->string('JoursNonTra')->nullable();
            $table->integer('heuresParMois')->nullable();
            $table->string('intitule')->nullable();
            $table->string('structure');
            $table->string('service')->nullable();
            $table->date('dateEmbauche')->nullable();
            $table->date('Datefin')->nullable();
            $table->string('Ventilation')->nullable();
            $table->integer('admin')->default(0);
            $table->string('identifiant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employes');
    }
}
