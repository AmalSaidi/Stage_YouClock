<?php

namespace App\Exports;

use App\Models\fichehor;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\withEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;

class ActivitesExport implements FromCollection,
    ShouldAutoSize,
    WithMapping,
    withHeadings,
    withEvents
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return fichehor::where('idUser', 'IN2021050012')->where('idfiche', 'like', '%Juillet%')->get();
    }
    public function map($fichehor): array
    {
        return [
            $fichehor->Date,
            $fichehor->typeJour,
            $fichehor->Poids,
            $fichehor->matinD,
            $fichehor->matinF,
            $fichehor->apremD,
            $fichehor->apremF,
            $fichehor->soirD,
            $fichehor->soirF,
            $fichehor->heuresEffectu,
            $fichehor->ecart,
            $fichehor->FRASAD,
            $fichehor->Prestataire,
            $fichehor->Mandataires,
            $fichehor->EntraideFamiliale,
            $fichehor->Voisineurs,
            $fichehor->SOSgarde,
            $fichehor->Federation,
            $fichehor->ADUservices,
            $fichehor->ADVM,
            $fichehor->DELEGATION,
        ];
    }
    public function headings(): array
    {
        return [
            ['FAMILLES DE LA SARTHE'],
            ['nom:'],
            ['prenom:'],
            ['service:'],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            ['Jours','Type jour','Poids du jour','Arrivée','Départ','Arrivée','Départ','Arrivée','Départ','Total','Ecart jour',
        'FRASAD','Prestataire','Mandataire','AI','Voisineurs','SOS GE','Fédération','ADU','ADVM','Délégation'        ],
            /*[
            'Date',
            'typeJour',
            'matin',
            'aprem',
            'soir',
            'Poids',
            'heuresEffectu',
            'ecart',
            ]*/
        ];
    }

    public function registerEvents(): array
    {
        $fiiche = DB::select('select DISTINCT idfiche from fichehors where idUser = "IN2021050012"');
        return [
            AfterSheet::class    => function(AfterSheet $event){

                $event->sheet->getStyle('A10:U42')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ],

                ]
                    );
                $event->sheet->getStyle('A10:U11')->applyFromArray([
                    'font'=> [
                        'bold'=>true
                    ]

                ]
                    );
                    $event->sheet->getStyle('A1:U9')->applyFromArray([
                        'font'=> [
                            'bold'=>true
                        ]
    
                    ]
                        );
                        $event->sheet->getStyle('A1:U9')->applyFromArray([
                            'borders' => [
                                'allborders' => [
                                    'color' => [
                                        'rgb' => 'AAAAAA'
                                    ]
                                ]
                            ]
                        ]
                            );
                            $event->sheet->getStyle('B2')
                        ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                        $event->sheet->getStyle('B2')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                        $event->sheet->getStyle('B2')
                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $event->sheet->getStyle('B2')
                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $event->sheet->getStyle('B2')
                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $event->sheet->getStyle('B2')
                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $event->sheet->getStyle('B2')
                        ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                        $event->sheet->getStyle('B2')
                        ->getFill()->getStartColor()->setARGB('7296c1');
                    $event->sheet->setCellValue('D10', 'MATIN');
                    $event->sheet->setCellValue('F10', 'APREM');
                    $event->sheet->setCellValue('H10', 'SOIR');
                    $event->sheet->setCellValue('L10', 'VENTILATION ANALYTIQUE');
                    $event->sheet->setCellValue('F5', 'FICHE HORAIRE MENSUELLE');
                    $event->sheet->MergeCells('F5:M5');
                    $event->sheet->MergeCells('A1:C1');
                    $event->sheet->MergeCells('D10:E10');
                    $event->sheet->MergeCells('F10:G10');
                    $event->sheet->MergeCells('H10:I10');
                    $event->sheet->MergeCells('L10:U10');
                    $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(15);
                    $event->sheet->getDelegate()->getStyle('F5')->getFont()->setSize(30);
                    
            }
        ];
    }
    
}
