<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\employes;
use App\Models\horairesemaine;
use Illuminate\Support\Facades\DB;

class PageEmployesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employes = employes::all();
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
        return view('ADMIN/infoperso',['employes'=>$employes]);
        }

    public function showRH($id) {
        $employes = DB::select('select * from employes where id = ?',[$id]);
        return view('ADMIN/RH',['employes'=>$employes]);
        }

    public function showFiche($id) {
        $employes = DB::select('select * from employes where id = ?',[$id]);
        return view('ADMIN/ficheHoraire',['employes'=>$employes]);
        }

}
