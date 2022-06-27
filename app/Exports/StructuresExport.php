<?php

namespace App\Exports;

use App\Models\structures;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class StructuresExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return structures::all();
    }
}
