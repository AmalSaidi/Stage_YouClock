<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\fichehor;
use Illuminate\Support\Facades\Auth;

class FicheHoraireUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(){
        $fiche = new fichehor();
        $fiche->Date = request('date1');
        global $f;
        $f=$fiche->Date;
        $fiche->idfiche = request('idfiche');
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

    public function show($id) {
        $affichage = DB::select('select * from fichehors where id = ?',[$id]);
        return view('USER/ficheHoraireUpdate',['affichage'=>$affichage]);
            }

    public function addDays() {
        $fiche = new fichehor();
        $fiche->Date = request('date1');
        $fiche->idfiche = request('idfiche');
        $user=Auth::user();
        $session_id = $user->id;
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
        for($i=1;$i <= $dateF; $i++){
            $date = date("Y-m-$i", strtotime("+1 day", strtotime($date)));
            $day_name = date('l', strtotime($date));
            $day_num = date('d', strtotime($date));
            $year_num = date('Y', strtotime($date));
            if($day_name=="Wednesday"){
                $day_name="Mer";
            }
            elseif($day_name=="Thursday")
               {
                $day_name="Jeu";
               }
            elseif($day_name=="Friday")
               {
                $day_name="Ven";
               }
            elseif($day_name=="Saturday")
                {
                $day_name="Sam";
                }
            elseif($day_name=="Sunday")
                {
                $day_name="Dim";
                }
            elseif($day_name=="Monday")
              {
                $day_name="Lun";
              }
            elseif($day_name=="Tuesday")
               {
                $day_name="Mar";
               }
            $idF=  $year_num." - ".$month;
            $dateBD= $day_name." ".$day_num." ".$month;
            DB::insert('insert into fichehors (idfiche,Date,idUser) values (?,?,?)', [$idF,$dateBD,$session_id]);
        }
        return redirect()->back();
        }

    public function index(){
        $user=Auth::user();
        $session_id = $user->id;
        $employes = DB::select('select * from employes');
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
        $year = date('y', strtotime($date));
        $p=0;
        $f=0;
        $totEcart=0;
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
        $affichage = DB::table('fichehors')->where('idUser', $session_id)->where('idfiche', 'like', '%'.$month.'%')
        ->where('idfiche', 'like', '%'.$year.'%')->get();
        return view('USER.ficheHoraire',[ 'employes' =>$employes,'date' =>$date,'date2' =>$date2,'dateF' =>$dateF,'month' =>$month,
        'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'samedi' =>$samedi,
        'dimanche' =>$dimanche,'affichage' => $affichage,'p'=>$p,'f'=>$f,'totEcart'=>$totEcart,
        ]);
    }

    public function edit(Request $request,$id) {
        $matinD = $request->input('morningS');
        $matinF = $request->input('morningF');
        $ApremD = $request->input('ApremS');
        $ApremF = $request->input('ApremF');
        $soirD = $request->input('soirS');
        $soirF = $request->input('soirF');
        $heuresEffectu = $request->input('heureseffectu');
        $activite1 = $request->input('TM');
        $activite2 = $request->input('TAP');
        $activite3 = $request->input('TS');
        $matin = $matinD ." - " .$matinF;
        $aprem = $ApremD ." - " .$ApremF;
        $soir = $soirD ." - " .$soirF;
        $hourdiffMat = round((strtotime($matinF) - strtotime($matinD ))/3600, 1);
        $hourdiffAprem = round((strtotime($ApremF) - strtotime($ApremD))/3600, 1);
        $hourdiffSoir = round((strtotime($soirF) - strtotime($soirD))/3600, 1);
        $poids= $hourdiffMat + $hourdiffAprem + $hourdiffSoir;
        $ecart= ($heuresEffectu-$poids);
        DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
        soirD=?, soirF=?,matin=?,poids=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
        activite3=?,ecart=? where id = ?',
        [$matinD,$matinF,$ApremD,$ApremF,$soirD,$soirF,$matin,$poids,$heuresEffectu,$activite1,$aprem,
        $soir,$activite2,$activite3,$ecart,$id]);
        return redirect('/FicheHoraire');
    }
}
