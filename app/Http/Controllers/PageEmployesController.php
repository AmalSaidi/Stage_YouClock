<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\employes;
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
        return view('ADMIN/PageEmployes',[
            'employes' =>$employes,
        ]);
    }


    public function store(){

        $employes = new employes();

        $employes->nom = request('nom');
        $employes->prenom = request('prenom');
        $employes->structure = request('structure');
        $employes->intitule = request('intitule');
        $employes->dateEmbauche = request('dateEmbauche');
        $employes->Datefin = request('Datefin');
        $employes->TypeContrat = request('TypeContrat');
        $employes->mail = request('mail');

        $employes->save();

        return redirect('/services');
    }

    public function show($id) {
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        return view('ADMIN/infoperso',['employes'=>$employes,'employees'=>$employees]);
        }

    public function showRH($id) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $Lun= DB::select('select * from semainetypes where jour="Lundi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mar= DB::select('select * from semainetypes where jour="Mardi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mer= DB::select('select * from semainetypes where jour="Mercredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Jeu= DB::select('select * from semainetypes where jour="Jeudi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Ven= DB::select('select * from semainetypes where jour="Vendredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Sam= DB::select('select * from semainetypes where jour="Samedi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Dim= DB::select('select * from semainetypes where jour="Dimanche" and idUser=(select identifiant from employes where id=?)',[$id]);
        return view('ADMIN/RH',['employes'=>$employes,'employees'=>$employees,'Lun'=>$Lun,'Mar'=>$Mar,'Mer'=>$Mer
        ,'Jeu'=>$Jeu,'Ven'=>$Ven,'Sam'=>$Sam,'Dim'=>$Dim]);
        }

    public function showFiche($id) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
        return view('ADMIN/ficheHoraire',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees]);
        }

    public function showFicheComplete($id,$idfiche) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $depassement = DB::select('select * from depassements where idfiche =? AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $fiche = DB::select('select * from fichehors where idfiche =? AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem1 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 1" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem2 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 2" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem3 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 3" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem4 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 4" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem5 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 5" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NR = DB::select('select * from fichehors where idfiche =? AND state="NR" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        return view('ADMIN/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
        ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR]);
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

         public function ajouterST(){
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

            return redirect()->back()->with('status', 'Les modifications ont été bien enregistrés');
            }
        
    }
