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
use Maatwebsite\Excel\Concerns\WithMultipleSheets;






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
         $fiches = DB::select('select idfiche,Date,
         typeJour,
         Poids,
         activite1,
         matinD,
         matinF,
         activite2,
         apremD,
         apremF,
         activite3,
         soirD,
         soirF,
         heuresEffectu,
         ecart,
         FRASAD,
         Prestataire,
         Mandataires,
         EntraideFamiliale,
         Voisineurs,
         SOSgarde,
         Federation,
         ADUservices,
         ADVM,
         DELEGATION from fichehors where idUser = (select identifiant from employes where id = ?) AND idfiche=?',[ $this->id,$this->idFi]);
        
         return collect($fiches);
     }
    public function headings(): array
    {
        return [
            [$this->nom,$this->prenom,'','','','',$this->statutF],
            [
            'Fiche','Jours','Type jour','Poids du jour','Matin','Arrivée matin','Départ matin','Après midi','Arrivée aprem','Départ aprem','Soir','Arrivée soir','Départ soir','Total','Ecart jour',
            'FRASAD','Prestataire','Mandataire','Entraide','Voisineurs','SOS GE','Fédération','ADU','ADVM','Délégation']
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
        return  $this->nom .' '. $this->prenom .' / '. $this->idFi;
    }

}
