<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\activites;
use Illuminate\Support\Facades\DB;

class ActivitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activites')->insert([[
            'id' => 1,
            'code' => "T",
            'libellé' => "Travail",
            'Poids' => 7,
        ],[
            'id' => 2,
            'code' => "TP",
            'libellé' => "Temps partiel",
            'Poids' => NULL,
        ],[
            'id' => 3,
            'code' => "TT",
            'libellé' => "Télétravail",
            'Poids' => 7,
        ],[
            'id' =>4,
            'code' => "F",
            'libellé' => "Formation",
            'Poids' => 7,
        ],[
            'id' => 5,
            'code' => "1/2 RTT",
            'libellé' => "1/2 RTT",
            'Poids' => 4,
        ],[
            'id' => 6,
            'code' => "RTT",
            'libellé' => "RTT",
            'Poids' => 7,
        ],[
            'id' => 7,
            'code' => "CP",
            'libellé' => "Congé payé",
            'Poids' => 0,
        ],[
            'id' => 8,
            'code' => "M",
            'libellé' => "Maladie",
            'Poids' => NULL,
        ],[
            'id' => 9,
            'code' => "RCR",
            'libellé' => "Repos compensateur de remplacement",
            'Poids' => NULL,
        ],[
            'id' => 10,
            'code' => "CF",
            'libellé' => "Congé familiale",
            'Poids' => NULL,
        ],[
            'id' => 11,
            'code' => "S",
            'libellé' => "Sans solde",
            'Poids' => NULL,
        ],[
            'id' => 12,
            'code' => "JS",
            'libellé' => "Jour de solidarité",
            'Poids' => NULL,
        ],[
            'id' => 13,
            'code' => "CM",
            'libellé' => "Congé maternité",
            'Poids' => NULL,
        ],[
            'id' => 14,
            'code' => "CPAT",
            'libellé' => "Congé paternité",
            'Poids' => NULL,
        ],[
            'id' => 15,
            'code' => "CPATHO",
            'libellé' => "Congé pathologique",
            'Poids' => NULL,
        ],[
            'id' => 16,
            'code' => "EF",
            'libellé' => "Enfant malade",
            'Poids' => NULL,
        ],
    ]);
            
    }
}
