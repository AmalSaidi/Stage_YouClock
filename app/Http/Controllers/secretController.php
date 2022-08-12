<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class secretController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    return view('DIRECTION.secretFile');}

    public function deleteFiches(){
        DB::table('fichehors')->delete();
/*DB::statement('ALTER TABLE fichehors
MODIFY COLUMN Poids float');
DB::statement('ALTER TABLE fichehors
MODIFY COLUMN Poids float');*/
        return redirect()->back();
    }
}
