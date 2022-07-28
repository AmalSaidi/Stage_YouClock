<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\services;
use Illuminate\Support\Facades\DB;
class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([[
            'id' => 1,
            'libellé' => "Comptabilité",
            'responsable' => "Julie GOURMELON",
        ],[
            'id' => 2,
            'libellé' => "Continuité",
            'responsable' => "Céline OUDIN BOUCHEREAU",
        ],[
            'id' => 3,
            'libellé' => "Ressources Humaines",
            'responsable' => "Laurence GAGLIONE",
        ],[
            'id' => 4,
            'libellé' => "Communication",
            'responsable' => "Catherine ROBERTON",
        ],[
            'id' => 5,
            'libellé' => "Direction",
            'responsable' => "Catherine ROBERTON",
        ],[
            'id' => 6,
            'libellé' => "Qualité",
            'responsable' => "Catherine ROBERTON",
        ],[
            'id' => 7,
            'libellé' => "Administratif",
            'responsable' => "Catherine GAUTIER",
        ],[
            'id' => 8,
            'libellé' => "Cadre Opérationnel Terrain",
            'responsable' => "Martine ROPARS",
        ],[
            'id' => 9,
            'libellé' => "Cadre Opérationnel Terrain",
            'responsable' => "Virginie LEFEUVRE",
        ],
        
    ]);
    }
}
