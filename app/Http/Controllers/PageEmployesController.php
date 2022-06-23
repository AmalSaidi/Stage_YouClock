<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\employes;
use App\Models\fichehor;
use App\Models\horairesemaine;
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
        return view('ADMIN/RH',['employes'=>$employes,'employees'=>$employees]);
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

    }
