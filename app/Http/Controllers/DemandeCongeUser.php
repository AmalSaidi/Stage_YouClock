<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class DemandeCongeUser extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employes = DB::select('select * from employes where id = ?', [1]);
        $conge =  DB::table('demandeconge')->get();
        $date = date('F Y');//Current Month Year
        $row_count=0;
        $col_count=0;
        $currDate = date('Y-m').'-01';
        $month = date('n');
        $year = date('Y');

        switch ($month) {
            case 1:
                $month="Janvier";
                break;
            case 2:
                $month="Février";
                break;
            case 3:
                $month="Mars";
                break;
            case 4:
                $month="Avril";
                break;
            case 5:
                $month="Mai";
                break;
            case 6:
                $month="Juin";
                break;
            case 7:
                $month="Juillet";
                break;
            case 8:
                $month="Août";
                break;
            case 9:
                $month="Septembre";
                break;
            case 10:
                $month="Octobre";
                break;
            case 11:
                $month="Novembre";
                break;
            case 12:
                $month="Décembre";
                break;
        }
        return view('USER.demandeConge',[
            'employes' =>$employes,
            'date'=>$date,
            'row_count'=>$row_count,
            'col_count'=>$col_count,
            'conge' => $conge,
            'month'=>$month,
            'year'=>$year,
        ]);
    }

    public function store(){
        DB::table('demandeconge')->insert([
            'type' => request('type'),
            'dateDebut' => request('start'),
            'dateFin' => request('fin'),
            'dateRetour' => request('retour')
        ]);

        return redirect()->back();

    }
    
    public function verifyDate(){
        $dateD = DB::select('select * from demandeconge');

        return view('USER.demandeConge',[
            'dateD' =>$dateD, 
        ]);

    }

}
