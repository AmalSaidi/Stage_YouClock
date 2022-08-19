<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class testController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('USER.ficheHoraire');
    }

    public function boo(){
        if(!Gate::allows('access-admin')){
            abort('403');
            }
        return view('ADMIN.activites');
    }
}
