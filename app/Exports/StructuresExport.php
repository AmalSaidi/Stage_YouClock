<?php

namespace App\Exports;

use App\Models\structures;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\withEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class StructuresExport implements FromCollection, ShouldAutoSize, withEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return structures::select('libellé','code','congePaye')->get();
    }
    
    public function registerEvents(): array
    { return [
        AfterSheet::class    => function(AfterSheet $event){
            $event->sheet->getStyle('A1:C1')->applyFromArray([
                'font'=> [
                    'bold'=>true
                ]

            ]);
    }
];
}
}
