<?php

namespace App\Exports;

use App\Models\fichehor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;





class AllFichesExport implements  FromCollection , WithTitle ,ShouldAutoSize,WithHeadings,WithStyles
{
    protected $id;
    protected $idFi;
    protected $nom;
    protected $prenom;
    protected $statutF;

    function __construct($id,$idFi,$nom,$prenom,$statutF) {
        $this->id = $id;
        $this->idFi = $idFi;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->statutF = $statutF;
    }

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         $fiches = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY idfiche DESC,mois ASC',[ $this->id]);
        
         return collect($fiches);
     }
    public function headings(): array
    {
        return [
            [$this->nom,$this->prenom],
            ['Fiche','Statut',]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
        ];
    }
    public function title(): string
    {
        return 'Fiches horaires ' . $this->nom .$this->prenom;
    }

}
