<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\fichehor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\ventilation;
use App\Models\ventilationfinal;


class FicheHoraireUserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validerFiche(Request $request) {
        $user=Auth::user();
        $session_id = $user->identifiant;
        $idFiche = $request->input('idfiche');
        DB::update('update fichehors set statutF="AttValiRS" where idfiche = ? and idUser = ?',[$idFiche,$session_id]);
        return redirect()->back();
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
        $user=Auth::user();
        $session_id = $user->identifiant;
        $affichage = DB::select('select * from fichehors where id = ?',[$id]);
        $activites = DB::select('select * from activites');
        $venti = DB::select('select * from ventilations where idUser = ?',[$session_id]);
        $last = DB::select('select id from fichehors order by id DESC limit 1');
        $ventil = DB::select('select * from ventilationfinals where idUser = ?',[$session_id]);
        $horSemLun = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Lundi"',[$session_id]);
        $horSemMar = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Mardi"',[$session_id]);
        $horSemMer = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Mercredi"',[$session_id]);
        $horSemJeu = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Jeudi"',[$session_id]);
        $horSemVen = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Vendredi"',[$session_id]);
        $horSemSam = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Samedi"',[$session_id]);
        $horSemDim = DB::select('select DM,FM,DA,FA,DS,FS from semainetypes where idUser = ? AND jour="Dimanche"',[$session_id]);
        foreach ($horSemLun as $horLun) {
            $debutMLundi=$horLun->DM;
            $finMLundi=$horLun->FM;
            $debutALundi=$horLun->DA;
            $finALundi=$horLun->FA;
            $debutSLundi=$horLun->DS;
            $finSLundi=$horLun->FS;
        }
        foreach ($horSemMar as $horMar) {
            $debutMMardi=$horMar->DM;
            $finMMardi=$horMar->FM;
            $debutAMardi=$horMar->DA;
            $finAMardi=$horMar->FA;
            $debutSMardi=$horMar->DS;
            $finSMardi=$horMar->FS;
        }
        foreach ($horSemMer as $horMer) {
            $debutMMercredi=$horMer->DM;
            $finMMercredi=$horMer->FM;
            $debutAMercredi=$horMer->DA;
            $finAMercredi=$horMer->FA;
            $debutSMercredi=$horMer->DS;
            $finSMercredi=$horMer->FS;
        }
        foreach ($horSemJeu as $horJeu) {
            $debutMJeudi=$horJeu->DM;
            $finMJeudi=$horJeu->FM;
            $debutAJeudi=$horJeu->DA;
            $finAJeudi=$horJeu->FA;
            $debutSJeudi=$horJeu->DS;
            $finSJeudi=$horJeu->FS;
        }
        foreach ($horSemVen as $horVen) {
            $debutMVendredi=$horVen->DM;
            $finMVendredi=$horVen->FM;
            $debutAVendredi=$horVen->DA;
            $finAVendredi=$horVen->FA;
            $debutSVendredi=$horVen->DS;
            $finSVendredi=$horVen->FS;
        }
        foreach ($horSemSam as $horSam) {
            $debutMSamedi=$horSam->DM;
            $finMSamedi=$horSam->FM;
            $debutASamedi=$horSam->DA;
            $finASamedi=$horSam->FA;
            $debutSSamedi=$horSam->DS;
            $finSSamedi=$horSam->FS;
        }
        foreach ($horSemDim as $horDim) {
            $debutMDimanche=$horDim->DM;
            $finMDimanche=$horDim->FM;
            $debutADimanche=$horDim->DA;
            $finADimanche=$horDim->FA;
            $debutSDimanche=$horDim->DS;
            $finSDimanche=$horDim->FS;
        }
        
