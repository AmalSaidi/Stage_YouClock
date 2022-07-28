<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Session;
use App\Models\fichehor;
use Illuminate\Support\Facades\Redirect;
use App\Models\ventilation;
use App\Models\ventilationfinal;

class historique extends Controller
{
    public function index() {
        $user=Auth::user();
        $session_id = $user->identifiant;
        $employes = DB::select('select * from employes where identifiant=? ',[$session_id]);
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = ?',[$session_id]);
        return view('USER/historique',['fiiche'=>$fiiche,'employes'=>$employes]);
        }
    
        public function details($id){
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
            $affichage =DB::select('select * from fichehors where idUser = ? and idfiche=? ',[$session_id,$id]);
            return view('USER.historiqueDetails',[ 'employes' =>$employes,'date' =>$date,'date2' =>$date2,'dateF' =>$dateF,'month' =>$month,
            'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'samedi' =>$samedi,
            'dimanche' =>$dimanche,'affichage' => $affichage,'p'=>$p,'f'=>$f,'totEcart'=>$totEcart,'ajout'=>$ajout,'activites'=>$activites,
            ]);
        }
}
