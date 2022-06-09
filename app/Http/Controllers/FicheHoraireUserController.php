<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class FicheHoraireUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employes = DB::select('select * from employes');
        $lundi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                             FROM horairesemaines INNER JOIN employes
                             ON employes.idS = horairesemaines.idSem and horairesemaines.id=1;');
        $mardi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                             FROM horairesemaines INNER JOIN employes
                             ON employes.idS = horairesemaines.idSem and horairesemaines.id=2;');
         $mercredi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=3;');
         $jeudi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=4;');
         $vendredi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=5;');
          $samedi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=6;');
           $dimanche = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=7;');
        $date = date('Y-m-01', strtotime("first day of this month"));
        $dateF = date('d', strtotime("last day of this month"));
        $date2 = date('l', strtotime($date));
        $month = date('n', strtotime($date));


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
        return view('USER.ficheHoraire',[ 'employes' =>$employes,'date' =>$date,'date2' =>$date2,'dateF' =>$dateF,'month' =>$month,
        'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'samedi' =>$samedi,
        'dimanche' =>$dimanche,
        ]);
    }
}
