<?php

namespace App\Http\Controllers;

use App\Models\depassement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class depHorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user=Auth::user();
        $session_str = $user->service;
        $employes = DB::table('employes')->select()->where('service', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $emplo = DB::select('SELECT identifiant,CONCAT(nom, " ", prenom) AS fullname FROM employes where service LIKE ?',[$session_str]);
        return view('ADMIN/depassementHor',[
            'employes' =>$employes,'emplo'=>$emplo
        ]);
    }

    public function store(){
        if(!Gate::allows('access-admin')){
            abort('403');
            }

        $dep = new depassement();

        $dep->identifiant = request('nom');
        $dep->nombreH = request('heures');
        $dep->motif = request('motif');
        $mois=request('mois');
        $year=request('year');
        $dep->semaine=request('semaine');
        $idF=  $year." - ".$mois;
        $dep->idFiche = $idF;
        $dep->save();

        return redirect()->back()->with('status', 'L\'autorisation a été bien ajoutée');
    }
}
