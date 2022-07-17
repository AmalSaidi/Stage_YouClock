<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class FicheHoraireAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        $employes = DB::select('select * from employes');

        return view('ADMIN.FicheHoraire',[
            'employes' =>$employes,
        ]);
    }
}
