<?php

namespace Database\Seeders;
use App\Models\employes;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class EmployesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employes')->insert([[
            'id' => 1,
            'idS' => NULL,
            'nom' => "ANGOT",
            'prenom' => "Marine",
            'mail' => "le-mans1.sad@orange.fr",
            'tel' => "0748105486",
            'TypeContrat' => "CDI",
            'TempsTra' => NULL,
            'JoursNonTra' => NULL,
            'heuresParMois' => NULL,
            'service' => NULL,
            'Ventilation' => NULL,
            'admin' => 0,
            'intitule' => "SAD_Resp Bénéficiaires",
            'structure' => "FRASAD",
            'dateEmbauche' => "2021-09-20",
            'Datefin' => "2023-08-30",
            'identifiant'=>NULL,

        ],
        [
            'id' => 24,
            'idS' => NULL,
            'nom' => "ZENASNI",
            'prenom' => "Houria",
            'mail' => "mutuelle.ai@orange.fr",
            'tel' => NULL,
            'TypeContrat' => "CDI",
            'TempsTra' => NULL,
            'JoursNonTra' => NULL,
            'heuresParMois' => NULL,
            'service' => NULL,
            'Ventilation' => NULL,
            'admin' => 0,
            'intitule' => NULL,
            'structure' => "Entraide familiale",
            'dateEmbauche' => NULL,
            'Datefin' => NULL,
            'identifiant'=>"IN2021050012",
        ],
    ]);
    }
}
