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
        return view('welcome');
    }

    public function boo(){
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        return view('ADMIN.activites');
    }
}
