<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\structures;
use Illuminate\Support\Facades\DB;
class StructuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('structures')->insert([[
            'id' =>1,
            'libellé' => "ADU",
            'code' => 92,
            'congePaye' => "Ouvrable - 6j",
        ],[
            'id' =>2,
            'libellé' => "ADVM",
            'code' => 92,
            'congePaye' => "Ouvrable - 6j",
        ],
        [
            'id' =>3,
            'libellé' => "Entraide familiale",
            'code' => 92,
            'congePaye' => "Ouvrable - 6j",
        ],
        [
            'id' =>4,
            'libellé' => "FRASAD",
            'code' => 92,
            'congePaye' => "Ouvrable - 5j",
        ],
        [
            'id' =>5,
            'libellé' => "SOS Garde d\'enfants",
            'code' => 92,
            'congePaye' => "Ouvrable - 5j",
        ],
        [
            'id' =>6,
            'libellé' => "SAD",
            'code' => 92,
            'congePaye' => "Ouvrable - 5j",
        ],
        [
            'id' =>7,
            'libellé' => "Fédération",
            'code' => 92,
            'congePaye' => "Ouvrable - 6j",
        ],
        
    ]);
    }
}