        if ($last)
        {
            $lastt=1;
        }
        else{
            $lastt=0;
        }
        return view('USER/ficheHoraireUpdate',['affichage'=>$affichage,'last'=>$last,'lastt'=>$lastt,'activites'=>$activites,'ventil'=>$ventil,
        'debutMLundi'=>$debutMLundi,'finMLundi'=>$finMLundi,'debutALundi'=>$debutALundi,'finALundi'=>$finALundi,'debutSLundi'=>$debutSLundi,'finSLundi'=>$finSLundi,
        'debutMMardi'=>$debutMMardi,'finMMardi'=>$finMMardi,'debutAMardi'=>$debutAMardi,'finAMardi'=>$finAMardi,'debutSMardi'=>$debutSMardi,'finSMardi'=>$finSMardi,
        'debutMMercredi'=>$debutMMercredi,'finMMercredi'=>$finMMercredi,'debutAMercredi'=>$debutAMercredi,'finAMercredi'=>$finAMercredi,'debutSMercredi'=>$debutSMercredi,'finSMercredi'=>$finSMercredi,
        'debutMJeudi'=>$debutMJeudi,'finMJeudi'=>$finMJeudi,'debutAJeudi'=>$debutAJeudi,'finAJeudi'=>$finAJeudi,'debutSJeudi'=>$debutSJeudi,'finSJeudi'=>$finSJeudi,
        'debutMVendredi'=>$debutMVendredi,'finMVendredi'=>$finMVendredi,'debutAVendredi'=>$debutAVendredi,'finAVendredi'=>$finAVendredi,'debutSVendredi'=>$debutSVendredi,'finSVendredi'=>$finSVendredi,
        'debutMSamedi'=>$debutMSamedi,'finMSamedi'=>$finMSamedi,'debutASamedi'=>$debutASamedi,'finASamedi'=>$finASamedi,'debutSSamedi'=>$debutSSamedi,'finSSamedi'=>$finSSamedi,
        'debutMDimanche'=>$debutMDimanche,'finMDimanche'=>$finMDimanche,'debutADimanche'=>$debutADimanche,'finADimanche'=>$finADimanche,'debutSDimanche'=>$debutSDimanche,'finSDimanche'=>$finSDimanche
    ]);
            }
    
    public function nextD($id) {
        $id=$id+1;
        $last = DB::select('select id from fichehors order by id DESC limit 1');
        $affichage = DB::select('select * from fichehors where id = ?',[$id]);
        return view('USER/ficheHoraireUpdate',['affichage'=>$affichage,'last'=>$last]);
            }

    public function addDays() {
        $fiche = new fichehor();
        $fiche->Date = request('date1');
        $fiche->idfiche = request('idfiche');
        $user=Auth::user();
        $session_id = $user->identifiant;
        $semainetype=DB::select('select * from semainetypes where idUser=?',[$session_id]);
        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-01', strtotime("first day of this month"));
        $dateF = date('d', strtotime("last day of this month"));
        $date2 = date('l', strtotime($date));
        $month = date('n', strtotime($date));
        $month2 = date('m', strtotime($date));
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
            if($i <= 7){
                $week = "semaine 1";
            }
            elseif($i>7 and $i<=14){
                $week = "semaine 2";
            }
            elseif($i>14 and $i<=21){
                $week = "semaine 3";
            }
            elseif($i>21 and $i<=28){
                $week = "semaine 4";
            }
            elseif($i>28){
                $week = "semaine 5";
            }

            $idF=  $year_num." - ".$month;
            $dateBD= $day_name." ".$day_num." ".$month;

            DB::insert('insert into fichehors (idfiche,Date,idUser,semaine,mois) values (?,?,?,?,?)', [$idF,$dateBD,$session_id,$week,$month2]);
            $fiches=DB::select('select * from fichehors where idUser=? and idfiche=?',[$session_id,$idF]);
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Lun')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Lundi" AND f.Date LIKE "%Lun%"');
                }
                else if(str_contains($fi->Date, 'Mar')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Mardi" AND f.Date LIKE "%Mar%"');
                }
                else if(str_contains($fi->Date, 'Mer')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Mercredi" AND f.Date LIKE "%Mer%"');
                }
                else if(str_contains($fi->Date, 'Jeu')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Jeudi" AND f.Date LIKE "%Jeu%"');
                }
                else if(str_contains($fi->Date, 'Ven')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Vendredi" AND f.Date LIKE "%Ven%"');
                }
                else if(str_contains($fi->Date, 'Sam')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Samedi" AND f.Date LIKE "%Sam%"');
                }
                else if(str_contains($fi->Date, 'Dim')){
                    DB::update('UPDATE
                    fichehors f,
                    semainetypes s
                SET
                   f.Poids = s.poidsJour
                WHERE
                    f.idUser = s.idUser AND s.jour="Dimanche" AND f.Date LIKE "%Dim%"');
                }
            }
        }
        return redirect()->back();
        }

    public function index(){
        date_default_timezone_set('Europe/Paris');
        $user=Auth::user();
        $activites=DB::select('select * from activites');
        $session_id = $user->identifiant;
        $fichehor = DB::select('select * from fichehors where idUser = ?',[$session_id]);
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%Mandataires%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%Mandataires%')->count() <= 0)
            {ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"Mandataires"'],
                ['ventilation' => 'Mandataires']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="MANDA" where idUser = ? and ventilation="Mandataires"',
            [$session_id]);
        }
        }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%Mandataires%')->delete();
        }
       if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%DELEGATION%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%DELEGATION%')->count() <= 0)
            {ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"DELEGATION"'],
                ['ventilation' => 'DELEGATION']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="DELEG" where idUser = ? and ventilation="DELEGATION"',
            [$session_id]);
        }
        }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%DELEGATION%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%FRASAD%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%FRASAD%')->count() <= 0)
            {
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"FRASAD"'],
                ['ventilation' => 'FRASAD']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="FRAS" where idUser = ? and ventilation="FRASAD"',
            [$session_id]);
        }
        }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%FRASAD%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%Entraide%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%Entraide familiale%')->count() <= 0)
                {
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"Entraide familiale"'],
                ['ventilation' => 'Entraide familiale']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="ENTRAI" where idUser = ? and ventilation="Entraide familiale"',
            [$session_id]);
        }
        }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%Entraide familiale%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%Federation%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%Federation%')->count() <= 0)
                    {
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"Federation"'],
                ['ventilation' => 'Federation']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="FEDE" where idUser = ? and ventilation="Federation"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%Federation%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%Prestataire%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%prestataire%')->count() <= 0)
{
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"prestataire"'],
                ['ventilation' => 'prestataire']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="PRES" where idUser = ? and ventilation="prestataire"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%prestataire%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%Voisineurs%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%voisineurs%')->count() <= 0)
                {
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"voisineurs"'],
                ['ventilation' => 'voisineurs']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="VOISI" where idUser = ? and ventilation="voisineurs"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%voisineurs%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%ADU%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%ADU services%')->count() <= 0)
{
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"ADU services"'],
                ['ventilation' => 'ADU services']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="ADU" where idUser = ? and ventilation="ADU services"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%ADU%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%SOS%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%SOS Garde d\'enfants')->count() <= 0)
{
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"SOS Garde d\'enfants"'],
                ['ventilation' => 'SOS Garde d\'enfants']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="SOS" where idUser = ? and ventilation="SOS Garde d\'enfants"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%SOS%')->delete();
        }
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%ADVM%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%ADVM%')->count() <= 0)
{
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"ADVM"'],
                ['ventilation' => 'ADVM']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="ADVM" where idUser = ? and ventilation="ADVM"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'like', '%ADVM%')->delete();
        }
        foreach ($fichehor as $fi) {
            $DateFiche=$fi->Date;
            $ecartJour=$fi->heuresEffectu-$fi->Poids;
            DB::update('update fichehors set ecart=? where idUser = ? AND Date=?',
            [$ecartJour,$session_id,$DateFiche]);
        }
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
        $ajout=0;
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
        if (!$affichage->isEmpty())
        {
            $ajout=1;
        }
        else{
            $ajout=0;
        }
        return view('USER.ficheHoraire',[ 'employes' =>$employes,'date' =>$date,'date2' =>$date2,'dateF' =>$dateF,'month' =>$month,
        'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'samedi' =>$samedi,
        'dimanche' =>$dimanche,'affichage' => $affichage,'p'=>$p,'f'=>$f,'totEcart'=>$totEcart,'ajout'=>$ajout,'activites'=>$activites,
        ]);
    }

    public function edit(Request $request,$id) {
        $user=Auth::user();
        $session_id = $user->identifiant;
        $fichehor = DB::select('select * from fichehors where idUser = ?',[$session_id]);
        $ventil = DB::select('select * from ventilationfinals where idUser = ?',[$session_id]);
        $matinD = $request->input('morningS');
        $matinF = $request->input('morningF');
        $ApremD = $request->input('ApremS');
        $ApremF = $request->input('ApremF');
        $soirD = $request->input('soirS');
        $soirF = $request->input('soirF');
        $activite1 = $request->input('TM');
        $activite2 = $request->input('TAP');
        $activite3 = $request->input('TS');
        $typeJour = $request->input('typeJour');
        $ventilationNom = $request->input('ventilationNom');
        $DELEGATION = $request->input('DELEG');
        $FRASAD = $request->input('FRAS');
        $Entraide = $request->input('ENTRAI');
        $Federation = $request->input('FEDE');
        $prestataire = $request->input('PRES');
        $voisineurs = $request->input('VOISI');
        $ADU = $request->input('ADU');
        $SOS = $request->input('SOS');
        $ADVM = $request->input('ADVM');
        $Mandataires = $request->input('MANDA');
        $matin = $matinD ." - " .$matinF;
        $aprem = $ApremD ." - " .$ApremF;
        $soir = $soirD ." - " .$soirF;
        $hourdiffMat = round((strtotime($matinF) - strtotime($matinD ))/3600, 1);
        $hourdiffAprem = round((strtotime($ApremF) - strtotime($ApremD))/3600, 1);
        $hourdiffSoir = round((strtotime($soirF) - strtotime($soirD))/3600, 1);
        $pauseMidi = round((strtotime($ApremD) - strtotime($matinF ))/3600, 1);
        $heuresEffectu = $hourdiffMat + $hourdiffAprem + $hourdiffSoir;
        $poids= $DELEGATION+$FRASAD+$Entraide+$Federation+$prestataire+$voisineurs+$ADU+$SOS+$ADVM+$Mandataires;
        $ecart=0;
        echo $pauseMidi;
        if($heuresEffectu!=$poids){
            $message="u cant";
        }
        if(!isset($message))
        {
            if($hourdiffMat!=0 and $hourdiffAprem!=0){
            if($pauseMidi>=0.8){
        DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
        soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
        activite3=?,ecart=?,typeJour=? where id = ?',
        [$matinD,$matinF,$ApremD,$ApremF,$soirD,$soirF,$matin,$heuresEffectu,$activite1,$aprem,
        $soir,$activite2,$activite3,$ecart,$typeJour,$id]);
        foreach ($ventil as $v) {
            if($v->ventilation == "DELEGATION"){
                DB::update('update fichehors set DELEGATION=? where id = ?',
                [$DELEGATION,$id]);
            }
            if($v->ventilation == "SOS Garde d'enfants"){
                DB::update('update fichehors set SOSgarde=? where id = ?',
                [$SOS,$id]);
            }
            if($v->ventilation == "FRASAD"){
                DB::update('update fichehors set FRASAD=? where id = ?',
                [$FRASAD,$id]);
            }
            if($v->ventilation == "Entraide familiale"){
                DB::update('update fichehors set EntraideFamiliale=? where id = ?',
                [$Entraide,$id]);
            }
            if($v->ventilation == "Federation"){
                DB::update('update fichehors set Federation=? where id = ?',
                [$Federation,$id]);
            }
            if($v->ventilation == "Mandataires"){
                DB::update('update fichehors set Mandataires=? where id = ?',
                [$Mandataires,$id]);
            }
            if($v->ventilation == "ADVM"){
                DB::update('update fichehors set ADVM=? where id = ?',
                [$ADVM,$id]);
            }
            if($v->ventilation == "ADU services"){
                DB::update('update fichehors set ADUservices=? where id = ?',
                [$ADU,$id]);
            }
            if($v->ventilation == "voisineurs"){
                DB::update('update fichehors set Voisineurs=? where id = ?',
                [$voisineurs,$id]);
            }
            if($v->ventilation == "prestataire"){
                DB::update('update fichehors set Prestataire=? where id = ?',
                [$prestataire,$id]);
            }
            }
            return redirect()->action(
                [FicheHoraireUserController::class, 'index']
            );
    }
        else{
            return redirect()->back()->with('status', 'La durée de pause doit être supérieur à 45min');
        }}
        else{
            DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
        soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
        activite3=?,ecart=?,typeJour=? where id = ?',
        [$matinD,$matinF,$ApremD,$ApremF,$soirD,$soirF,$matin,$heuresEffectu,$activite1,$aprem,
        $soir,$activite2,$activite3,$ecart,$typeJour,$id]);
        foreach ($ventil as $v) {
            if($v->ventilation == "DELEGATION"){
                DB::update('update fichehors set DELEGATION=? where id = ?',
                [$DELEGATION,$id]);
            }
            if($v->ventilation == "SOS Garde d'enfants"){
                DB::update('update fichehors set SOSgarde=? where id = ?',
                [$SOS,$id]);
            }
            if($v->ventilation == "FRASAD"){
                DB::update('update fichehors set FRASAD=? where id = ?',
                [$FRASAD,$id]);
            }
            if($v->ventilation == "Entraide familiale"){
                DB::update('update fichehors set EntraideFamiliale=? where id = ?',
                [$Entraide,$id]);
            }
            if($v->ventilation == "Federation"){
                DB::update('update fichehors set Federation=? where id = ?',
                [$Federation,$id]);
            }
            if($v->ventilation == "Mandataires"){
                DB::update('update fichehors set Mandataires=? where id = ?',
                [$Mandataires,$id]);
            }
            if($v->ventilation == "ADVM"){
                DB::update('update fichehors set ADVM=? where id = ?',
                [$ADVM,$id]);
            }
            if($v->ventilation == "ADU services"){
                DB::update('update fichehors set ADUservices=? where id = ?',
                [$ADU,$id]);
            }
            if($v->ventilation == "voisineurs"){
                DB::update('update fichehors set Voisineurs=? where id = ?',
                [$voisineurs,$id]);
            }
            if($v->ventilation == "prestataire"){
                DB::update('update fichehors set Prestataire=? where id = ?',
                [$prestataire,$id]);
            }
            }
            return redirect()->action(
                [FicheHoraireUserController::class, 'index']
            );
        }
        }
        else{
            return redirect()->back()->with('status', 'Le nombre d\'heures effectués est invalide');
        }

}
}
