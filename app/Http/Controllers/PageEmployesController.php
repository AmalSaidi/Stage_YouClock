<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\employes;
use App\Models\ventilation;
use App\Models\fichehor;
use App\Models\horairesemaine;
use App\Models\semainetype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageEmployesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user=Auth::user();
        $session_str = $user->structure;
        $employes = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $structures = DB::select('select * from structures');
        $employees = DB::select('select * from employes');
        if(Gate::allows('access-admin')){
            return view('ADMIN/PageEmployes',[
                'employes' =>$employes,'structures'=>$structures,
            ]);
        }
        if(Gate::allows('access-direction')){
            return view('DIRECTION/PageEmployes',[
                'employees' =>$employees,'structures'=>$structures,
            ]);
        }
    }


    public function store(){

        $employes = new employes();

        $employes->nom = request('nom');
        $employes->prenom = request('prenom');
        $employes->identifiant = request('identifiant');
        $employes->structure = request('structure');
        $employes->intitule = request('intitule');
        $employes->dateEmbauche = request('dateEmbauche');
        $employes->Datefin = request('Datefin');
        $employes->TypeContrat = request('TypeContrat');
        $employes->mail = request('mail');

        $employes->save();

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
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        return view('ADMIN/infoperso',['employes'=>$employes,'employees'=>$employees,'fiche'=>$fiche]);
        }

    public function showRH($id) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $Lun= DB::select('select * from semainetypes where jour="Lundi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mar= DB::select('select * from semainetypes where jour="Mardi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mer= DB::select('select * from semainetypes where jour="Mercredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Jeu= DB::select('select * from semainetypes where jour="Jeudi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Ven= DB::select('select * from semainetypes where jour="Vendredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Sam= DB::select('select * from semainetypes where jour="Samedi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Dim= DB::select('select * from semainetypes where jour="Dimanche" and idUser=(select identifiant from employes where id=?)',[$id]);
        return view('ADMIN/RH',['employes'=>$employes,'employees'=>$employees,'Lun'=>$Lun,'Mar'=>$Mar,'Mer'=>$Mer
        ,'Jeu'=>$Jeu,'Ven'=>$Ven,'Sam'=>$Sam,'Dim'=>$Dim,'fiche'=>$fiche]);
        }

    public function showFiche($id) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
        return view('ADMIN/ficheHoraire',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche]);
        }

    public function showFicheComplete($id,$idfiche) {
        $user=Auth::user();
        $session_str = $user->structure;
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
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
        $NR = DB::select('select * from fichehors where idfiche =? AND state="NR" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $countNR=0;
        if(Gate::allows('access-admin')){
            return view('ADMIN/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
            ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR,'fiiche'=>$fiiche]);
            }
            if(Gate::allows('access-direction')){
                return view('DIRECTION/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
                ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR,'fiiche'=>$fiiche]);
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


        public function showST($id) {
            $user=Auth::user();
            $session_str = $user->structure;
            $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            $employes = DB::select('select * from employes where id = ?',[$id]);
            return view('ADMIN/semaineType',['employes'=>$employes,'employees'=>$employees]);
            }

         public function ajouterST(Request $request){
            $identifiant = $request->input('identifiant');
            $FM1 = $request->input('FM1');
            $DM1 = $request->input('DM1');
            $FA1 = $request->input('FA1');
            $DA1 = $request->input('DA1');
            $FS1 = $request->input('FS1');
            $DS1 = $request->input('DS1');
            $hourdiffLundiMat = round((strtotime($FM1) - strtotime($DM1 ))/3600, 1);
            $hourdiffLundiAprem = round((strtotime($FA1) - strtotime($DA1 ))/3600, 1);
            $hourdiffLundiSoir = round((strtotime($FS1) - strtotime($DS1 ))/3600, 1);
            $poidsLundi = $hourdiffLundiMat + $hourdiffLundiAprem +  $hourdiffLundiSoir;
            $FM2 = $request->input('FM2');
            $DM2 = $request->input('DM2');
            $FA2 = $request->input('FA2');
            $DA2 = $request->input('DA2');
            $FS2 = $request->input('FS2');
            $DS2 = $request->input('DS2');
            $hourdiffMardiMat = round((strtotime($FM2) - strtotime($DM2 ))/3600, 1);
            $hourdiffMardiAprem = round((strtotime($FA2) - strtotime($DA2 ))/3600, 1);
            $hourdiffMardiSoir = round((strtotime($FS2) - strtotime($DS2 ))/3600, 1);
            $poidsMardi = $hourdiffMardiMat + $hourdiffMardiAprem +  $hourdiffMardiSoir;
            $FM3 = $request->input('FM3');
            $DM3 = $request->input('DM3');
            $FA3 = $request->input('FA3');
            $DA3 = $request->input('DA3');
            $FS3 = $request->input('FS3');
            $DS3 = $request->input('DS3');
            $hourdiffMercMat = round((strtotime($FM3) - strtotime($DM3 ))/3600, 1);
            $hourdiffMercAprem = round((strtotime($FA3) - strtotime($DA3 ))/3600, 1);
            $hourdiffMercSoir = round((strtotime($FS3) - strtotime($DS3 ))/3600, 1);
            $poidsMerc = $hourdiffMercMat + $hourdiffMercAprem +  $hourdiffMercSoir;
            $FM4 = $request->input('FM4');
            $DM4 = $request->input('DM4');
            $FA4 = $request->input('FA4');
            $DA4 = $request->input('DA4');
            $FS4 = $request->input('FS4');
            $DS4 = $request->input('DS4');
            $hourdiffJeudiMat = round((strtotime($FM4) - strtotime($DM4 ))/3600, 1);
            $hourdiffJeudiAprem = round((strtotime($FA4) - strtotime($DA4 ))/3600, 1);
            $hourdiffJeudiSoir = round((strtotime($FS4) - strtotime($DS4 ))/3600, 1);
            $poidsJeudi = $hourdiffJeudiMat + $hourdiffJeudiAprem +  $hourdiffJeudiSoir;
            $FM5 = $request->input('FM5');
            $DM5 = $request->input('DM5');
            $FA5 = $request->input('FA5');
            $DA5 = $request->input('DA5');
            $FS5 = $request->input('FS5');
            $DS5 = $request->input('DS5');
            $hourdiffVenMat = round((strtotime($FM5) - strtotime($DM5 ))/3600, 1);
            $hourdiffVenAprem = round((strtotime($FA5) - strtotime($DA5 ))/3600, 1);
            $hourdiffVenSoir = round((strtotime($FS5) - strtotime($DS5 ))/3600, 1);
            $poidsVen = $hourdiffVenMat + $hourdiffVenAprem +  $hourdiffVenSoir;
            $FM6 = $request->input('FM6');
            $DM6 = $request->input('DM6');
            $FA6 = $request->input('FA6');
            $DA6 = $request->input('DA6');
            $FS6 = $request->input('FS6');
            $DS6 = $request->input('DS6');
            $hourdiffSamMat = round((strtotime($FM6) - strtotime($DM6 ))/3600, 1);
            $hourdiffSamAprem = round((strtotime($FA6) - strtotime($DA6 ))/3600, 1);
            $hourdiffSamSoir = round((strtotime($FS6) - strtotime($DS6 ))/3600, 1);
            $poidsSam = $hourdiffSamMat + $hourdiffSamAprem +  $hourdiffSamSoir;
            $FM7 = $request->input('FM7');
            $DM7 = $request->input('DM7');
            $FA7 = $request->input('FA7');
            $DA7 = $request->input('DA7');
            $FS7 = $request->input('FS7');
            $DS7 = $request->input('DS7');
            $hourdiffDimMat = round((strtotime($FM7) - strtotime($DM7 ))/3600, 1);
            $hourdiffDimAprem = round((strtotime($FA7) - strtotime($DA7 ))/3600, 1);
            $hourdiffDimSoir = round((strtotime($FS7) - strtotime($DS7 ))/3600, 1);
            $poidsDim = $hourdiffDimMat + $hourdiffDimAprem +  $hourdiffDimSoir;
            $fiches=DB::select('select * from fichehors where idUser=?',[$identifiant]);
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Lun')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Lun%"',
                    [$poidsLundi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Mar')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Mar%"',
                    [$poidsMardi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Mer')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Mer%"',
                    [$poidsMerc,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Jeu')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Jeu%"',
                    [$poidsJeudi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Ven')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Ven%"',
                    [$poidsVen,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Sam')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Sam%"',
                    [$poidsSam,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Dim')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Dim%"',
                    [$poidsDim,$identifiant]);
                }
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
        
    }
