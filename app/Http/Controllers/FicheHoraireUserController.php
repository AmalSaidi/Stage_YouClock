<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\fichehor;



class FicheHoraireUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(){
        $fiche = new fichehor();
        $fiche->Date = request('date');
        global $f;
        $f=$fiche->Date;
        $fiche->activite1 = request('typeM');
        $fiche->matin = request('matin');
        $fiche->activite2 = request('typeAP');
        $fiche->aprem = request('aprem');
        $fiche->activite3 = request('typeS');
        $fiche->soir = request('soir');
        $fiche->heuresEffectu = request('heuresEffec');
        $fiche->Poids = request('poids');
        $fiche->ecart = request('ecartJour');
        $fiche->idfiche = request('idfiche');
        $fiche->idUser = request('idUser');
        $condition = DB::select('select * from fichehors where EXISTS (select * from ficheHors where Date = ?)',[$fiche->Date]);
        if($condition) {
            return $this->show($f);
        }
        else
        {
            $fiche->save();
            return $this->show($f);
        }
        return redirect()->back();
    }

    public function show($f) {
        $fiche = DB::select('select * from fichehors where Date = ?',[$f]);
        return view('USER/ficheHoraireUpdate',['fiche'=>$fiche]);
        }

    public function index(){
        $employes = DB::select('select * from employes');
        $affichage = DB::select('select * from fichehors');
        $lundi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
                             FROM horairesemaines INNER JOIN employes
                             ON employes.idS = horairesemaines.idSem and horairesemaines.id=1;');
        $mardi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
                             FROM horairesemaines INNER JOIN employes
                             ON employes.idS = horairesemaines.idSem and horairesemaines.id=2;');
        $mercredi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=3;');
        $jeudi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=4;');
        $vendredi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=5;');
        $samedi = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
                            FROM horairesemaines INNER JOIN employes
                            ON employes.idS = horairesemaines.idSem and horairesemaines.id=6;');
        $dimanche = DB::select('SELECT nom, prenom, DebutMat, FinMat, DebutAprem, FinAprem , typeM, typeAP, typeS
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
        'dimanche' =>$dimanche,'affichage' => $affichage,
        ]);
    }
}
