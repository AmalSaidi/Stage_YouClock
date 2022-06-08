<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class depHorController extends Controller
{
    public function index(){
        if(!Gate::allows('access-admin')){
            abort('403');
            }
            $EmpSer = DB::select('select * FROM employes where intitule="compta" or intitule="Paie"');

        return view('ADMIN.depassementHor',[
            'EmpSer' =>$EmpSer,
        ]);
    }
}
