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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;




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
        $ventilations = DB::select('select * from ventilations where idUser = ?',[$session_id]);
        $MANDA=0;
        $FRAS=0;
        $ENTRAI=0;
        $FEDE=0;
        $PRES=0;
        $VOISI=0;
        $ADU=0;
        $SOS=0;
        $ADVM=0;
        $DELEG=0;
        $AI=0;
        foreach ($ventilations as $v) {
            if(str_contains($v->ventilation, "Mandataires")){
                $MANDA=1;
            }
            if(str_contains($v->ventilation, "FRASAD")){
                $FRAS=1;
            }
            if(str_contains($v->ventilation, "Entraide")){
                $ENTRAI=1;
            }
            if(str_contains($v->ventilation, "Federation")){
                $FEDE=1;
            }
            if(str_contains($v->ventilation, "Prestataire")){
                $PRES=1;
            }
            if(str_contains($v->ventilation, "Voisineurs")){
                $VOISI=1;
            }
            if(str_contains($v->ventilation, "ADU")){
                $ADU=1;
            }
            if(str_contains($v->ventilation, "SOS")){
                $SOS=1;
            }
            if(str_contains($v->ventilation, "ADVM")){
                $ADVM=1;
            }
            if(str_contains($v->ventilation, "DELEGATION")){
                $DELEG=1;
            }
            if(str_contains($v->ventilation, "AI")){
                $AI=1;
            }
        }
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
        'debutMDimanche'=>$debutMDimanche,'finMDimanche'=>$finMDimanche,'debutADimanche'=>$debutADimanche,'finADimanche'=>$finADimanche,'debutSDimanche'=>$debutSDimanche,'finSDimanche'=>$finSDimanche,
        'MANDA'=>$MANDA,'FRAS'=>$FRAS,'ENTRAI'=>$ENTRAI,'FEDE'=>$FEDE,
        'PRES'=>$PRES,'VOISI'=>$VOISI,'ADU'=>$ADU,'SOS'=>$SOS,'ADVM'=>$ADVM,'DELEG'=>$DELEG,'AI'=>$AI
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

            DB::insert('insert into fichehors (idfiche,Date,idUser,semaine,mois,year) values (?,?,?,?,?,?)', [$idF,$dateBD,$session_id,$week,$month2,$year_num]);
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
        if(ventilation::where('idUser', $session_id)->where('ventilation', 'like', '%AI%')->count() > 0)
        {
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation','AI')->count() <= 0)
{
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => "'AI'"],
                ['ventilation' => 'AI']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="AI" where idUser = ? and ventilation="AI"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation', 'AI')->delete();
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
        $ferie=0;
        $TR=0;
        $CP=0;
        $RTT=0;
        $HRTT=0;
        $RCR=0;
        $FOR=0;
        $MAL=0;
        $CF=0;
        $SS=0;
        $JS=0;
        foreach ($affichage as $fi) {

                if($fi->typeJour=="Férié"){
                    $ferie=$ferie+1;
                }
                else if($fi->typeJour=="Travaillé"){
                    $TR=$TR+1;
                }
                else if($fi->typeJour=="CP"){
                    $CP=$CP+1;
                }
                else if($fi->typeJour=="RTT"){
                    $RTT=$RTT+1;
                }

                else if($fi->typeJour=="1/2 RTT"){
                    $HRTT=$HRTT+1;
                }

                else if($fi->typeJour=="RCR"){
                    $RCR=$RCR+1;
                }

                else if($fi->typeJour=="Formation"){
                    $FOR=$FOR+1;
                }
                else if($fi->typeJour=="Maladie"){
                    $MAL=$MAL+1;
                }
                else if($fi->typeJour=="Congés familiaux"){
                    $CF=$CF+1;
                }
                else if($fi->typeJour=="Sans soldes"){
                    $SS=$SS+1;
                }
                else if($fi->typeJour=="Jour solidarité"){
                    $JS=$JS+1;
                }
        }
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
        'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
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
        $AI = $request->input('AI');
        $matin = $matinD ." - " .$matinF;
        $aprem = $ApremD ." - " .$ApremF;
        $soir = $soirD ." - " .$soirF;
        $hourdiffMat = $matinF-$matinD;
        $hourdiffAprem = $ApremF-$ApremD;
        $hourdiffSoir = $soirF-$soirD;
        $pauseMidi = $ApremD-$matinF;
        $heuresEffectu = $hourdiffMat + $hourdiffAprem + $hourdiffSoir;
        $poids= $DELEGATION+$FRASAD+$Entraide+$Federation+$prestataire+$voisineurs+$ADU+$SOS+$ADVM+$Mandataires+$AI;
        $ecart=0;
        echo $pauseMidi;
        if($heuresEffectu>11){
            return redirect()->back()->with('status', 'La durée du jour ne peut pas être supérieur à 11 heures');
        }
        if($hourdiffMat>=6){
            return redirect()->back()->with('status', 'La durée de matin ne peut pas être supérrieure à 6heures');
        }elseif($hourdiffAprem>=6){
            return redirect()->back()->with('status', 'La durée de l\'après-midi ne peut pas être supérrieure à 6heures');
        }elseif($hourdiffSoir>=6){
            return redirect()->back()->with('status', 'La durée de soir ne peut pas être supérrieure à 6heures');
        }
        if($heuresEffectu!=$poids){
            $message="u cant";
        }
        if($matinF==null OR $ApremD==null){
            if(!isset($message))
            {
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
                if($v->ventilation == "AI"){
                    DB::update('update fichehors set AI=? where id = ?',
                    [$AI,$id]);
                }
                }
                return redirect()->action(
                    [FicheHoraireUserController::class, 'index']
                );
                }else{
                    // return redirect()->back()->with('status', 'le nombre d\'heures effectués est invalide');
                    return back()->withInput($request->all())->with('status', 'le nombre d\'heures effectués est invalide');
                 }
        }else{
        if(!isset($message))
        {
            if($pauseMidi<0.750){
                    return back()->withInput($request->all())->with('status', 'La durée de pause doit être supérieur à 45min');
            }else{
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
            if($v->ventilation == "AI"){
                DB::update('update fichehors set AI=? where id = ?',
                [$AI,$id]);
            }
            }
            return redirect()->action(
                [FicheHoraireUserController::class, 'index']
            );
            }}
            else{
                // return redirect()->back()->with('status', 'le nombre d\'heures effectués est invalide');
                return back()->withInput($request->all())->with('status', 'le nombre d\'heures effectués est invalide');
             }
        }


}

