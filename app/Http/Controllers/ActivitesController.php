<?php

namespace App\Http\Controllers;

use App\Exports\ActivitesExport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\activites;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\ExcelMatch;

class ActivitesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        $activites = activites::all();

        return view('ADMIN.activites',[
            'activites' =>$activites,
        ]);
    }

    public function store(){
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }

        $activite = new activites();

        $activite->code = request('code');
        $activite->libellé = request('libelle');
        $activite->Poids = request('poids');

        $activite->save();

        return redirect('/activites');
    }

    public function show($id) {
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        $activites = DB::select('select * from activites where id = ?',[$id]);
        return view('ADMIN/activite_update',['activites'=>$activites]);
        }

    public function edit(Request $request) {
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        $semaine = $request->input('semaine');
        $nombreH = $request->input('nombreH');
        $motif = $request->input('motif');
        $id = $request->input('id');
        DB::update('update depassements set semaine = ?,nombreH = ?, motif=? where id = ?',[$semaine,$nombreH,$motif,$id]);
        return redirect('/activites');
        }

        public function export() 
        {
            return (new ActivitesExport)->download('activites.xlsx');
        }
}
