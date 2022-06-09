<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class FicheHoraireUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employes = DB::select('select * from employes');
        $date = date('Y-m-01', strtotime("first day of this month"));
        $date2 = date('l', strtotime($date));
        if($date2=="Wednesday")
        {
            $date2=="Mercredi";
        }
        return view('USER.ficheHoraire',[ 'employes' =>$employes,'date' =>$date,'date2' =>$date2,
        ]);
    }
}
