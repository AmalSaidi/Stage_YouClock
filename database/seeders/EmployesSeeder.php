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
            'nom' => "ANGOT",
            'prenom' => "Marine",
            'mail' => "le-mans1.sad@orange.fr",
            'tel' => "0748105486",
            'typeContrat' => "CDD",
            'intitule' => "SAD_Resp Bénéficiaires",
            'structure' => "FRASAD",
            'dateEmbauche' => "2021-09-20",
            'Datefin' => "2023-08-30",
            'identifiant'=>NULL,
        ],
        [
            'id' => 11,
            'nom' => "RABAJOTIL",
            'prenom' => "Stépahnie",
            'mail' => "rabajotils.ai@orange.fr",
            'tel' => "1334",
            'typeContrat' => "CDI",
            'intitule' => "Chargée administrative",
            'structure' => "Entraide familiale",
            'dateEmbauche' => NULL,
            'Datefin' => NULL,
            'identifiant'=>"IN2021010063",
        ],
        [
            'id' => 23,
            'nom' => "HARDY",
            'prenom' => "Marion",
            'mail' => "respentraide@gmail.com",
            'tel' => NULL,
            'typeContrat' => "CDI",
            'intitule' => "Responsable de service",
            'structure' => "Entraide familiale",
            'dateEmbauche' => NULL,
            'Datefin' => NULL,
            'identifiant'=>"IN2021090008",
        ],
        [
            'id' => 14,
            'nom' => "POUPARD",
            'prenom' => "Roseline",
            'mail' => "poupardr.ai@wanadoo.fr",
            'tel' => NULL,
            'typeContrat' => "CDI",
            'intitule' => NULL,
            'structure' => "Entraide familiale",
            'dateEmbauche' => NULL,
            'Datefin' => NULL,
            'identifiant'=>"IN2021010062",
        ],
        [
            'id' => 24,
            'nom' => "ZENASNI",
            'prenom' => "Houria",
            'mail' => "mutuelle.ai@orange.fr",
            'tel' => NULL,
            'typeContrat' => "CDI",
            'intitule' => NULL,
            'structure' => "Entraide familiale",
            'dateEmbauche' => NULL,
            'Datefin' => NULL,
            'identifiant'=>"IN2021050012",
        ],
    ]);
    }
}
