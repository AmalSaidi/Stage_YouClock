<?php

namespace Database\Seeders;
use App\Models\semainetype;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemaineTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semainetypes')->insert([[
            'idUser' => 2,
            'Jour' => 2,
            'pause' => "00:45:00",
        ],
    ]);
    }
}
