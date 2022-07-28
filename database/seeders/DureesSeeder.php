<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\duree;
use Illuminate\Support\Facades\DB;
class DureesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('durees')->insert([[
            'id' => 2,
            'pause' => "00:45:00",
        ],
    ]);
    }
}
