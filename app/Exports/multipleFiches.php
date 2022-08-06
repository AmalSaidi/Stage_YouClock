<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;


class multipleFiches implements WithMultipleSheets
{
    use Exportable;

    protected $idUser;
    
    public function __construct(int $idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new multipleFiches($this->year, $month);
        }

        return $sheets;
    }
}