public function mesStats(Request $request) {
    $user=Auth::user();
    $session_str = $user->service;
    $session_id = $user->identifiant;
    $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = ? ORDER BY id DESC LIMIT 1',[$session_id]);
    $fiche = DB::select('select * from fichehors where idUser = ?',[$session_id]);
    $date = date('Y-m-01', strtotime("first day of this month"));
    $year = date('Y', strtotime($date));
    $depassementJan =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Janvier%"',[$session_id]);
    $depassementFev =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Février%"',[$session_id]);
    $depassementMar =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Mars%"',[$session_id]);
    $depassementAvr =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Avril%"',[$session_id]);
    $depassementMai =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Mai%"',[$session_id]);
    $depassementJuin =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Juin%"',[$session_id]);
    $depassementJuillet =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Juillet%"',[$session_id]);
    $depassementAout =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Août%"',[$session_id]);
    $depassementSept =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Septembre%"',[$session_id]);
    $depassementOct =  DB::select('select * from depassements where identifiant =? and
    idFiche LIKE "%Octobre%"',[$session_id]);
    $depassementNov =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Novembre%"',[$session_id]);
    $depassementDec =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Décembre%"',[$session_id]);
    $DJan=0;
    $DFev=0;
    $DMar=0;
    $DAvr=0;
    $DMai=0;
    $DJuin=0;
    $DJuil=0;
    $DAout=0;
    $DSept=0;
    $DOct=0;
    $DNov=0;
    $DDec=0;
    foreach($depassementJan as $depJan)
    {
        if(str_contains($depJan->idFiche, $year)){
            $DJan=$DJan+$depJan->nombreH;
        }
    }
    foreach($depassementFev as $depFev)
    {
        if(str_contains($depFev->idFiche, $year)){
            $DFev=$DFev+$depFev->nombreH;
        }
    }
    foreach($depassementMar as $depMar)
    {
        if(str_contains($depMar->idFiche, $year)){
            $DMar=$DMar+$depMar->nombreH;
        }
    }
    foreach($depassementAvr as $depAvr)
    {
        if(str_contains($depAvr->idFiche, $year)){
            $DAvr=$DAvr+$depAvr->nombreH;
        }
    }
    foreach($depassementMai as $depMai)
    {
        if(str_contains($depMai->idFiche, $year)){
            $DMai=$DMai+$depMai->nombreH;
        }
    }
    foreach($depassementJuin as $depJuin)
    {
        if(str_contains($depJuin->idFiche, $year)){
            $DJuin=$DJuin+$depJuin->nombreH;
        }
    }
    foreach($depassementJuillet as $depJuil)
    {
        if(str_contains($depJuil->idFiche, $year)){
            $DJuil=$DJuil+$depJuil->nombreH;
        }
    }
    foreach($depassementAout as $depAou)
    {
        if(str_contains($depAou->idFiche, $year)){
            $DAout=$DAout+$depAou->nombreH;
        }
    }
    foreach($depassementSept as $depSept)
    {
        if(str_contains($depSept->idFiche, $year)){
            $DSept=$DSept+$depSept->nombreH;
        }
    }
    foreach($depassementOct as $depOct)
    {
        if(str_contains($depOct->idFiche, $year)){
            $DJan=$DJan+$depOct->nombreH;
        }
    }
    foreach($depassementNov as $depNov)
    {
        if(str_contains($depNov->idFiche, $year)){
            $DNov=$DNov+$depNov->nombreH;
        }
    }
    foreach($depassementDec as $depDec)
    {
        if(str_contains($depDec->idFiche, $year)){
            $DDec=$DDec+$depDec->nombreH;
        }
    }
    $FRASAD=0;
    $Entraide=0;	
    $Fédération=0;
    $Prestataire=0;
    $Voisineurs	=0;
    $ADU=0;
    $Mandataires=0;	
    $SOS=0;	
    $ADVM=0;	
    $Délégation=0;
    $AI=0;
    $poids=0;
    $ferie=0;
    $TR=0;
    $CP=0;
    $RTT=0;
    $HRTT=0;
    $RCR=0;
    $FOR=0;
    $MAL=0;
    $CF=0;
    $SS=0;
    $JS=0;
    foreach ($fiche as $fi) {
        if(str_contains($fi->idfiche, $year)){
        $Délégation=$fi->DELEGATION+$Délégation;
        $FRASAD=$fi->FRASAD+$FRASAD;
        $Entraide=$fi->EntraideFamiliale+$Entraide;
        $Fédération=$fi->Federation+$Fédération;
        $Prestataire=$fi->Prestataire+$Prestataire;
        $Voisineurs=$fi->Voisineurs+$Voisineurs;
        $ADU=$fi->ADUservices+$ADU;
        $Mandataires=$fi->Mandataires+$Mandataires;
        $SOS=$fi->SOSgarde+$SOS;
        $ADVM=$fi->ADVM+$ADVM;
        $AI=$fi->AI+$AI;
        $poids=$fi->Poids+$poids;
        }
    }
    foreach ($fiche as $fi) {
        if(str_contains($fi->idfiche, $year)){
            if($fi->typeJour=="Férié"){
                $ferie=$ferie+1;
            }
            else if($fi->typeJour=="Travaillé"){
                $TR=$TR+1;
            }
            else if($fi->typeJour=="CP"){
                $CP=$CP+1;
            }
            else if($fi->typeJour=="RTT"){
                $RTT=$RTT+1;
            }

            else if($fi->typeJour=="1/2 RTT"){
                $HRTT=$HRTT+1;
            }

            else if($fi->typeJour=="RCR"){
                $RCR=$RCR+1;
            }

            else if($fi->typeJour=="Formation"){
                $FOR=$FOR+1;
            }
            else if($fi->typeJour=="Maladie"){
                $MAL=$MAL+1;
            }
            else if($fi->typeJour=="Congés familiaux"){
                $CF=$CF+1;
            }
            else if($fi->typeJour=="Sans soldes"){
                $SS=$SS+1;
            }
            else if($fi->typeJour=="Jour solidarité"){
                $JS=$JS+1;
            }


        }
    }
    $FerieJan=0;
    $TRJan=0;
    $CPJan=0;
    $RTTJan=0;
    $HRTTJan=0;
    $RCRJan=0;
    $FORJan=0;
    $MALJan=0;
    $CFJan=0;
    $SSJan=0;
    $JSJan=0;
    $FerieFev=0;
    $TRFev=0;
    $CPFev=0;
    $RTTFev=0;
    $HRTTFev=0;
    $RCRFev=0;
    $FORFev=0;
    $MALFev=0;
    $CFFev=0;
    $SSFev=0;
    $JSFev=0;
    $FerieMar=0;
    $TRMar=0;
    $CPMar=0;
    $RTTMar=0;
    $HRTTMar=0;
    $RCRMar=0;
    $FORMar=0;
    $MALMar=0;
    $CFMar=0;
    $SSMar=0;
    $JSMar=0;
    $FerieAvr=0;
    $TRAvr=0;
    $CPAvr=0;
    $RTTAvr=0;
    $HRTTAvr=0;
    $RCRAvr=0;
    $FORAvr=0;
    $MALAvr=0;
    $CFAvr=0;
    $SSAvr=0;
    $JSAvr=0;
    $FerieMai=0;
    $TRMai=0;
    $CPMai=0;
    $RTTMai=0;
    $HRTTMai=0;
    $RCRMai=0;
    $FORMai=0;
    $MALMai=0;
    $CFMai=0;
    $SSMai=0;
    $JSMai=0;
    $FerieJuin=0;
    $TRJuin=0;
    $CPJuin=0;
    $RTTJuin=0;
    $HRTTJuin=0;
    $RCRJuin=0;
    $FORJuin=0;
    $MALJuin=0;
    $CFJuin=0;
    $SSJuin=0;
    $JSJuin=0;
    $FerieJuillet=0;
    $TRJuillet=0;
    $CPJuillet=0;
    $RTTJuillet=0;
    $HRTTJuillet=0;
    $RCRJuillet=0;
    $FORJuillet=0;
    $MALJuillet=0;
    $CFJuillet=0;
    $SSJuillet=0;
    $JSJuillet=0;
    $FerieAout=0;
    $TRAout=0;
    $CPAout=0;
    $RTTAout=0;
    $HRTTAout=0;
    $RCRAout=0;
    $FORAout=0;
    $MALAout=0;
    $CFAout=0;
    $SSAout=0;
    $JSAout=0;
    $FerieSeptembre=0;
    $TRSeptembre=0;
    $CPSeptembre=0;
    $RTTSeptembre=0;
    $HRTTSeptembre=0;
    $RCRSeptembre=0;
    $FORSeptembre=0;
    $MALSeptembre=0;
    $CFSeptembre=0;
    $SSSeptembre=0;
    $JSSeptembre=0;
    $FerieOctobre=0;
    $TROctobre=0;
    $CPOctobre=0;
    $RTTOctobre=0;
    $HRTTOctobre=0;
    $RCROctobre=0;
    $FOROctobre=0;
    $MALOctobre=0;
    $CFOctobre=0;
    $SSOctobre=0;
    $JSOctobre=0;
    $FerieNovembre=0;
    $TRNovembre=0;
    $CPNovembre=0;
    $RTTNovembre=0;
    $HRTTNovembre=0;
    $RCRNovembre=0;
    $FORNovembre=0;
    $MALNovembre=0;
    $CFNovembre=0;
    $SSNovembre=0;
    $JSNovembre=0;
    $FerieDecembre=0;
    $TRDecembre=0;
    $CPDecembre=0;
    $RTTDecembre=0;
    $HRTTDecembre=0;
    $RCRDecembre=0;
    $FORDecembre=0;
    $MALDecembre=0;
    $CFDecembre=0;
    $SSDecembre=0;
    $JSDecembre=0;
    foreach ($fiche as $fi) {
        if(str_contains($fi->idfiche, $year)){
            if(str_contains($fi->idfiche, "Janvier")){
                if($fi->typeJour=="Férié"){
                $FerieJan=$FerieJan+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRJan=$TRJan+1;
                }
                else if($fi->typeJour=="CP"){
                $CPJan=$CPJan+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTJan=$RTTJan+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTJan=$HRTTJan+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRJan=$RCRJan+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORJan=$FORJan+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALJan=$MALJan+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFJan=$CFJan+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSJan=$SSJan+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSJan=$JSJan+1;
                }
            }
            else if(str_contains($fi->idfiche, "Février")){
                if($fi->typeJour=="Férié"){
                $FerieFev=$FerieFev+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRFev=$TRFev+1;
                }
                else if($fi->typeJour=="CP"){
                $CPFev=$CPFev+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTFev=$RTTFev+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTFev=$HRTTFev+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRFev=$RCRFev+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORFev=$FORFev+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALFev=$MALFev+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFFev=$CFFev+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSFev=$SSFev+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSFev=$JSFev+1;
                }
            }else if(str_contains($fi->idfiche, "Mars")){
                if($fi->typeJour=="Férié"){
                $FerieMar=$FerieMar+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRMar=$TRMar+1;
                }
                else if($fi->typeJour=="CP"){
                $CPMar=$CPMar+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTMar=$RTTMar+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTMar=$HRTTMar+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRMar=$RCRMar+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORMar=$FORMar+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALMar=$MALMar+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFMar=$CFMar+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSMar=$SSMar+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSMar=$JSMar+1;
                }
            }else if(str_contains($fi->idfiche, "Avril")){
                if($fi->typeJour=="Férié"){
                $FerieAvr=$FerieAvr+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRAvr=$TRAvr+1;
                }
                else if($fi->typeJour=="CP"){
                $CPAvr=$CPAvr+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTAvr=$RTTAvr+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTAvr=$HRTTAvr+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRAvr=$RCRAvr+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORAvr=$FORAvr+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALAvr=$MALAvr+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFAvr=$CFAvr+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSAvr=$SSAvr+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSAvr=$JSAvr+1;
                }
            }else if(str_contains($fi->idfiche, "Mai")){
                if($fi->typeJour=="Férié"){
                $FerieMai=$FerieMai+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRMai=$TRMai+1;
                }
                else if($fi->typeJour=="CP"){
                $CPMai=$CPMai+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTMai=$RTTMai+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTMai=$HRTTMai+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRMai=$RCRMai+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORMai=$FORMai+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALMai=$MALMai+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFMai=$CFMai+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSMai=$SSMai+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSMai=$JSMai+1;
                }
            }
            else if(str_contains($fi->idfiche, "Juin")){
                if($fi->typeJour=="Férié"){
                $FerieJuin=$FerieJuin+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRJuin=$TRJuin+1;
                }
                else if($fi->typeJour=="CP"){
                $CPJuin=$CPJuin+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTJuin=$RTTJuin+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTJuin=$HRTTJuin+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRJuin=$RCRJuin+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORJuin=$FORJuin+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALJuin=$MALJuin+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFJuin=$CFJuin+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSJuin=$SSJuin+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSJuin=$JSJuin+1;
                }
            }
            else if(str_contains($fi->idfiche, "Juillet")){
                if($fi->typeJour=="Férié"){
                $FerieJuillet=$FerieJuillet+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRJuillet=$TRJuillet+1;
                }
                else if($fi->typeJour=="CP"){
                $CPJuillet=$CPJuillet+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTJuillet=$RTTJuillet+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTJuillet=$HRTTJuillet+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRJuillet=$RCRJuillet+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORJuillet=$FORJuillet+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALJuillet=$MALJuillet+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFJuillet=$CFJuillet+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSJuillet=$SSJuillet+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSJuillet=$JSJuillet+1;
                }
            }
            else if(str_contains($fi->idfiche, "Août")){
                if($fi->typeJour=="Férié"){
                $FerieAout=$FerieAout+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRAout=$TRAout+1;
                }
                else if($fi->typeJour=="CP"){
                $CPAout=$CPAout+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTAout=$RTTAout+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTAout=$HRTTAout+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRAout=$RCRAout+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORAout=$FORAout+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALAout=$MALAout+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFAout=$CFAout+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSAout=$SSAout+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSAout=$JSAout+1;
                }
            }
            else if(str_contains($fi->idfiche, "Septembre")){
                if($fi->typeJour=="Férié"){
                $FerieSeptembre=$FerieSeptembre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRSeptembre=$TRSeptembre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPSeptembre=$CPSeptembre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTSeptembre=$RTTSeptembre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTSeptembre=$HRTTSeptembre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRSeptembre=$RCRSeptembre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORSeptembre=$FORSeptembre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALSeptembre=$MALSeptembre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFSeptembre=$CFSeptembre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSSeptembre=$SSSeptembre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSSeptembre=$JSSeptembre+1;
                }
            }
            else if(str_contains($fi->idfiche, "Octobre")){
                if($fi->typeJour=="Férié"){
                $FerieOctobre=$FerieOctobre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TROctobre=$TROctobre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPOctobre=$CPSOctobre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTOctobre=$RTTOctobre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTOctobre=$HRTTOctobre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCROctobre=$RCROctobre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FOROctobre=$FOROctobre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALOctobre=$MALOctobre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFOctobre=$CFOctobre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSOctobre=$SSOctobre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSOctobre=$JSOctobre+1;
                }
            }
            else if(str_contains($fi->idfiche, "Novembre")){
                if($fi->typeJour=="Férié"){
                $FerieNovembre=$FerieNovembre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRNovembre=$TRNovembre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPNovembre=$CPNovembre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTNovembre=$RTTNovembre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTNovembre=$HRTTNovembre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRNovembre=$RCRNovembre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORNovembre=$FORNovembre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALNovembre=$MALNovembre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFNovembre=$CFNovembre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSNovembre=$SSNovembre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSNovembre=$JSNovembre+1;
                }
            }
            else if(str_contains($fi->idfiche, "Décembre")){
                if($fi->typeJour=="Férié"){
                $FerieDecembre=$FerieDecembre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRDecembre=$TRDecembre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPDecembre=$CPDecembre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTDecembre=$RTTDecembre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTDecembre=$HRTTDecembre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRDecembre=$RCRDecembre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORDecembre=$FORDecembre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALDecembre=$MALDecembre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFDecembre=$CFDecembre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSDecembre=$SSDecembre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSDecembre=$JSDecembre+1;
                }
            }
            
    }
}
    $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM+$AI;
    $diff=$poids-$totalVentil;
    if(!Gate::any(['access-admin', 'access-direction'])){
        return view('USER/statistiquesUser',['fiche'=>$fiche,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
    'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,'AI'=>$AI,
    'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'year'=>$year
    ,'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
    'FerieJan'=>$FerieJan,'TRJan'=>$TRJan,'CPJan'=>$CPJan,'RTTJan'=>$RTTJan,'HRTTJan'=>$HRTTJan,'RCRJan'=>$RCRJan,'FORJan'=>$FORJan,
    'MALJan'=>$MALJan,'CFJan'=>$CFJan,'SSJan'=>$SSJan,'JSJan'=>$JSJan,
    'FerieFev'=>$FerieFev,'TRFev'=>$TRFev,'CPFev'=>$CPFev,'RTTFev'=>$RTTFev,'HRTTFev'=>$HRTTFev,'RCRFev'=>$RCRFev,'FORFev'=>$FORFev,
    'MALFev'=>$MALFev,'CFFev'=>$CFFev,'SSFev'=>$SSFev,'JSFev'=>$JSFev,
    'FerieMar'=>$FerieMar,'TRMar'=>$TRMar,'CPMar'=>$CPMar,'RTTMar'=>$RTTMar,'HRTTMar'=>$HRTTMar,'RCRMar'=>$RCRMar,'FORMar'=>$FORMar,
    'MALMar'=>$MALMar,'CFMar'=>$CFMar,'SSMar'=>$SSMar,'JSMar'=>$JSMar,
    'FerieAvr'=>$FerieAvr,'TRAvr'=>$TRAvr,'CPAvr'=>$CPAvr,'RTTAvr'=>$RTTAvr,'HRTTAvr'=>$HRTTAvr,'RCRAvr'=>$RCRAvr,'FORAvr'=>$FORAvr,
    'MALAvr'=>$MALAvr,'CFAvr'=>$CFAvr,'SSAvr'=>$SSAvr,'JSAvr'=>$JSAvr,
    'FerieMai'=>$FerieMai,'TRMai'=>$TRMai,'CPMai'=>$CPMai,'RTTMai'=>$RTTMai,'HRTTMai'=>$HRTTMai,'RCRMai'=>$RCRMai,'FORMai'=>$FORMai,
    'MALMai'=>$MALMai,'CFMai'=>$CFMai,'SSMai'=>$SSMai,'JSMai'=>$JSMai,
    'FerieJuin'=>$FerieJuin,'TRJuin'=>$TRJuin,'CPJuin'=>$CPJuin,'RTTJuin'=>$RTTJuin,'HRTTJuin'=>$HRTTJuin,'RCRJuin'=>$RCRJuin,'FORJuin'=>$FORJuin,
    'MALJuin'=>$MALJuin,'CFJuin'=>$CFJuin,'SSJuin'=>$SSJuin,'JSJuin'=>$JSJuin,
    'FerieJuillet'=>$FerieJuillet,'TRJuillet'=>$TRJuillet,'CPJuillet'=>$CPJuillet,'RTTJuillet'=>$RTTJuillet,'HRTTJuillet'=>$HRTTJuillet,'RCRJuillet'=>$RCRJuillet,'FORJuillet'=>$FORJuillet,
    'MALJuillet'=>$MALJuillet,'CFJuillet'=>$CFJuillet,'SSJuillet'=>$SSJuillet,'JSJuillet'=>$JSJuillet,
    'FerieAout'=>$FerieAout,'TRAout'=>$TRAout,'CPAout'=>$CPAout,'RTTAout'=>$RTTAout,'HRTTAout'=>$HRTTAout,'RCRAout'=>$RCRAout,'FORAout'=>$FORAout,
    'MALAout'=>$MALAout,'CFAout'=>$CFAout,'SSAout'=>$SSAout,'JSAout'=>$JSAout,
    'FerieSeptembre'=>$FerieSeptembre,'TRSeptembre'=>$TRSeptembre,'CPSeptembre'=>$CPSeptembre,'RTTSeptembre'=>$RTTSeptembre,'HRTTSeptembre'=>$HRTTSeptembre,'RCRSeptembre'=>$RCRSeptembre,'FORSeptembre'=>$FORSeptembre,
    'MALSeptembre'=>$MALSeptembre,'CFSeptembre'=>$CFSeptembre,'SSSeptembre'=>$SSSeptembre,'JSSeptembre'=>$JSSeptembre,
    'FerieOctobre'=>$FerieOctobre,'TROctobre'=>$TROctobre,'CPOctobre'=>$CPOctobre,'RTTOctobre'=>$RTTOctobre,'HRTTOctobre'=>$HRTTOctobre,'RCROctobre'=>$RCROctobre,'FOROctobre'=>$FOROctobre,
    'MALOctobre'=>$MALOctobre,'CFOctobre'=>$CFOctobre,'SSOctobre'=>$SSOctobre,'JSOctobre'=>$JSOctobre,
    'FerieNovembre'=>$FerieNovembre,'TRNovembre'=>$TRNovembre,'CPNovembre'=>$CPNovembre,'RTTNovembre'=>$RTTNovembre,'HRTTNovembre'=>$HRTTNovembre,'RCRNovembre'=>$RCRNovembre,'FORNovembre'=>$FORNovembre,
    'MALNovembre'=>$MALNovembre,'CFNovembre'=>$CFNovembre,'SSNovembre'=>$SSNovembre,'JSNovembre'=>$JSNovembre,
    'FerieDecembre'=>$FerieDecembre,'TRDecembre'=>$TRDecembre,'CPDecembre'=>$CPDecembre,'RTTDecembre'=>$RTTDecembre,'HRTTDecembre'=>$HRTTDecembre,'RCRDecembre'=>$RCRDecembre,'FORDecembre'=>$FORDecembre,
    'MALDecembre'=>$MALDecembre,'CFDecembre'=>$CFDecembre,'SSDecembre'=>$SSDecembre,'JSDecembre'=>$JSDecembre,'DJan'=>$DJan,'DFev'=>$DFev,'DMar'=>$DMar,'DAvr'=>$DAvr,'DMai'=>$DMai,'DJuin'=>$DJuin,
    'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,
]);
        }
    return view('ADMIN/statistiquesUser',['fiche'=>$fiche,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
    'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,'AI'=>$AI,
    'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'year'=>$year
    ,'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
    'FerieJan'=>$FerieJan,'TRJan'=>$TRJan,'CPJan'=>$CPJan,'RTTJan'=>$RTTJan,'HRTTJan'=>$HRTTJan,'RCRJan'=>$RCRJan,'FORJan'=>$FORJan,
    'MALJan'=>$MALJan,'CFJan'=>$CFJan,'SSJan'=>$SSJan,'JSJan'=>$JSJan,
    'FerieFev'=>$FerieFev,'TRFev'=>$TRFev,'CPFev'=>$CPFev,'RTTFev'=>$RTTFev,'HRTTFev'=>$HRTTFev,'RCRFev'=>$RCRFev,'FORFev'=>$FORFev,
    'MALFev'=>$MALFev,'CFFev'=>$CFFev,'SSFev'=>$SSFev,'JSFev'=>$JSFev,
    'FerieMar'=>$FerieMar,'TRMar'=>$TRMar,'CPMar'=>$CPMar,'RTTMar'=>$RTTMar,'HRTTMar'=>$HRTTMar,'RCRMar'=>$RCRMar,'FORMar'=>$FORMar,
    'MALMar'=>$MALMar,'CFMar'=>$CFMar,'SSMar'=>$SSMar,'JSMar'=>$JSMar,
    'FerieAvr'=>$FerieAvr,'TRAvr'=>$TRAvr,'CPAvr'=>$CPAvr,'RTTAvr'=>$RTTAvr,'HRTTAvr'=>$HRTTAvr,'RCRAvr'=>$RCRAvr,'FORAvr'=>$FORAvr,
    'MALAvr'=>$MALAvr,'CFAvr'=>$CFAvr,'SSAvr'=>$SSAvr,'JSAvr'=>$JSAvr,
    'FerieMai'=>$FerieMai,'TRMai'=>$TRMai,'CPMai'=>$CPMai,'RTTMai'=>$RTTMai,'HRTTMai'=>$HRTTMai,'RCRMai'=>$RCRMai,'FORMai'=>$FORMai,
    'MALMai'=>$MALMai,'CFMai'=>$CFMai,'SSMai'=>$SSMai,'JSMai'=>$JSMai,
    'FerieJuin'=>$FerieJuin,'TRJuin'=>$TRJuin,'CPJuin'=>$CPJuin,'RTTJuin'=>$RTTJuin,'HRTTJuin'=>$HRTTJuin,'RCRJuin'=>$RCRJuin,'FORJuin'=>$FORJuin,
    'MALJuin'=>$MALJuin,'CFJuin'=>$CFJuin,'SSJuin'=>$SSJuin,'JSJuin'=>$JSJuin,
    'FerieJuillet'=>$FerieJuillet,'TRJuillet'=>$TRJuillet,'CPJuillet'=>$CPJuillet,'RTTJuillet'=>$RTTJuillet,'HRTTJuillet'=>$HRTTJuillet,'RCRJuillet'=>$RCRJuillet,'FORJuillet'=>$FORJuillet,
    'MALJuillet'=>$MALJuillet,'CFJuillet'=>$CFJuillet,'SSJuillet'=>$SSJuillet,'JSJuillet'=>$JSJuillet,
    'FerieAout'=>$FerieAout,'TRAout'=>$TRAout,'CPAout'=>$CPAout,'RTTAout'=>$RTTAout,'HRTTAout'=>$HRTTAout,'RCRAout'=>$RCRAout,'FORAout'=>$FORAout,
    'MALAout'=>$MALAout,'CFAout'=>$CFAout,'SSAout'=>$SSAout,'JSAout'=>$JSAout,
    'FerieSeptembre'=>$FerieSeptembre,'TRSeptembre'=>$TRSeptembre,'CPSeptembre'=>$CPSeptembre,'RTTSeptembre'=>$RTTSeptembre,'HRTTSeptembre'=>$HRTTSeptembre,'RCRSeptembre'=>$RCRSeptembre,'FORSeptembre'=>$FORSeptembre,
    'MALSeptembre'=>$MALSeptembre,'CFSeptembre'=>$CFSeptembre,'SSSeptembre'=>$SSSeptembre,'JSSeptembre'=>$JSSeptembre,
    'FerieOctobre'=>$FerieOctobre,'TROctobre'=>$TROctobre,'CPOctobre'=>$CPOctobre,'RTTOctobre'=>$RTTOctobre,'HRTTOctobre'=>$HRTTOctobre,'RCROctobre'=>$RCROctobre,'FOROctobre'=>$FOROctobre,
    'MALOctobre'=>$MALOctobre,'CFOctobre'=>$CFOctobre,'SSOctobre'=>$SSOctobre,'JSOctobre'=>$JSOctobre,
    'FerieNovembre'=>$FerieNovembre,'TRNovembre'=>$TRNovembre,'CPNovembre'=>$CPNovembre,'RTTNovembre'=>$RTTNovembre,'HRTTNovembre'=>$HRTTNovembre,'RCRNovembre'=>$RCRNovembre,'FORNovembre'=>$FORNovembre,
    'MALNovembre'=>$MALNovembre,'CFNovembre'=>$CFNovembre,'SSNovembre'=>$SSNovembre,'JSNovembre'=>$JSNovembre,
    'FerieDecembre'=>$FerieDecembre,'TRDecembre'=>$TRDecembre,'CPDecembre'=>$CPDecembre,'RTTDecembre'=>$RTTDecembre,'HRTTDecembre'=>$HRTTDecembre,'RCRDecembre'=>$RCRDecembre,'FORDecembre'=>$FORDecembre,
    'MALDecembre'=>$MALDecembre,'CFDecembre'=>$CFDecembre,'SSDecembre'=>$SSDecembre,'JSDecembre'=>$JSDecembre,'DJan'=>$DJan,'DFev'=>$DFev,'DMar'=>$DMar,'DAvr'=>$DAvr,'DMai'=>$DMai,'DJuin'=>$DJuin,
    'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,
]);
}

public function searchStat(Request $request) {
    $search_text= $request->input('searchstat');
    $user=Auth::user();
    $session_str = $user->service;
    $session_id = $user->identifiant;
    $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = ? ORDER BY id DESC LIMIT 1',[$session_id]);
    $fiche = DB::select('select * from fichehors where idUser = ? AND year=?',[$session_id,$search_text]);
    $date = date('Y-m-01', strtotime("first day of this month"));
    $year = date('Y', strtotime($date));
    $depassementJan =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Janvier%"',[$session_id]);
    $depassementFev =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Février%"',[$session_id]);
    $depassementMar =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Mars%"',[$session_id]);
    $depassementAvr =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Avril%"',[$session_id]);
    $depassementMai =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Mai%"',[$session_id]);
    $depassementJuin =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Juin%"',[$session_id]);
    $depassementJuillet =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Juillet%"',[$session_id]);
    $depassementAout =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Août%"',[$session_id]);
    $depassementSept =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Septembre%"',[$session_id]);
    $depassementOct =  DB::select('select * from depassements where identifiant =? and
    idFiche LIKE "%Octobre%"',[$session_id]);
    $depassementNov =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Novembre%"',[$session_id]);
    $depassementDec =  DB::select('select * from depassements where identifiant = ? and
    idFiche LIKE "%Décembre%"',[$session_id]);
    $DJan=0;
    $DFev=0;
    $DMar=0;
    $DAvr=0;
    $DMai=0;
    $DJuin=0;
    $DJuil=0;
    $DAout=0;
    $DSept=0;
    $DOct=0;
    $DNov=0;
    $DDec=0;
    foreach($depassementJan as $depJan)
    {
        if(str_contains($depJan->idFiche, $search_text)){
            $DJan=$DJan+$depJan->nombreH;
        }
    }
    foreach($depassementFev as $depFev)
    {
        if(str_contains($depFev->idFiche, $search_text)){
            $DFev=$DFev+$depFev->nombreH;
        }
    }
    foreach($depassementMar as $depMar)
    {
        if(str_contains($depMar->idFiche, $search_text)){
            $DMar=$DMar+$depMar->nombreH;
        }
    }
    foreach($depassementAvr as $depAvr)
    {
        if(str_contains($depAvr->idFiche, $search_text)){
            $DAvr=$DAvr+$depAvr->nombreH;
        }
    }
    foreach($depassementMai as $depMai)
    {
        if(str_contains($depMai->idFiche, $search_text)){
            $DMai=$DMai+$depMai->nombreH;
        }
    }
    foreach($depassementJuin as $depJuin)
    {
        if(str_contains($depJuin->idFiche, $search_text)){
            $DJuin=$DJuin+$depJuin->nombreH;
        }
    }
    foreach($depassementJuillet as $depJuil)
    {
        if(str_contains($depJuil->idFiche, $search_text)){
            $DJuil=$DJuil+$depJuil->nombreH;
        }
    }
    foreach($depassementAout as $depAou)
    {
        if(str_contains($depAou->idFiche, $search_text)){
            $DAout=$DAout+$depAou->nombreH;
        }
    }
    foreach($depassementSept as $depSept)
    {
        if(str_contains($depSept->idFiche, $search_text)){
            $DSept=$DSept+$depSept->nombreH;
        }
    }
    foreach($depassementOct as $depOct)
    {
        if(str_contains($depOct->idFiche, $search_text)){
            $DJan=$DJan+$depOct->nombreH;
        }
    }
    foreach($depassementNov as $depNov)
    {
        if(str_contains($depNov->idFiche, $search_text)){
            $DNov=$DNov+$depNov->nombreH;
        }
    }
    foreach($depassementDec as $depDec)
    {
        if(str_contains($depDec->idFiche, $search_text)){
            $DDec=$DDec+$depDec->nombreH;
        }
    }
    $FRASAD=0;
    $Entraide=0;	
    $Fédération=0;
    $Prestataire=0;
    $Voisineurs	=0;
    $ADU=0;
    $Mandataires=0;	
    $SOS=0;	
    $ADVM=0;	
    $Délégation=0;
    $AI=0;
    $poids=0;
    $ferie=0;
    $TR=0;
    $CP=0;
    $RTT=0;
    $HRTT=0;
    $RCR=0;
    $FOR=0;
    $MAL=0;
    $CF=0;
    $SS=0;
    $JS=0;
    foreach ($fiche as $fi) {
        if(str_contains($fi->idfiche, $search_text)){
        $Délégation=$fi->DELEGATION+$Délégation;
        $FRASAD=$fi->FRASAD+$FRASAD;
        $Entraide=$fi->EntraideFamiliale+$Entraide;
        $Fédération=$fi->Federation+$Fédération;
        $Prestataire=$fi->Prestataire+$Prestataire;
        $Voisineurs=$fi->Voisineurs+$Voisineurs;
        $ADU=$fi->ADUservices+$ADU;
        $Mandataires=$fi->Mandataires+$Mandataires;
        $SOS=$fi->SOSgarde+$SOS;
        $ADVM=$fi->ADVM+$ADVM;
        $AI=$fi->AI+$AI;
        $poids=$fi->Poids+$poids;
        }
    }
    foreach ($fiche as $fi) {
        if(str_contains($fi->idfiche, $search_text)){
            if($fi->typeJour=="Férié"){
                $ferie=$ferie+1;
            }
            else if($fi->typeJour=="Travaillé"){
                $TR=$TR+1;
            }
            else if($fi->typeJour=="CP"){
                $CP=$CP+1;
            }
            else if($fi->typeJour=="RTT"){
                $RTT=$RTT+1;
            }

            else if($fi->typeJour=="1/2 RTT"){
                $HRTT=$HRTT+1;
            }

            else if($fi->typeJour=="RCR"){
                $RCR=$RCR+1;
            }

            else if($fi->typeJour=="Formation"){
                $FOR=$FOR+1;
            }
            else if($fi->typeJour=="Maladie"){
                $MAL=$MAL+1;
            }
            else if($fi->typeJour=="Congés familiaux"){
                $CF=$CF+1;
            }
            else if($fi->typeJour=="Sans soldes"){
                $SS=$SS+1;
            }
            else if($fi->typeJour=="Jour solidarité"){
                $JS=$JS+1;
            }


        }
    }
    $FerieJan=0;
    $TRJan=0;
    $CPJan=0;
    $RTTJan=0;
    $HRTTJan=0;
    $RCRJan=0;
    $FORJan=0;
    $MALJan=0;
    $CFJan=0;
    $SSJan=0;
    $JSJan=0;
    $FerieFev=0;
    $TRFev=0;
    $CPFev=0;
    $RTTFev=0;
    $HRTTFev=0;
    $RCRFev=0;
    $FORFev=0;
    $MALFev=0;
    $CFFev=0;
    $SSFev=0;
    $JSFev=0;
    $FerieMar=0;
    $TRMar=0;
    $CPMar=0;
    $RTTMar=0;
    $HRTTMar=0;
    $RCRMar=0;
    $FORMar=0;
    $MALMar=0;
    $CFMar=0;
    $SSMar=0;
    $JSMar=0;
    $FerieAvr=0;
    $TRAvr=0;
    $CPAvr=0;
    $RTTAvr=0;
    $HRTTAvr=0;
    $RCRAvr=0;
    $FORAvr=0;
    $MALAvr=0;
    $CFAvr=0;
    $SSAvr=0;
    $JSAvr=0;
    $FerieMai=0;
    $TRMai=0;
    $CPMai=0;
    $RTTMai=0;
    $HRTTMai=0;
    $RCRMai=0;
    $FORMai=0;
    $MALMai=0;
    $CFMai=0;
    $SSMai=0;
    $JSMai=0;
    $FerieJuin=0;
    $TRJuin=0;
    $CPJuin=0;
    $RTTJuin=0;
    $HRTTJuin=0;
    $RCRJuin=0;
    $FORJuin=0;
    $MALJuin=0;
    $CFJuin=0;
    $SSJuin=0;
    $JSJuin=0;
    $FerieJuillet=0;
    $TRJuillet=0;
    $CPJuillet=0;
    $RTTJuillet=0;
    $HRTTJuillet=0;
    $RCRJuillet=0;
    $FORJuillet=0;
    $MALJuillet=0;
    $CFJuillet=0;
    $SSJuillet=0;
    $JSJuillet=0;
    $FerieAout=0;
    $TRAout=0;
    $CPAout=0;
    $RTTAout=0;
    $HRTTAout=0;
    $RCRAout=0;
    $FORAout=0;
    $MALAout=0;
    $CFAout=0;
    $SSAout=0;
    $JSAout=0;
    $FerieSeptembre=0;
    $TRSeptembre=0;
    $CPSeptembre=0;
    $RTTSeptembre=0;
    $HRTTSeptembre=0;
    $RCRSeptembre=0;
    $FORSeptembre=0;
    $MALSeptembre=0;
    $CFSeptembre=0;
    $SSSeptembre=0;
    $JSSeptembre=0;
    $FerieOctobre=0;
    $TROctobre=0;
    $CPOctobre=0;
    $RTTOctobre=0;
    $HRTTOctobre=0;
    $RCROctobre=0;
    $FOROctobre=0;
    $MALOctobre=0;
    $CFOctobre=0;
    $SSOctobre=0;
    $JSOctobre=0;
    $FerieNovembre=0;
    $TRNovembre=0;
    $CPNovembre=0;
    $RTTNovembre=0;
    $HRTTNovembre=0;
    $RCRNovembre=0;
    $FORNovembre=0;
    $MALNovembre=0;
    $CFNovembre=0;
    $SSNovembre=0;
    $JSNovembre=0;
    $FerieDecembre=0;
    $TRDecembre=0;
    $CPDecembre=0;
    $RTTDecembre=0;
    $HRTTDecembre=0;
    $RCRDecembre=0;
    $FORDecembre=0;
    $MALDecembre=0;
    $CFDecembre=0;
    $SSDecembre=0;
    $JSDecembre=0;
    foreach ($fiche as $fi) {
        if(str_contains($fi->idfiche, $search_text)){
            if(str_contains($fi->idfiche, "Janvier")){
                if($fi->typeJour=="Férié"){
                $FerieJan=$FerieJan+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRJan=$TRJan+1;
                }
                else if($fi->typeJour=="CP"){
                $CPJan=$CPJan+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTJan=$RTTJan+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTJan=$HRTTJan+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRJan=$RCRJan+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORJan=$FORJan+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALJan=$MALJan+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFJan=$CFJan+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSJan=$SSJan+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSJan=$JSJan+1;
                }
            }
            else if(str_contains($fi->idfiche, "Février")){
                if($fi->typeJour=="Férié"){
                $FerieFev=$FerieFev+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRFev=$TRFev+1;
                }
                else if($fi->typeJour=="CP"){
                $CPFev=$CPFev+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTFev=$RTTFev+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTFev=$HRTTFev+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRFev=$RCRFev+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORFev=$FORFev+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALFev=$MALFev+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFFev=$CFFev+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSFev=$SSFev+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSFev=$JSFev+1;
                }
            }else if(str_contains($fi->idfiche, "Mars")){
                if($fi->typeJour=="Férié"){
                $FerieMar=$FerieMar+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRMar=$TRMar+1;
                }
                else if($fi->typeJour=="CP"){
                $CPMar=$CPMar+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTMar=$RTTMar+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTMar=$HRTTMar+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRMar=$RCRMar+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORMar=$FORMar+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALMar=$MALMar+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFMar=$CFMar+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSMar=$SSMar+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSMar=$JSMar+1;
                }
            }else if(str_contains($fi->idfiche, "Avril")){
                if($fi->typeJour=="Férié"){
                $FerieAvr=$FerieAvr+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRAvr=$TRAvr+1;
                }
                else if($fi->typeJour=="CP"){
                $CPAvr=$CPAvr+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTAvr=$RTTAvr+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTAvr=$HRTTAvr+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRAvr=$RCRAvr+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORAvr=$FORAvr+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALAvr=$MALAvr+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFAvr=$CFAvr+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSAvr=$SSAvr+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSAvr=$JSAvr+1;
                }
            }else if(str_contains($fi->idfiche, "Mai")){
                if($fi->typeJour=="Férié"){
                $FerieMai=$FerieMai+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRMai=$TRMai+1;
                }
                else if($fi->typeJour=="CP"){
                $CPMai=$CPMai+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTMai=$RTTMai+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTMai=$HRTTMai+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRMai=$RCRMai+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORMai=$FORMai+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALMai=$MALMai+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFMai=$CFMai+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSMai=$SSMai+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSMai=$JSMai+1;
                }
            }
            else if(str_contains($fi->idfiche, "Juin")){
                if($fi->typeJour=="Férié"){
                $FerieJuin=$FerieJuin+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRJuin=$TRJuin+1;
                }
                else if($fi->typeJour=="CP"){
                $CPJuin=$CPJuin+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTJuin=$RTTJuin+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTJuin=$HRTTJuin+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRJuin=$RCRJuin+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORJuin=$FORJuin+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALJuin=$MALJuin+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFJuin=$CFJuin+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSJuin=$SSJuin+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSJuin=$JSJuin+1;
                }
            }
            else if(str_contains($fi->idfiche, "Juillet")){
                if($fi->typeJour=="Férié"){
                $FerieJuillet=$FerieJuillet+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRJuillet=$TRJuillet+1;
                }
                else if($fi->typeJour=="CP"){
                $CPJuillet=$CPJuillet+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTJuillet=$RTTJuillet+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTJuillet=$HRTTJuillet+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRJuillet=$RCRJuillet+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORJuillet=$FORJuillet+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALJuillet=$MALJuillet+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFJuillet=$CFJuillet+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSJuillet=$SSJuillet+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSJuillet=$JSJuillet+1;
                }
            }
            else if(str_contains($fi->idfiche, "Août")){
                if($fi->typeJour=="Férié"){
                $FerieAout=$FerieAout+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRAout=$TRAout+1;
                }
                else if($fi->typeJour=="CP"){
                $CPAout=$CPAout+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTAout=$RTTAout+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTAout=$HRTTAout+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRAout=$RCRAout+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORAout=$FORAout+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALAout=$MALAout+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFAout=$CFAout+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSAout=$SSAout+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSAout=$JSAout+1;
                }
            }
            else if(str_contains($fi->idfiche, "Septembre")){
                if($fi->typeJour=="Férié"){
                $FerieSeptembre=$FerieSeptembre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRSeptembre=$TRSeptembre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPSeptembre=$CPSeptembre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTSeptembre=$RTTSeptembre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTSeptembre=$HRTTSeptembre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRSeptembre=$RCRSeptembre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORSeptembre=$FORSeptembre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALSeptembre=$MALSeptembre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFSeptembre=$CFSeptembre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSSeptembre=$SSSeptembre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSSeptembre=$JSSeptembre+1;
                }
            }
            else if(str_contains($fi->idfiche, "Octobre")){
                if($fi->typeJour=="Férié"){
                $FerieOctobre=$FerieOctobre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TROctobre=$TROctobre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPOctobre=$CPSOctobre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTOctobre=$RTTOctobre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTOctobre=$HRTTOctobre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCROctobre=$RCROctobre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FOROctobre=$FOROctobre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALOctobre=$MALOctobre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFOctobre=$CFOctobre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSOctobre=$SSOctobre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSOctobre=$JSOctobre+1;
                }
            }
            else if(str_contains($fi->idfiche, "Novembre")){
                if($fi->typeJour=="Férié"){
                $FerieNovembre=$FerieNovembre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRNovembre=$TRNovembre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPNovembre=$CPNovembre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTNovembre=$RTTNovembre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTNovembre=$HRTTNovembre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRNovembre=$RCRNovembre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORNovembre=$FORNovembre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALNovembre=$MALNovembre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFNovembre=$CFNovembre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSNovembre=$SSNovembre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSNovembre=$JSNovembre+1;
                }
            }
            else if(str_contains($fi->idfiche, "Décembre")){
                if($fi->typeJour=="Férié"){
                $FerieDecembre=$FerieDecembre+1;
                }
                else if($fi->typeJour=="Travaillé"){
                $TRDecembre=$TRDecembre+1;
                }
                else if($fi->typeJour=="CP"){
                $CPDecembre=$CPDecembre+1;
                }
                else if($fi->typeJour=="RTT"){
                $RTTDecembre=$RTTDecembre+1;
                }
                 else if($fi->typeJour=="1/2 RTT"){
                $HRTTDecembre=$HRTTDecembre+1;
                }
                 else if($fi->typeJour=="RCR"){
                $RCRDecembre=$RCRDecembre+1;
                }
                 else if($fi->typeJour=="Formation"){
                $FORDecembre=$FORDecembre+1;
                }
                 else if($fi->typeJour=="Maladie"){
                $MALDecembre=$MALDecembre+1;
                }
                 else if($fi->typeJour=="Congés familiaux"){
                $CFDecembre=$CFDecembre+1;
                }
                 else if($fi->typeJour=="Sans soldes"){
                $SSDecembre=$SSDecembre+1;
                }
                 else if($fi->typeJour=="Jour solidarité"){
                $JSDecembre=$JSDecembre+1;
                }
            }
            
    }
}
    $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM+$AI;
    $diff=$poids-$totalVentil;
    if(!Gate::any(['access-admin', 'access-direction'])){
        return view('USER/statistiquesUser',['fiche'=>$fiche,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
        'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,'AI'=>$AI,
        'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'year'=>$year
        ,'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
        'FerieJan'=>$FerieJan,'TRJan'=>$TRJan,'CPJan'=>$CPJan,'RTTJan'=>$RTTJan,'HRTTJan'=>$HRTTJan,'RCRJan'=>$RCRJan,'FORJan'=>$FORJan,
        'MALJan'=>$MALJan,'CFJan'=>$CFJan,'SSJan'=>$SSJan,'JSJan'=>$JSJan,
        'FerieFev'=>$FerieFev,'TRFev'=>$TRFev,'CPFev'=>$CPFev,'RTTFev'=>$RTTFev,'HRTTFev'=>$HRTTFev,'RCRFev'=>$RCRFev,'FORFev'=>$FORFev,
        'MALFev'=>$MALFev,'CFFev'=>$CFFev,'SSFev'=>$SSFev,'JSFev'=>$JSFev,
        'FerieMar'=>$FerieMar,'TRMar'=>$TRMar,'CPMar'=>$CPMar,'RTTMar'=>$RTTMar,'HRTTMar'=>$HRTTMar,'RCRMar'=>$RCRMar,'FORMar'=>$FORMar,
        'MALMar'=>$MALMar,'CFMar'=>$CFMar,'SSMar'=>$SSMar,'JSMar'=>$JSMar,
        'FerieAvr'=>$FerieAvr,'TRAvr'=>$TRAvr,'CPAvr'=>$CPAvr,'RTTAvr'=>$RTTAvr,'HRTTAvr'=>$HRTTAvr,'RCRAvr'=>$RCRAvr,'FORAvr'=>$FORAvr,
        'MALAvr'=>$MALAvr,'CFAvr'=>$CFAvr,'SSAvr'=>$SSAvr,'JSAvr'=>$JSAvr,
        'FerieMai'=>$FerieMai,'TRMai'=>$TRMai,'CPMai'=>$CPMai,'RTTMai'=>$RTTMai,'HRTTMai'=>$HRTTMai,'RCRMai'=>$RCRMai,'FORMai'=>$FORMai,
        'MALMai'=>$MALMai,'CFMai'=>$CFMai,'SSMai'=>$SSMai,'JSMai'=>$JSMai,
        'FerieJuin'=>$FerieJuin,'TRJuin'=>$TRJuin,'CPJuin'=>$CPJuin,'RTTJuin'=>$RTTJuin,'HRTTJuin'=>$HRTTJuin,'RCRJuin'=>$RCRJuin,'FORJuin'=>$FORJuin,
        'MALJuin'=>$MALJuin,'CFJuin'=>$CFJuin,'SSJuin'=>$SSJuin,'JSJuin'=>$JSJuin,
        'FerieJuillet'=>$FerieJuillet,'TRJuillet'=>$TRJuillet,'CPJuillet'=>$CPJuillet,'RTTJuillet'=>$RTTJuillet,'HRTTJuillet'=>$HRTTJuillet,'RCRJuillet'=>$RCRJuillet,'FORJuillet'=>$FORJuillet,
        'MALJuillet'=>$MALJuillet,'CFJuillet'=>$CFJuillet,'SSJuillet'=>$SSJuillet,'JSJuillet'=>$JSJuillet,
        'FerieAout'=>$FerieAout,'TRAout'=>$TRAout,'CPAout'=>$CPAout,'RTTAout'=>$RTTAout,'HRTTAout'=>$HRTTAout,'RCRAout'=>$RCRAout,'FORAout'=>$FORAout,
        'MALAout'=>$MALAout,'CFAout'=>$CFAout,'SSAout'=>$SSAout,'JSAout'=>$JSAout,
        'FerieSeptembre'=>$FerieSeptembre,'TRSeptembre'=>$TRSeptembre,'CPSeptembre'=>$CPSeptembre,'RTTSeptembre'=>$RTTSeptembre,'HRTTSeptembre'=>$HRTTSeptembre,'RCRSeptembre'=>$RCRSeptembre,'FORSeptembre'=>$FORSeptembre,
        'MALSeptembre'=>$MALSeptembre,'CFSeptembre'=>$CFSeptembre,'SSSeptembre'=>$SSSeptembre,'JSSeptembre'=>$JSSeptembre,
        'FerieOctobre'=>$FerieOctobre,'TROctobre'=>$TROctobre,'CPOctobre'=>$CPOctobre,'RTTOctobre'=>$RTTOctobre,'HRTTOctobre'=>$HRTTOctobre,'RCROctobre'=>$RCROctobre,'FOROctobre'=>$FOROctobre,
        'MALOctobre'=>$MALOctobre,'CFOctobre'=>$CFOctobre,'SSOctobre'=>$SSOctobre,'JSOctobre'=>$JSOctobre,
        'FerieNovembre'=>$FerieNovembre,'TRNovembre'=>$TRNovembre,'CPNovembre'=>$CPNovembre,'RTTNovembre'=>$RTTNovembre,'HRTTNovembre'=>$HRTTNovembre,'RCRNovembre'=>$RCRNovembre,'FORNovembre'=>$FORNovembre,
        'MALNovembre'=>$MALNovembre,'CFNovembre'=>$CFNovembre,'SSNovembre'=>$SSNovembre,'JSNovembre'=>$JSNovembre,
        'FerieDecembre'=>$FerieDecembre,'TRDecembre'=>$TRDecembre,'CPDecembre'=>$CPDecembre,'RTTDecembre'=>$RTTDecembre,'HRTTDecembre'=>$HRTTDecembre,'RCRDecembre'=>$RCRDecembre,'FORDecembre'=>$FORDecembre,
        'MALDecembre'=>$MALDecembre,'CFDecembre'=>$CFDecembre,'SSDecembre'=>$SSDecembre,'JSDecembre'=>$JSDecembre,'DJan'=>$DJan,'DFev'=>$DFev,'DMar'=>$DMar,'DAvr'=>$DAvr,'DMai'=>$DMai,'DJuin'=>$DJuin,
        'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,
    ]);
    }
    return view('ADMIN/statistiquesUser',['fiche'=>$fiche,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
    'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,'AI'=>$AI,
    'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'year'=>$year
    ,'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
    'FerieJan'=>$FerieJan,'TRJan'=>$TRJan,'CPJan'=>$CPJan,'RTTJan'=>$RTTJan,'HRTTJan'=>$HRTTJan,'RCRJan'=>$RCRJan,'FORJan'=>$FORJan,
    'MALJan'=>$MALJan,'CFJan'=>$CFJan,'SSJan'=>$SSJan,'JSJan'=>$JSJan,
    'FerieFev'=>$FerieFev,'TRFev'=>$TRFev,'CPFev'=>$CPFev,'RTTFev'=>$RTTFev,'HRTTFev'=>$HRTTFev,'RCRFev'=>$RCRFev,'FORFev'=>$FORFev,
    'MALFev'=>$MALFev,'CFFev'=>$CFFev,'SSFev'=>$SSFev,'JSFev'=>$JSFev,
    'FerieMar'=>$FerieMar,'TRMar'=>$TRMar,'CPMar'=>$CPMar,'RTTMar'=>$RTTMar,'HRTTMar'=>$HRTTMar,'RCRMar'=>$RCRMar,'FORMar'=>$FORMar,
    'MALMar'=>$MALMar,'CFMar'=>$CFMar,'SSMar'=>$SSMar,'JSMar'=>$JSMar,
    'FerieAvr'=>$FerieAvr,'TRAvr'=>$TRAvr,'CPAvr'=>$CPAvr,'RTTAvr'=>$RTTAvr,'HRTTAvr'=>$HRTTAvr,'RCRAvr'=>$RCRAvr,'FORAvr'=>$FORAvr,
    'MALAvr'=>$MALAvr,'CFAvr'=>$CFAvr,'SSAvr'=>$SSAvr,'JSAvr'=>$JSAvr,
    'FerieMai'=>$FerieMai,'TRMai'=>$TRMai,'CPMai'=>$CPMai,'RTTMai'=>$RTTMai,'HRTTMai'=>$HRTTMai,'RCRMai'=>$RCRMai,'FORMai'=>$FORMai,
    'MALMai'=>$MALMai,'CFMai'=>$CFMai,'SSMai'=>$SSMai,'JSMai'=>$JSMai,
    'FerieJuin'=>$FerieJuin,'TRJuin'=>$TRJuin,'CPJuin'=>$CPJuin,'RTTJuin'=>$RTTJuin,'HRTTJuin'=>$HRTTJuin,'RCRJuin'=>$RCRJuin,'FORJuin'=>$FORJuin,
    'MALJuin'=>$MALJuin,'CFJuin'=>$CFJuin,'SSJuin'=>$SSJuin,'JSJuin'=>$JSJuin,
    'FerieJuillet'=>$FerieJuillet,'TRJuillet'=>$TRJuillet,'CPJuillet'=>$CPJuillet,'RTTJuillet'=>$RTTJuillet,'HRTTJuillet'=>$HRTTJuillet,'RCRJuillet'=>$RCRJuillet,'FORJuillet'=>$FORJuillet,
    'MALJuillet'=>$MALJuillet,'CFJuillet'=>$CFJuillet,'SSJuillet'=>$SSJuillet,'JSJuillet'=>$JSJuillet,
    'FerieAout'=>$FerieAout,'TRAout'=>$TRAout,'CPAout'=>$CPAout,'RTTAout'=>$RTTAout,'HRTTAout'=>$HRTTAout,'RCRAout'=>$RCRAout,'FORAout'=>$FORAout,
    'MALAout'=>$MALAout,'CFAout'=>$CFAout,'SSAout'=>$SSAout,'JSAout'=>$JSAout,
    'FerieSeptembre'=>$FerieSeptembre,'TRSeptembre'=>$TRSeptembre,'CPSeptembre'=>$CPSeptembre,'RTTSeptembre'=>$RTTSeptembre,'HRTTSeptembre'=>$HRTTSeptembre,'RCRSeptembre'=>$RCRSeptembre,'FORSeptembre'=>$FORSeptembre,
    'MALSeptembre'=>$MALSeptembre,'CFSeptembre'=>$CFSeptembre,'SSSeptembre'=>$SSSeptembre,'JSSeptembre'=>$JSSeptembre,
    'FerieOctobre'=>$FerieOctobre,'TROctobre'=>$TROctobre,'CPOctobre'=>$CPOctobre,'RTTOctobre'=>$RTTOctobre,'HRTTOctobre'=>$HRTTOctobre,'RCROctobre'=>$RCROctobre,'FOROctobre'=>$FOROctobre,
    'MALOctobre'=>$MALOctobre,'CFOctobre'=>$CFOctobre,'SSOctobre'=>$SSOctobre,'JSOctobre'=>$JSOctobre,
    'FerieNovembre'=>$FerieNovembre,'TRNovembre'=>$TRNovembre,'CPNovembre'=>$CPNovembre,'RTTNovembre'=>$RTTNovembre,'HRTTNovembre'=>$HRTTNovembre,'RCRNovembre'=>$RCRNovembre,'FORNovembre'=>$FORNovembre,
    'MALNovembre'=>$MALNovembre,'CFNovembre'=>$CFNovembre,'SSNovembre'=>$SSNovembre,'JSNovembre'=>$JSNovembre,
    'FerieDecembre'=>$FerieDecembre,'TRDecembre'=>$TRDecembre,'CPDecembre'=>$CPDecembre,'RTTDecembre'=>$RTTDecembre,'HRTTDecembre'=>$HRTTDecembre,'RCRDecembre'=>$RCRDecembre,'FORDecembre'=>$FORDecembre,
    'MALDecembre'=>$MALDecembre,'CFDecembre'=>$CFDecembre,'SSDecembre'=>$SSDecembre,'JSDecembre'=>$JSDecembre,'DJan'=>$DJan,'DFev'=>$DFev,'DMar'=>$DMar,'DAvr'=>$DAvr,'DMai'=>$DMai,'DJuin'=>$DJuin,
    'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,
]);
}
}