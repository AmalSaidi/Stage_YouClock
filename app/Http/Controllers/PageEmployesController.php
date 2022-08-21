<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\employes;
use App\Models\ventilation;
use App\Models\ventilationfiche;
use App\Models\fichehor;
use App\Models\horairesemaine;
use App\Models\User;
use App\Models\semainetype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllFichesExport;
use App\Exports\FichesDetailsExport;
use App\Models\ventilationfinal;


class PageEmployesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ValiderFicheHoraire(Request $request,$idF,$idU) {
        $user=Auth::user();
        $session_id = $user->identifiant;
        $idFiche = $request->input('idfiche');
        $idUser = $request->input('idUser');
        DB::update('update fichehors set statutF="AttValiRS" where idfiche = ? and idUser = ?',[$idFiche,$idUser]);
        return redirect()->back();
        }

    public function index(){
        $user=Auth::user();
        $session_str = $user->service;
        $employes = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $structures = DB::select('select * from structures');
        $services = DB::select('select * from services');
        $employees = DB::select('select * from employes');
        /*if(Gate::allows('access-admin')){
            return view('ADMIN/PageEmployes',[
                'employes' =>$employes,'structures'=>$structures,
            ]);
        }
        if(Gate::allows('access-direction')){
            return view('DIRECTION/PageEmployes',[
                'employees' =>$employees,'structures'=>$structures,
            ]);
        } */
        if($user->admin==1 AND $user->direction==1){
            return view('DIRECTION/PageEmployes',[
                'employees' =>$employees,'structures'=>$structures,'services'=>$services,
            ]);
        }
        else if($user->admin==1 AND $user->direction==0){
            return view('ADMIN/PageEmployes',[
                'employes' =>$employes,'structures'=>$structures,'services'=>$services,
            ]);
        }else if($user->admin==0 AND $user->direction==1){
            return view('DIRECTION/PageEmployes',[
                'employees' =>$employees,'structures'=>$structures,'services'=>$services,
            ]);
        }
    }

    public function vueAdmin() {
        $user=Auth::user();
        $session_str = $user->service;
        $services = DB::select('select * from services');
        $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $structures = DB::select('select * from structures');
        return view('DIRECTION/PageEmployes',[
            'employees' =>$employees,'structures'=>$structures,'services'=>$services,
        ]);
    }
    public function vueDirection() {
        $user=Auth::user();
        $session_str = $user->service;
        $employees = DB::select('select * from employes');
        $services = DB::select('select * from services');
        $structures = DB::select('select * from structures');
        return view('DIRECTION/PageEmployes',[
            'employees' =>$employees,'structures'=>$structures,'services'=>$services,
        ]);
    }

    public function VueAdminFiche() {
        $user=Auth::user();
        $user_session = $user->identifiant;
        DB::update('update users set SeeAsAdmin="1" where identifiant = ?',[$user_session]);
        return redirect()->back();
    }
    
    public function VueDirectionFiche() {
        $user=Auth::user();
        $user_session = $user->identifiant;
        DB::update('update users set SeeAsAdmin="0" where identifiant = ?',[$user_session]);
        return redirect()->back();
    }

    
    public function activerAcces(Request $request) {
        $user=Auth::user();
        $user_session = $user->identifiant;
        $idFiche = $request->input('idFiiche');
        $idUser = $request->input('idUUser');
        DB::update('update fichehors set statutF="EnCours" where idfiche = ? and idUser = ?',[$idFiche,$idUser]);
        DB::update('update fichehors set state="NR" where idfiche = ? and idUser = ?',[$idFiche,$idUser]);
        return redirect()->back();
    }


    public function VueUserFiche($idfiche,$idUser) {
        date_default_timezone_set('Europe/Paris');
        $user=Auth::user();
        $activites=DB::select('select * from activites');
        $session_id = $idUser;
        $employees=DB::select('select * from employes where identifiant=?',[$session_id]);
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
            if(ventilationfinal::where('idUser', $session_id)->where('ventilation', 'AI')->count() <= 0)
{
            ventilationfinal::updateOrCreate(
                ['idUser' => $session_id,'ventilation' => '"AI"'],
                ['ventilation' => 'AI']
            );
        }
        else{
            DB::update('update ventilationfinals set codeV="AI" where idUser = ? and ventilation="AI"',
            [$session_id]);
        }
    }
        else{
            ventilationfinal::where('idUser', $session_id)->where('ventilation','AI')->delete();
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
        $month = request('mois9');
        $year = request('annee9');
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
        $affichage = DB::table('fichehors')->where('idUser', $session_id)->where('idfiche',$idfiche)
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
        return view('DIRECTION.vueEmploye',[ 'employes' =>$employes,'employees' =>$employees,'date' =>$date,'date2' =>$date2,'dateF' =>$dateF,'month' =>$month,
        'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'samedi' =>$samedi,
        'dimanche' =>$dimanche,'affichage' => $affichage,'p'=>$p,'f'=>$f,'totEcart'=>$totEcart,'ajout'=>$ajout,'activites'=>$activites,
        'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
        ]);
    }

    public function showDetails($id,$idUser) {
        $user=Auth::user();
        $session_id = $idUser;
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
        return view('DIRECTION/FicheEdit',['affichage'=>$affichage,'last'=>$last,'lastt'=>$lastt,'activites'=>$activites,'ventil'=>$ventil,
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

            public function editFiche(Request $request,$id,$idUser) {
                $user=Auth::user();
                $session_id = $idUser;
                $fichehor = DB::select('select * from fichehors where idUser = ?',[$session_id]);
                $ventil = DB::select('select * from ventilationfinals where idUser = ?',[$session_id]);
                $wanted=DB::select('select * from users where identifiant = ?',[$session_id]);
                $idFi = request('idFi');
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
                $fiches=DB::select('select * from fichehors where id=?',[$id]);
                $st=DB::select('select * from semainetypes where iduser=?',[$session_id]);
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Lun')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Lundi')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Mar')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Mardi')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Mer')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Mercredi')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Jeu')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Jeudi')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Ven')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Vendredi')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Sam')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Samedi')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                foreach ($fiches as $fi) {
                    if(str_contains($fi->Date, 'Dim')){
                        foreach($st as $s){
                            if(str_contains($s->jour, 'Dimanche')){
                        DB::update('update fichehors set Poids=? where id=?',
                        [$s->poidsJour,$id]);
                            }
                        }
                    }
                }
                if($typeJour=="CP"){
                    DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
                    soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
                    activite3=?,Poids=?,typeJour=? where id = ?',
                    [NUll,NULL,NULL,NULL,NULL,NULL,"-","0","CP","-",
                    "-","CP","CP","0",$typeJour,$id]);
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                }
                if($typeJour=="repos"){
                    DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
                    soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
                    activite3=?,Poids=?,typeJour=? where id = ?',
                    [NUll,NULL,NULL,NULL,NULL,NULL,"-","0","repos","-",
                    "-","repos","repos","0",$typeJour,$id]);
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                }
                if($typeJour=="Férié"){
                    DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
                    soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
                    activite3=?,Poids=?,typeJour=? where id = ?',
                    [NUll,NULL,NULL,NULL,NULL,NULL,"-","0","F","-",
                    "-","F","F","0",$typeJour,$id]);
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                }
                if($typeJour=="Maladie"){
                    DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
                    soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
                    activite3=?,Poids=?,typeJour=? where id = ?',
                    [NUll,NULL,NULL,NULL,NULL,NULL,"-","0","M","-",
                    "-","M","M","0",$typeJour,$id]);
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                    
                }
                if($typeJour=="Congés familiaux"){
                    DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
                    soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
                    activite3=?,Poids=?,typeJour=? where id = ?',
                    [NUll,NULL,NULL,NULL,NULL,NULL,"-","0","CF","-",
                    "-","CF","CF","0",$typeJour,$id]);
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                    
                }
                if($typeJour=="Sans soldes"){
                    DB::update('update fichehors set matinD = ?,matinF = ?,ApremD=?, ApremF = ?,
                    soirD=?, soirF=?,matin=?,heuresEffectu=?,activite1=?,aprem=?,soir=?,activite2=?,
                    activite3=?,Poids=?,typeJour=? where id = ?',
                    [NUll,NULL,NULL,NULL,NULL,NULL,"-","0","S","-",
                    "-","S","S","0",$typeJour,$id]);
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                    
                }
                foreach($wanted as $w)
                {
                    if($w->direction=="1" or $w->admin=="1" or $w->identifiant=="59" or $w->identifiant=="IN2021080010" or $w->identifiant=="IN2021010057"){

                    }else{
                        if($heuresEffectu>11){
                            return redirect()->back()->with('status', 'La durée du jour ne peut pas être supérieur à 11 heures');
                        }
                        if($hourdiffMat>6){
                            return redirect()->back()->withInput($request->all())->with('status', 'La durée de matin ne peut pas être supérieure à 6heures');
                        }elseif($hourdiffAprem>6){
                            return redirect()->back()->withInput($request->all())->with('status', 'La durée de l\'après-midi ne peut pas être supérieure à 6heures');
                        }elseif($hourdiffSoir>6){
                            return redirect()->back()->withInput($request->all())->with('status', 'La durée de soir ne peut pas être supérieure à 6heures');
                        }
                    }
                }
                if($typeJour=="RCR"){
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
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                }
               if($activite1=="RTT" or $activite1=="1/2 RTT" or $activite1=="M" or $activite1=="CF" or $activite1=="F" or $activite1=="EF" 
               or $activite2=="RTT" or $activite2=="1/2 RTT" or $activite2=="M" or $activite2=="CF" or $activite2=="F" or $activite2=="EF"
                or $activite3=="RTT" or $activite3=="1/2 RTT" or $activite3=="M" or $activite3=="CF" or $activite3=="F" or $activite3=="EF")
               {
                if( $activite1=="RTT" or $activite1=="1/2 RTT" or $activite1=="M" or $activite1=="CF" or $activite1=="F" or $activite1=="EF"){
                    $hourdiffMat=0;
                }
                if($activite2=="RTT" or $activite2=="1/2 RTT" or $activite2=="M" or $activite2=="CF" or $activite2=="F" or $activite2=="EF"){
                   $hourdiffAprem=0;
                }
                if($activite3=="RTT" or $activite3=="1/2 RTT" or $activite3=="M" or $activite3=="CF" or $activite3=="F" or $activite3=="EF"){
                    $hourdiffSoir=0;
                }
                if($matinF==null OR $ApremD==null){
                $heuresEffectu = $hourdiffMat + $hourdiffAprem + $hourdiffSoir;
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
                return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                }else{
                    if($pauseMidi<0.750){
                        return back()->withInput($request->all())->with('status', 'La durée de pause doit être supérieur à 45min');
                }else{
                    $heuresEffectu = $hourdiffMat + $hourdiffAprem + $hourdiffSoir;
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
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                }
                }
                
               }
               if (abs(($heuresEffectu-$poids)/$poids) > 0.00001){
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
                        return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
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
                    return redirect()->route('ficheBack', ['idfiche' => $idFi,'idUser'=>$idUser]);
                    }}
                    else{
                        // return redirect()->back()->with('status', 'le nombre d\'heures effectués est invalide');
                        return back()->withInput($request->all())->with('status', 'le nombre d\'heures effectués est invalide');
                     }
                }
        
        
        }

    public function store(){

        $employes = new employes();
        $user = new User();
        $user->name = request('nom');
        $user->password = '$2y$10$X7iMritVZGtm7zB7u2hlpOwTuFbfLHFM.Q8RBv87xMTpG.xY1YTaq';
        $user->identifiant = request('identifiant');
        $user->admin = '0';
        $user->service = request('service');
        $user->direction = '1';
        $user->structure = request('structure');
        $user->email = request('mail');
        if(request('type')=="direction")
        {
            $user->direction = '1';
            $user->admin = '0';
        }
        else if(request('type')=="admin")
        {
            $user->direction = '0';
            $user->admin = '1';
            $employes->admin = '1';
        }
        else if(request('type')=="utilisateur")
        {
            $user->direction = '0';
            $user->admin = '0';
        }
        $employes->nom = request('nom');
        $employes->prenom = request('prenom');
        $employes->identifiant = request('identifiant');
        $employes->structure = request('structure');
        $employes->intitule = request('intitule');
        $employes->dateEmbauche = request('dateEmbauche');
        $employes->Datefin = request('Datefin');
        $employes->TypeContrat = request('TypeContrat');
        $employes->mail = request('mail');
        $employes->service = request('service');

        $employes->save();
        $user->save();


        return redirect('/employes');
    }

    public function ventila(Request $request)
    {
        $st = ventilation::updateOrCreate(
            ['idUser' =>  request('idUser')],
            ['ventilation' => $request->input('ventilation'),'idUser' => $request->input('idUser')]
        );
        return redirect()->back()->with('status', 'Les modifications ont été bien enregistrés');
    }

    public function show($id) {
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $user=Auth::user();
        $session_str = $user->service;
        if($user->direction==1){
            $employees = DB::table('employes')->get();

        }else{
            $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        }
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        return view('ADMIN/infoperso',['employes'=>$employes,'employees'=>$employees,'fiche'=>$fiche]);
        }

    public function showRH($id) {
        $user=Auth::user();
        $session_str = $user->service;
        if($user->direction==1){
            $employees = DB::table('employes')->get();

        }else{
            $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        }

        $employes = DB::select('select * from employes where id = ?',[$id]);
        $identifiant = DB::select('select identifiant from employes where id = ?',[$id]);
        $ventilations = DB::select('select * from ventilations where idUser = (select identifiant from employes where id=?)',[$id]);
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
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $Lun= DB::select('select * from semainetypes where jour="Lundi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mar= DB::select('select * from semainetypes where jour="Mardi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mer= DB::select('select * from semainetypes where jour="Mercredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Jeu= DB::select('select * from semainetypes where jour="Jeudi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Ven= DB::select('select * from semainetypes where jour="Vendredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Sam= DB::select('select * from semainetypes where jour="Samedi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Dim= DB::select('select * from semainetypes where jour="Dimanche" and idUser=(select identifiant from employes where id=?)',[$id]);
        return view('ADMIN/RH',['employes'=>$employes,'employees'=>$employees,'Lun'=>$Lun,'Mar'=>$Mar,'Mer'=>$Mer
        ,'Jeu'=>$Jeu,'Ven'=>$Ven,'Sam'=>$Sam,'Dim'=>$Dim,'fiche'=>$fiche,'MANDA'=>$MANDA,'FRAS'=>$FRAS,'ENTRAI'=>$ENTRAI,'FEDE'=>$FEDE,
        'PRES'=>$PRES,'VOISI'=>$VOISI,'ADU'=>$ADU,'SOS'=>$SOS,'ADVM'=>$ADVM,'DELEG'=>$DELEG,'ventilations'=>$ventilations,'AI'=>$AI]);
        }

    public function showFiche($id) {
        $user=Auth::user();
        $session_str = $user->service;
        if($user->direction==1){
            $employees = DB::table('employes')->get();

        }else{
            $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        }
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $fiche = DB::select('select DISTINCT idUser,idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY idfiche DESC,mois ASC',[$id]);
        return view('ADMIN/ficheHoraire',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche]);
        }


        public function showVenti($id) {
            $user=Auth::user();
            $session_str = $user->service;
            if($user->direction==1){
                $employees = DB::table('employes')->get();
    
            }else{
                $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            }
            $employes = DB::select('select * from employes where id = ?',[$id]);
            $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
            $fiicheS= DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
            $fiche = DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and idfiche=(select idfiche from
            fichehors ORDER BY id DESC LIMIT 1 )',[$id]);
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
            $poids=0;
            $AI=0;
            foreach ($fiche as $fi) {
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
                $poids=$fi->Poids+$poids;
                $AI=$fi->AI+$AI;
            }
            $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM+$AI;
            $diff=$totalVentil-$poids;
            return view('ADMIN/ventilationfiche',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
            'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,'AI'=>$AI,
            'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'fiicheS'=>$fiicheS]);
            }
            

            public function showStat($id) {
                $user=Auth::user();
                $session_str = $user->service;
                if($user->direction==1){
                    $employees = DB::table('employes')->get();
        
                }else{
                    $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
                }
                $employes = DB::select('select * from employes where id = ?',[$id]);
                $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
                $fiche = DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
                $date = date('Y-m-01', strtotime("first day of this month"));
                $year = date('Y', strtotime($date));
                $depassementJan =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Janvier%"',[$id]);
                $depassementFev =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Février%"',[$id]);
                $depassementMar =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Mars%"',[$id]);
                $depassementAvr =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Avril%"',[$id]);
                $depassementMai =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Mai%"',[$id]);
                $depassementJuin =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Juin%"',[$id]);
                $depassementJuillet =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Juillet%"',[$id]);
                $depassementAout =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Août%"',[$id]);
                $depassementSept =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Septembre%"',[$id]);
                $depassementOct =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Octobre%"',[$id]);
                $depassementNov =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Novembre%"',[$id]);
                $depassementDec =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Décembre%"',[$id]);
                $ecartJan =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Janvier%"',[$id]);
                $ecartFev =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Février%"',[$id]);
                $ecartMar =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Mars%"',[$id]);
                $ecartAvr =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Avril%"',[$id]);
                $ecartMai =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Mai%"',[$id]);
                $ecarJuin =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Juin%"',[$id]);
                $ecartJuillet =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Juillet%"',[$id]);
                $ecartAout =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Août%"',[$id]);
                $ecartSept =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Septembre%"',[$id]);
                $ecartOct =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Octobre%"',[$id]);
                $ecartNov =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Novembre%"',[$id]);
                $ecartDec =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Décembre%"',[$id]);
                $EJan=0;
                $EFev=0;
                $EMar=0;
                $EAvr=0;
                $EMai=0;
                $EJuin=0;
                $EJuil=0;
                $EAout=0;
                $ESept=0;
                $EOct=0;
                $ENov=0;
                $EDec=0;
                foreach($ecartJan as $ecaJan)
                {
                    if(str_contains($ecaJan->idfiche, $year)){
                        $EJan=$EJan+$ecaJan->ecart;
                    }
                }
                foreach($ecartFev as $ecaFev)
                {
                    if(str_contains($ecaFev->idfiche, $year)){
                        $EFev=$EFev+$ecaFev->ecart;
                    }
                }
                foreach($ecartMar as $ecaMar)
                {
                    if(str_contains($ecaMar->idfiche, $year)){
                        $EMar=$EMar+$ecaMar->ecart;
                    }
                }
                foreach($ecartAvr as $ecaAvr)
                {
                    if(str_contains($ecaAvr->idfiche, $year)){
                        $EAvr=$EAvr+$ecaAvr->ecart;
                    }
                }
                foreach($ecartMai as $ecaMai)
                {
                    if(str_contains($ecaMai->idfiche, $year)){
                        $EMai=$EMai+$ecaMai->ecart;
                    }
                }
                foreach($ecarJuin as $ecaJuin)
                {
                    if(str_contains($ecaJuin->idfiche, $year)){
                        $EJuin=$EJuin+$ecaJuin->ecart;
                    }
                }
                foreach($ecartJuillet as $ecaJuil)
                {
                    if(str_contains($ecaJuil->idfiche, $year)){
                        $EJuil=$EJuil+$ecaJuil->ecart;
                    }
                }
                foreach($ecartAout as $ecaAou)
                {
                    if(str_contains($ecaAou->idfiche, $year)){
                        $EAout=$EAout+$ecaAou->ecart;
                    }
                }
                foreach($ecartSept as $ecaSept)
                {
                    if(str_contains($ecaSept->idfiche, $year)){
                        $ESept=$ESept+$ecaSept->ecart;
                    }
                }
                foreach($ecartOct as $ecaOct)
                {
                    if(str_contains($ecaOct->idfiche, $year)){
                        $EJan=$EJan+$ecaOct->ecart;
                    }
                }
                foreach($ecartNov as $ecaNov)
                {
                    if(str_contains($ecaNov->idfiche, $year)){
                        $ENov=$ENov+$ecaNov->ecart;
                    }
                }
                foreach($ecartDec as $ecaDec)
                {
                    if(str_contains($ecaDec->idfiche, $year)){
                        $EDec=$EDec+$ecaDec->ecart;
                    }
                }
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
                    $AI=$fi->AI+$AI;
                    $ADVM=$fi->ADVM+$ADVM;
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
            $totEcart=$EJan+$EFev+$EMar+$EAvr+$EMai+$EJuin+$EJuil+$EAout+$ESept+$EOct+$ENov+$EDec;
            $totDepa=$DJan+$DFev+$DMar+$DAvr+$DMai+$DJuin+$DJuil+$DAout+$DSept+$DOct+$DNov+$DDec;
            $totRecup= $totDepa+$totEcart;
            if($totRecup>=0)
            {
                $totRecup=0;
            }
                $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM+$AI;
                $diff=$poids-$totalVentil;
                return view('ADMIN/stat',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
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
                'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,'year'=>$year,'EJan'=>$EJan,'EFev'=>$EFev,'EMar'=>$EMar,'EAvr'=>$EAvr,'EMai'=>$EMai,'EJuin'=>$EJuin,
                'EJuil'=>$EJuil,'EAout'=>$EAout,'ESept'=>$ESept,'EOct'=>$EOct,'ENov'=>$ENov,'EDec'=>$EDec,'totEcart'=>$totEcart,'totDepa'=>$totDepa,'totRecup'=>$totRecup,
            ]);
                }
        


    public function showFicheComplete($id,$idfiche) {
        $user=Auth::user();
        $session_str = $user->service;
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $fiches=DB::select('select * from fichehors where idUser=(select identifiant from employes where id=?) and statutF="EnCours"',[$id]);
        foreach ($fiches as $fi) {
            if($fi->typeJour =='CP'){
                DB::update('update fichehors set Poids=0 where id=?',
                [$fi->id]);
            }
            if($fi->typeJour =='repos'){
                DB::update('update fichehors set Poids=0 where id=?',
                [$fi->id]);
            }
            if($fi->typeJour =='Férié'){
                DB::update('update fichehors set Poids=0 where id=?',
                [$fi->id]);
            }
        }
        if($user->direction==1){
            $employees = DB::table('employes')->get();

        }else{
            $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        }
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $poidsJour = DB::select('select * from ventilationfinals where idUser = (select identifiant from employes where id=?)',[$id]);
        $depassement = DB::select('select * from depassements where idfiche =? AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $fiche = DB::select('select * from fichehors where idfiche =? AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem1 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 1" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem2 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 2" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem3 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 3" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem4 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 4" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem5 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 5" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem6 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 6" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NR = DB::select('select * from fichehors where idfiche =? AND state="NR" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NH1=  DB::select('select * from fichehors where idfiche =? AND semaine="semaine 1" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NH2=  DB::select('select * from fichehors where idfiche =? AND semaine="semaine 2" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NH3=  DB::select('select * from fichehors where idfiche =? AND semaine="semaine 3" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NH4=  DB::select('select * from fichehors where idfiche =? AND semaine="semaine 4" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NH5=  DB::select('select * from fichehors where idfiche =? AND semaine="semaine 5" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NH6=  DB::select('select * from fichehors where idfiche =? AND semaine="semaine 6" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $totSe1=0;
        $totSe2=0;
        $totSe3=0;
        $totSe4=0;
        $totSe5=0;
        $totSe6=0;
        foreach($NH1 as $N1){
        $totSe1= $totSe1+$N1->heuresEffectu;
        }
        foreach($NH2 as $N2){
            $totSe2= $totSe2+$N2->heuresEffectu;
            }
            foreach($NH3 as $N3){
                $totSe3= $totSe3+$N3->heuresEffectu;
                }
                foreach($NH4 as $N4){
                    $totSe4= $totSe4+$N4->heuresEffectu;
                    }
                    foreach($NH5 as $N5){
                        $totSe5= $totSe5+$N5->heuresEffectu;
                        }
                        foreach($NH6 as $N6){
                            $totSe6= $totSe6+$N6->heuresEffectu;
                            }
        $countNR=0;
        /*if(Gate::allows('access-admin')){
            return view('ADMIN/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
            ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR,'fiiche'=>$fiiche]);
            }
            if(Gate::allows('access-direction')){
                return view('DIRECTION/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
                ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR,'fiiche'=>$fiiche]);
                }*/
    
                if($user->direction==1){
                    if($user->SeeAsAdmin==1){
                    return view('ADMIN/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'totSe1'=> $totSe1,'totSe6'=> $totSe6,'totSe2'=> $totSe2,'totSe3'=> $totSe3,'totSe4'=> $totSe4,'totSe5'=> $totSe5
                    ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'sem6'=>$sem6,'NR'=>$NR,'fiiche'=>$fiiche]);
                    }else{
                        return view('DIRECTION/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'totSe1'=> $totSe1,'totSe6'=> $totSe6,'totSe2'=> $totSe2,'totSe3'=> $totSe3,'totSe4'=> $totSe4,'totSe5'=> $totSe5
                    ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'sem6'=>$sem6,'NR'=>$NR,'fiiche'=>$fiiche]);
                    }
                }
                else if($user->admin==1 AND $user->direction==0){
                    return view('ADMIN/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'totSe1'=> $totSe1,'totSe6'=> $totSe6,'totSe2'=> $totSe2,'totSe3'=> $totSe3,'totSe4'=> $totSe4,'totSe5'=> $totSe5
            ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'sem6'=>$sem6,'NR'=>$NR,'fiiche'=>$fiiche]);
                }else if($user->admin==0 AND $user->direction==1){
                    return view('DIRECTION/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'totSe1'=> $totSe1,'totSe6'=> $totSe6,'totSe2'=> $totSe2,'totSe3'=> $totSe3,'totSe4'=> $totSe4,'totSe5'=> $totSe5
                    ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'sem6'=>$sem6,'NR'=>$NR,'fiiche'=>$fiiche]);
                }
        }

        public function validerFicheRS(Request $request) {
            $idU = $request->input('idUser');
            $idF = $request->input('idfiche');
            $fiche = DB::select('select * from fichehors where idfiche =? AND idUser = ?',[$idF,$idU]);
            $countNR=0;
            foreach ($fiche as $fi) {
                if($fi->state=="NR"){
                    $countNR=$countNR+1;
                }
                else{
                    $countNR=0;
                }
            }
            if($countNR==0)
            {
                DB::update('update fichehors set statutF="valideRS" where idfiche = ? and idUser = ?',[$idF,$idU]);
                return redirect()->back();
            }
            else{
                return redirect()->back()->with('status', 'vous devez renseigner tout les champs');
            }
            }

        public function validerFicheDir(Request $request) {
            $idF = $request->input('idfiche');
            $idU = $request->input('idUser');
            DB::update('update fichehors set statutF="valide" where idfiche = ? and idUser = ?',[$idF,$idU]);
            return redirect()->back();
            }

        public function validerVentil(Request $request) {
            $idF = $request->input('idfiche');
            $idU = $request->input('idUser');
            $FRASAD = $request->input('FRASAD');
            $Entraide = $request->input('Entraide');
            $Fédération = $request->input('Fédération');
            $Prestataire = $request->input('Prestataire');
            $Voisineurs = $request->input('Voisineurs');
            $ADU = $request->input('ADU');
            $AI = $request->input('AI');
            $Mandataires = $request->input('Mandataires');
            $SOS = $request->input('SOS');
            $Délégation = $request->input('Délégation');
            $ADVM = $request->input('ADVM');
            $venti = DB::select('select * from ventilationfiches where idFiche =? AND idUser = ?',[$idF,$idU]);
            if(ventilationfiche::where('idUser', $idU)->where('idFiche', $idF)->count() > 0){
                DB::update('update ventilationfiches set FRASAD=?,Entraide=?,Federation=?,Prestataire=?,Voisineurs=?,ADU=?,Mandataires=?
                ,SOS=?,Delegation=?,ADVM=?,AI=? where idfiche = ? and idUser = ?',[$FRASAD,$Entraide,$Fédération,$Prestataire,$Voisineurs,$ADU,$Mandataires,$SOS,$Délégation,$ADVM,$AI,$idF,$idU]);
                }
            else
                {
                DB::insert('insert into ventilationFiches (idFiche,idUser,FRASAD,Entraide,Federation,Prestataire,Voisineurs,ADU,Mandataires
                ,SOS,Delegation,ADVM,AI) values (?,?,?,?,?,?,?,?,?,?,?,?,?)', [$idF,$idU,$FRASAD,$Entraide,$Fédération,$Prestataire,$Voisineurs,$ADU,$Mandataires,$SOS,$Délégation,$ADVM,$AI]);
                }
            return redirect()->back();
            }
    
        public function refuse(Request $request) {
            $idf = $request->id;
            $fiche = fichehor::find($idf);
            $id = $fiche->id;
            DB::update('update fichehors set state ="RR" where id=?',[$id]);
            return view('ADMIN/FicheHoraireDetails',['id'=>$id]);
        }

        public function confirm(Request $request) {
            $idf = $request->id;
            $fiche = fichehor::find($idf);
            $id = $fiche->id;
            DB::update('update fichehors set state ="VR" where id=?',[$id]);
            return view('ADMIN/FicheHoraireDetails',['id'=>$id]);
        }

        public function confirmAll(Request $request) {
            $idUser = $request->input('idUser7');
            $idfiche = $request->input('idfiche7');
            DB::update('update fichehors set state ="VR" where idfiche=? AND idUser=?',[$idfiche,$idUser]);
            return redirect()->back();
        }

        public function showDep(Request $request,$id,$idfiche) {
            $idUser = $request->input('idUser4');
            $idfiche = $request->input('idfiche4');
            $user=Auth::user();
            $session_str = $user->service;
            if($user->direction==1){
                $employes = DB::table('employes')->get();
                $emplo = DB::select('SELECT identifiant,CONCAT(nom, " ", prenom) AS fullname FROM employes ');
            }
            else{
                $employes = DB::table('employes')->select()->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
                $emplo = DB::select('SELECT identifiant,CONCAT(nom, " ", prenom) AS fullname FROM employes where service LIKE ?',[$session_str]);
    
            }
            $empl = DB::select('select * from employes where id =?',[$id]);
            $dep = DB::select('select * from depassements where identifiant =(select identifiant from employes where id=?) and idFiche=?',[$id,$idfiche]);
            return view('ADMIN.depassementsPage',['employes'=>$employes,'idUser'=>$idUser,'empl'=>$empl,'dep'=>$dep]);
        }

        public function showDepInfos(Request $request,$id) {
            $user=Auth::user();
            $session_str = $user->service;
            if($user->direction==1){
                $employes = DB::table('employes')->get();
                $emplo = DB::select('SELECT identifiant,CONCAT(nom, " ", prenom) AS fullname FROM employes ');
            }
            else{
                $employes = DB::table('employes')->select()->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
                $emplo = DB::select('SELECT identifiant,CONCAT(nom, " ", prenom) AS fullname FROM employes where service LIKE ?',[$session_str]);
    
            }
            $dep=DB::select('select * from depassements where id=?',[$id]);
            return view('ADMIN.depassementsEdit',['employes'=>$employes,'dep'=>$dep]);
        }

        public function editDep(Request $request) {
            if(!Gate::any(['access-admin', 'access-direction'])){
                abort('403');
                }
            $semaine = $request->input('semaine');
            $nombreH = $request->input('nombreH');
            $motif = $request->input('motif');
            $id = $request->input('id');
            DB::update('update depassements set semaine = ?,nombreH = ?, motif=? where id = ?',[$semaine,$nombreH,$motif,$id]);
            return redirect()->back()->with('status', 'Les modifications ont été bien enregistrés');
            }

        public function showST($id) {
            $user=Auth::user();
            $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
            $session_str = $user->service;
            if($user->direction==1){
                $employees = DB::table('employes')->get();
    
            }else{
                $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            }
            $employes = DB::select('select * from employes where id = ?',[$id]);
            return view('ADMIN/semaineType',['employes'=>$employes,'employees'=>$employees,'fiiche'=>$fiiche]);
            }



         public function ajouterST(Request $request){
            $identifiant = $request->input('identifiant');
            $FM1 = $request->input('FM1');
            $DM1 = $request->input('DM1');
            $FA1 = $request->input('FA1');
            $DA1 = $request->input('DA1');
            $FS1 = $request->input('FS1');
            $DS1 = $request->input('DS1');
            if($FM1==null or $DM1==null)
            {
                $hourdiffLundiMat=0;
            }else{
                $parts = explode(':', $DM1);
                $parts2 = explode(':', $FM1);
                $pepe1 = $parts[0] + floor(($parts[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts2[0] + floor(($parts2[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffLundiMat = $pepe2 - $pepe1;
            }
            if($FA1==null or $DA1==null)
            {
                $hourdiffLundiAprem=0;
            }else{
                $parts3 = explode(':', $DA1);
                $parts4 = explode(':', $FA1);
                $pepe1 = $parts3[0] + floor(($parts3[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts4[0] + floor(($parts4[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffLundiAprem = $pepe2 - $pepe1;
            }
            if($FS1==null or $DS1==null)
            {
                $hourdiffLundiSoir=0;
            }else{
                $parts5 = explode(':', $DS1);
                $parts6 = explode(':', $FS1);
                $pepe1 = $parts5[0] + floor(($parts5[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts6[0] + floor(($parts6[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffLundiSoir = $pepe2 - $pepe1;
            }
            $poidsLundi = $hourdiffLundiMat+$hourdiffLundiAprem+ $hourdiffLundiSoir ;
            $FM2 = $request->input('FM2');
            $DM2 = $request->input('DM2');
            $FA2 = $request->input('FA2');
            $DA2 = $request->input('DA2');
            $FS2 = $request->input('FS2');
            $DS2 = $request->input('DS2');
            if($FM2==null or $DM2==null)
            {
                $hourdiffMardiMat=0;
            }else{
                $parts7 = explode(':', $DM2);
                $parts8 = explode(':', $FM2);
                $pepe1 = $parts7[0] + floor(($parts7[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts8[0] + floor(($parts8[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffMardiMat = $pepe2 - $pepe1;
            }
            if($FA2==null or $DA2==null)
            {
                $hourdiffMardiAprem=0;
            }else{
                $parts9 = explode(':', $DA2);
                $parts10 = explode(':', $FA2);
                $pepe1 = $parts9[0] + floor(($parts9[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts10[0] + floor(($parts10[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffMardiAprem = $pepe2 - $pepe1;
            }
            if($FS2==null or $DS2==null)
            {
                $hourdiffMardiSoir=0;
            }else{
                $parts11 = explode(':', $DS2);
                $parts12 = explode(':', $FS2);
                $pepe1 = $parts11[0] + floor(($parts11[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts12[0] + floor(($parts12[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffMardiSoir = $pepe2 - $pepe1;
            }
            $poidsMardi = $hourdiffMardiMat + $hourdiffMardiAprem +  $hourdiffMardiSoir;
            $FM3 = $request->input('FM3');
            $DM3 = $request->input('DM3');
            $FA3 = $request->input('FA3');
            $DA3 = $request->input('DA3');
            $FS3 = $request->input('FS3');
            $DS3 = $request->input('DS3');
            if($FM3==null or $DM3==null)
            {
                $hourdiffMercMat=0;
            }else{
                $parts13 = explode(':', $DM3);
                $parts14 = explode(':', $FM3);
                $pepe1 = $parts13[0] + floor(($parts13[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts14[0] + floor(($parts14[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffMercMat = $pepe2 - $pepe1;
            }
            if($FA3==null or $DA3==null)
            {
                $hourdiffMercAprem=0;
            }else{
                $parts15 = explode(':', $DA3);
                $parts16 = explode(':', $FA3);
                $pepe1 = $parts15[0] + floor(($parts15[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts16[0] + floor(($parts16[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffMercAprem = $pepe2 - $pepe1;
            }
            if($FS3==null or $DS3==null)
            {
                $hourdiffMercSoir=0;
            }else{
                $parts17 = explode(':', $DS3);
                $parts18 = explode(':', $FS3);
                $pepe1 = $parts17[0] + floor(($parts17[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts18[0] + floor(($parts18[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffMercSoir = $pepe2 - $pepe1;
            }

            $poidsMerc = $hourdiffMercMat + $hourdiffMercAprem +  $hourdiffMercSoir;
            $FM4 = $request->input('FM4');
            $DM4 = $request->input('DM4');
            $FA4 = $request->input('FA4');
            $DA4 = $request->input('DA4');
            $FS4 = $request->input('FS4');
            $DS4 = $request->input('DS4');
            if($FM4==null or $DM4==null)
            {
                $hourdiffJeudiMat=0;
            }else{
                $parts19 = explode(':', $DM4);
                $parts20 = explode(':', $FM4);
                $pepe1 = $parts19[0] + floor(($parts19[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts20[0] + floor(($parts20[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffJeudiMat = $pepe2 - $pepe1;
            }
            if($FA4==null or $DA4==null)
            {
                $hourdiffJeudiAprem=0;
            }else{
                $parts21 = explode(':', $DA4);
                $parts22 = explode(':', $FA4);
                $pepe1 = $parts21[0] + floor(($parts21[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts22[0] + floor(($parts22[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffJeudiAprem = $pepe2 - $pepe1;
            }
            if($FS4==null or $DS4==null)
            {
                $hourdiffJeudiSoir=0;
            }else{
                $parts23 = explode(':', $DS4);
                $parts24 = explode(':', $FS4);
                $pepe1 = $parts23[0] + floor(($parts23[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts24[0] + floor(($parts24[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffJeudiSoir = $pepe2 - $pepe1;
            }
            $poidsJeudi = $hourdiffJeudiMat + $hourdiffJeudiAprem +  $hourdiffJeudiSoir;
            $FM5 = $request->input('FM5');
            $DM5 = $request->input('DM5');
            $FA5 = $request->input('FA5');
            $DA5 = $request->input('DA5');
            $FS5 = $request->input('FS5');
            $DS5 = $request->input('DS5');
            if($FM5==null or $DM5==null)
            {
                $hourdiffVenMat=0;
            }else{
                $parts25 = explode(':', $DM5);
                $parts26 = explode(':', $FM5);
                $pepe1 = $parts25[0] + floor(($parts25[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts26[0] + floor(($parts26[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffVenMat = $pepe2 - $pepe1;
            }
            if($FA5==null or $DA5==null)
            {
                $hourdiffVenAprem=0;
            }else{
                $parts27 = explode(':', $DA5);
                $parts28 = explode(':', $FA5);
                $pepe1 = $parts27[0] + floor(($parts27[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts28[0] + floor(($parts28[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffVenAprem = $pepe2 - $pepe1;
            }
            if($FS5==null or $DS5==null)
            {
                $hourdiffVenSoir=0;
            }else{
                $parts29 = explode(':', $DS5);
                $parts30 = explode(':', $FS5);
                $pepe1 = $parts29[0] + floor(($parts29[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts30[0] + floor(($parts30[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffVenSoir = $pepe2 - $pepe1;
            }
            $poidsVen = $hourdiffVenMat + $hourdiffVenAprem +  $hourdiffVenSoir;
            $FM6 = $request->input('FM6');
            $DM6 = $request->input('DM6');
            $FA6 = $request->input('FA6');
            $DA6 = $request->input('DA6');
            $FS6 = $request->input('FS6');
            $DS6 = $request->input('DS6');
            if($FM6==null or $DM6==null)
            {
                $hourdiffSamMat=0;
            }else{
                $parts31 = explode(':', $DM6);
                $parts32 = explode(':', $FM6);
                $pepe1 = $parts31[0] + floor(($parts31[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts32[0] + floor(($parts32[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffSamMat = $pepe2 - $pepe1;
            }
            if($FA6==null or $DA6==null)
            {
                $hourdiffSamAprem=0;
            }else{
                $parts33 = explode(':', $DA6);
                $parts34 = explode(':', $FA6);
                $pepe1 = $parts33[0] + floor(($parts33[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts34[0] + floor(($parts34[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffSamAprem = $pepe2 - $pepe1;
            }
            if($FS6==null or $DS6==null)
            {
                $hourdiffSamSoir=0;
            }else{
                $parts35 = explode(':', $DS6);
                $parts36 = explode(':', $FS6);
                $pepe1 = $parts35[0] + floor(($parts35[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts36[0] + floor(($parts36[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffSamSoir = $pepe2 - $pepe1;
            }
            $poidsSam = $hourdiffSamMat + $hourdiffSamAprem +  $hourdiffSamSoir;
            $FM7 = $request->input('FM7');
            $DM7 = $request->input('DM7');
            $FA7 = $request->input('FA7');
            $DA7 = $request->input('DA7');
            $FS7 = $request->input('FS7');
            $DS7 = $request->input('DS7');
            if($FM7==null or $DM7==null)
            {
                $hourdiffDimMat=0;
            }else{
                $parts37 = explode(':', $DM7);
                $parts38 = explode(':', $FM7);
                $pepe1 = $parts37[0] + floor(($parts37[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts38[0] + floor(($parts38[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffDimMat = $pepe2 - $pepe1;
            }
            if($FA7==null or $DA7==null)
            {
                $hourdiffDimAprem=0;
            }else{
                $parts39 = explode(':', $DA7);
                $parts40 = explode(':', $FA7);
                $pepe1 = $parts39[0] + floor(($parts39[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts40[0] + floor(($parts40[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffDimAprem = $pepe2 - $pepe1;
            }
            if($FS7==null or $DS7==null)
            {
                $hourdiffDimSoir=0;
            }else{
                $parts41 = explode(':', $DS7);
                $parts42 = explode(':', $FS7);
                $pepe1 = $parts41[0] + floor(($parts41[1]/60)*100) / 100 . PHP_EOL;
                $pepe2 = $parts42[0] + floor(($parts42[1]/60)*100) / 100 . PHP_EOL;
                $pepe1=floatval($pepe1);
                $pepe2=floatval($pepe2);
                $hourdiffDimSoir = $pepe2 - $pepe1;
            }
            $poidsDim = $hourdiffDimMat + $hourdiffDimAprem +  $hourdiffDimSoir;
            $fiches=DB::select('select * from fichehors where idUser=? and statutF="EnCours"',[$identifiant]);
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Lun')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Lun%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsLundi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Mar')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Mar%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsMardi,$identifiant]);
                   
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Mer')){
                   
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Mer%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsMerc,$identifiant]);
              
                 
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Jeu')){
                    
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Jeu%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsJeudi,$identifiant]);
                   
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Ven')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Ven%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsVen,$identifiant]);
                  
                    
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Sam')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Sam%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsSam,$identifiant]);
                   
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Dim')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Dim%" AND statutF="EnCours" and (typeJour="Travaillé" or typeJour="RCR" or typeJour IS NULL)',
                    [$poidsDim,$identifiant]);
                  
                }
            }
            $fichehor = DB::select('select * from fichehors where idUser = ?',[$identifiant]);
            foreach ($fichehor as $fi) {
                $DateFiche=$fi->Date;
                $ecartJour=$fi->heuresEffectu-$fi->Poids;
                DB::update('update fichehors set ecart=? where idUser = ? AND Date=?',
                [$ecartJour,$identifiant,$DateFiche]);
            }
            $st = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant'),'jour' =>  request('Lun')],
                ['DM' => request('DM1'),'FM' => request('FM1'),'DA' => request('DA1'),'FA' => request('FA1'),'DS' => request('DS1')
                ,'FS' => request('FS1')]
            );
            $st2 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant2'),'jour' =>  request('Mar')],
                ['DM' => request('DM2'),'FM' => request('FM2'),'DA' => request('DA2'),'FA' => request('FA2'),'DS' => request('DS2')
                ,'FS' => request('FS2')]
            );
            $st3 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant3'),'jour' =>  request('Mer')],
                ['DM' => request('DM3'),'FM' => request('FM3'),'DA' => request('DA3'),'FA' => request('FA3'),'DS' => request('DS3')
                ,'FS' => request('FS3')]
            );
            $st4 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant4'),'jour' =>  request('Jeu')],
                ['DM' => request('DM4'),'FM' => request('FM4'),'DA' => request('DA4'),'FA' => request('FA4'),'DS' => request('DS4')
                ,'FS' => request('FS4')]
            );
            $st5 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant5'),'jour' =>  request('Ven')],
                ['DM' => request('DM5'),'FM' => request('FM5'),'DA' => request('DA5'),'FA' => request('FA5'),'DS' => request('DS5')
                ,'FS' => request('FS5')]
            );
            $st6 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant6'),'jour' =>  request('Sam')],
                ['DM' => request('DM6'),'FM' => request('FM6'),'DA' => request('DA6'),'FA' => request('FA6'),'DS' => request('DS6')
                ,'FS' => request('FS6')]
            );
            $st7 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant7'),'jour' =>  request('Dim')],
                ['DM' => request('DM7'),'FM' => request('FM7'),'DA' => request('DA7'),'FA' => request('FA7'),'DS' => request('DS7')
                ,'FS' => request('FS7')]
            );
            DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Lundi"',
        [$poidsLundi,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Mardi"',
        [$poidsMardi,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Mercredi"',
        [$poidsMerc,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Jeudi"',
        [$poidsJeudi,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Vendredi"',
        [$poidsVen,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Samedi"',
        [$poidsSam,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Dimanche"',
        [$poidsDim,$identifiant]);
            return redirect()->back()->with('status', 'Les modifications ont été bien enregistrés');
            }


            
        public function export(Request $request) 
        {
            $idFi = $request->input('idF');
            $idUser = $request->input('idUser');
            $nom = $request->input('nom');
            $prenom = $request->input('prenom');
            $statutF = $request->input('statutF');
            if($statutF=="EnCours"){
                $statutF="En cours";
            }
            else if($statutF=="AttValiRS"){
                $statutF="En attente validation RS";
            }
            else if($statutF=="valideRS"){
                $statutF="Validée RS";
            }else if($statutF=="valide"){
                $statutF="validée";
            }

            return Excel::download(new AllFichesExport($request->id,$idFi,$nom,$prenom,$statutF), 'Fiche horaire.xlsx');

        }

              
        public function export2(Request $request) 
        {
            $idFi = $request->input('idF');
            $nom = $request->input('nom');
            $prenom = $request->input('prenom');
            $statutF = $request->input('statutF');
            if($statutF=="EnCours"){
                $statutF="En cours";
            }
            else if($statutF=="AttValiRS"){
                $statutF="En attente validation RS";
            }
            else if($statutF=="valideRS"){
                $statutF="Validée RS";
            }else if($statutF=="valide"){
                $statutF="validée";
            }
            return Excel::download(new FichesDetailsExport($request->id,$idFi,$nom,$prenom,$statutF), 'Fiche horaire.xlsx');
        }

        public function searchFiche(Request $request,$id) 
        {
            $search_text= $request->input('searchfiche');
            $user=Auth::user();
            $session_str = $user->service;
            if($user->direction==1){
                $employees = DB::table('employes')->get();
    
            }else{
                $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            }
            $employes = DB::select('select * from employes where id = ?',[$id]);
            $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
            $fiche = DB::select('select DISTINCT idUser,idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) and year=? order BY mois ASC',[$id,$search_text]);
            return view('ADMIN/ficheHoraire',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche]);
        }

        public function search(Request $request) 
        {
         $search_text= $request->input('search');
        $user=Auth::user();
        $session_str = $user->service;
        $employes = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->where('nom', 'like', '%'.$search_text.'%')->orwhere('prenom', 'like', '%'.$search_text.'%')->get();
        $structures = DB::select('select * from structures');
        $services = DB::select('select * from services');
        $employees = DB::table('employes')->where('nom', 'like', '%'.$search_text.'%')->orwhere('prenom', 'like', '%'.$search_text.'%')->get();
        /*if(Gate::allows('access-admin')){
            return view('ADMIN/PageEmployes',[
                'employes' =>$employes,'structures'=>$structures,
            ]);
        }
        if(Gate::allows('access-direction')){
            return view('DIRECTION/PageEmployes',[
                'employees' =>$employees,'structures'=>$structures,
            ]);
        } */
        if($user->admin==1 AND $user->direction==1){
            return view('DIRECTION/search',[
                'employees' =>$employees,'structures'=>$structures,'services'=>$services,
            ]);
        }
        else if($user->admin==1 AND $user->direction==0){
            return view('ADMIN/search',[
                'employes' =>$employes,'structures'=>$structures,'services'=>$services,
            ]);
        }else if($user->admin==0 AND $user->direction==1){
            return view('DIRECTION/search',[
                'employees' =>$employees,'structures'=>$structures,'services'=>$services,
            ]);
        }
        }

        public function searchventi(Request $request,$id) 
        {
            $search_text= $request->input('searchventi');
            $user=Auth::user();
            $session_str = $user->service;
            if($user->direction==1){
                $employees = DB::table('employes')->get();
    
            }else{
                $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            }
            $employes = DB::select('select * from employes where id = ?',[$id]);
            $fiicheS= DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
            $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
            $fiche = DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and idfiche=?',[$id,$search_text]);
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
            $poids=0;
            $AI=0;
            foreach ($fiche as $fi) {
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
            $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM+$AI;
            $diff=$totalVentil-$poids;
            return view('ADMIN/ventilationfiche',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
            'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,
            'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'AI'=>$AI,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'fiicheS'=>$fiicheS]);
        }

        public function searchStat(Request $request,$id) 
        {
            $search_text= $request->input('searchstat');
            $user=Auth::user();
            $session_str = $user->service;
            if($user->direction==1){
                $employees = DB::table('employes')->get();
    
            }else{
                $employees = DB::table('employes')->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            }
            $fiicheS= DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
            $employes = DB::select('select * from employes where id = ?',[$id]);
            $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
            $fiche = DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and year=?',[$id,$search_text]);
            $date = date('Y-m-01', strtotime("first day of this month"));
            $year = date('Y', strtotime($date));
            $depassementJan =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Janvier%"',[$id]);
            $depassementFev =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Février%"',[$id]);
            $depassementMar =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Mars%"',[$id]);
            $depassementAvr =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Avril%"',[$id]);
            $depassementMai =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Mai%"',[$id]);
            $depassementJuin =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Juin%"',[$id]);
            $depassementJuillet =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Juillet%"',[$id]);
            $depassementAout =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Août%"',[$id]);
            $depassementSept =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Septembre%"',[$id]);
            $depassementOct =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Octobre%"',[$id]);
            $depassementNov =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Novembre%"',[$id]);
            $depassementDec =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
            idFiche LIKE "%Décembre%"',[$id]);
            $ecartJan =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Janvier%"',[$id]);
                $ecartFev =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Février%"',[$id]);
                $ecartMar =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Mars%"',[$id]);
                $ecartAvr =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Avril%"',[$id]);
                $ecartMai =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Mai%"',[$id]);
                $ecarJuin =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Juin%"',[$id]);
                $ecartJuillet =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Juillet%"',[$id]);
                $ecartAout =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Août%"',[$id]);
                $ecartSept =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Septembre%"',[$id]);
                $ecartOct =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Octobre%"',[$id]);
                $ecartNov =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Novembre%"',[$id]);
                $ecartDec =  DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and
                idfiche LIKE "%Décembre%"',[$id]);
                $EJan=0;
                $EFev=0;
                $EMar=0;
                $EAvr=0;
                $EMai=0;
                $EJuin=0;
                $EJuil=0;
                $EAout=0;
                $ESept=0;
                $EOct=0;
                $ENov=0;
                $EDec=0;
                foreach($ecartJan as $ecaJan)
                {
                    if(str_contains($ecaJan->idfiche, $search_text)){
                        $EJan=$EJan+$ecaJan->ecart;
                    }
                }
                foreach($ecartFev as $ecaFev)
                {
                    if(str_contains($ecaFev->idfiche, $search_text)){
                        $EFev=$EFev+$ecaFev->ecart;
                    }
                }
                foreach($ecartMar as $ecaMar)
                {
                    if(str_contains($ecaMar->idfiche, $search_text)){
                        $EMar=$EMar+$ecaMar->ecart;
                    }
                }
                foreach($ecartAvr as $ecaAvr)
                {
                    if(str_contains($ecaAvr->idfiche, $search_text)){
                        $EAvr=$EAvr+$ecaAvr->ecart;
                    }
                }
                foreach($ecartMai as $ecaMai)
                {
                    if(str_contains($ecaMai->idfiche, $search_text)){
                        $EMai=$EMai+$ecaMai->ecart;
                    }
                }
                foreach($ecarJuin as $ecaJuin)
                {
                    if(str_contains($ecaJuin->idfiche, $search_text)){
                        $EJuin=$EJuin+$ecaJuin->ecart;
                    }
                }
                foreach($ecartJuillet as $ecaJuil)
                {
                    if(str_contains($ecaJuil->idfiche, $search_text)){
                        $EJuil=$EJuil+$ecaJuil->ecart;
                    }
                }
                foreach($ecartAout as $ecaAou)
                {
                    if(str_contains($ecaAou->idfiche, $search_text)){
                        $EAout=$EAout+$ecaAou->ecart;
                    }
                }
                foreach($ecartSept as $ecaSept)
                {
                    if(str_contains($ecaSept->idfiche, $search_text)){
                        $ESept=$ESept+$ecaSept->ecart;
                    }
                }
                foreach($ecartOct as $ecaOct)
                {
                    if(str_contains($ecaOct->idfiche, $search_text)){
                        $EJan=$EJan+$ecaOct->ecart;
                    }
                }
                foreach($ecartNov as $ecaNov)
                {
                    if(str_contains($ecaNov->idfiche, $search_text)){
                        $ENov=$ENov+$ecaNov->ecart;
                    }
                }
                foreach($ecartDec as $ecaDec)
                {
                    if(str_contains($ecaDec->idfiche, $search_text)){
                        $EDec=$EDec+$ecaDec->ecart;
                    }
                }
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
                if(str_contains($fi->idfiche,  $search_text)){
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
                if(str_contains($fi->idfiche,  $search_text)){
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
                if(str_contains($fi->idfiche,  $search_text)){
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
            $totEcart=$EJan+$EFev+$EMar+$EAvr+$EMai+$EJuin+$EJuil+$EAout+$ESept+$EOct+$ENov+$EDec;
            $totDepa=$DJan+$DFev+$DMar+$DAvr+$DMai+$DJuin+$DJuil+$DAout+$DSept+$DOct+$DNov+$DDec;
            $totRecup= $totDepa+$totEcart;
            if($totRecup>=0)
            {
                $totRecup=0;
            }
            $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM+$AI;
            $diff=$totalVentil-$poids;
            return view('ADMIN/stat',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
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
            'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,'search_text'=>$search_text,'EJan'=>$EJan,'EFev'=>$EFev,'EMar'=>$EMar,'EAvr'=>$EAvr,'EMai'=>$EMai,'EJuin'=>$EJuin,
            'EJuil'=>$EJuil,'EAout'=>$EAout,'ESept'=>$ESept,'EOct'=>$EOct,'ENov'=>$ENov,'EDec'=>$EDec,'totEcart'=>$totEcart,'totDepa'=>$totDepa,'totRecup'=>$totRecup,
        ]);
    }

    public function ajouterFiche(Request $request){
        $fiche = new fichehor();
        $annee = request('annee');
        $mois = request('mois');
        $identifiant = request('identifiant');
        $user=Auth::user();
        $session_id = $user->identifiant;
        $semainetype=DB::select('select * from semainetypes where idUser=?',[$identifiant]);
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-01",strtotime($annee."-".$mois."-01"));
        $dateF = date("t", strtotime($date));
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
        $idFi=  $annee." - ".$month;

        if(fichehor::where('idUser', $identifiant)->where('idfiche', 'like', $idFi)->count()==0){
        $s=1;
        for($i=1;$i <= $dateF; $i++){
            $date = date("$annee-m-$i", strtotime("+1 day", strtotime($date)));
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
            if($day_name=="Lun"){
                if($i==1)
                {
                    $s=1;
                }
                else{
                $s=$s+1;
                }
            }
            $week = "semaine ".$s;

            $idF=  $year_num." - ".$month;
            $dateBD= $day_name." ".$day_num." ".$month;
            DB::insert('insert into fichehors (idfiche,Date,idUser,semaine,mois,year) values (?,?,?,?,?,?)', [$idF,$dateBD,$identifiant,$week,$mois,$annee]);
            $fiches=DB::select('select * from fichehors where idUser=? and idfiche=?',[$identifiant,$idF]);
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
    }else{
        return redirect()->back()->with('status', 'La fiche horaire existe déjà');
    }
    }
    }

