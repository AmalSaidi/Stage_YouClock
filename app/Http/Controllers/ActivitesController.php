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
        if(!Gate::allows('access-admin')){
            abort('403');
            }
        $activites = activites::all();

        return view('ADMIN.activites',[
            'activites' =>$activites,
        ]);
    }

    public function store(){
        if(!Gate::allows('access-admin')){
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
        if(!Gate::allows('access-admin')){
            abort('403');
            }
        $activites = DB::select('select * from activites where id = ?',[$id]);
        return view('ADMIN/activite_update',['activites'=>$activites]);
        }

    public function edit(Request $request,$id) {
        if(!Gate::allows('access-admin')){
            abort('403');
            }
        $code = $request->input('code');
        $libellé = $request->input('libelle');
        $Poids = $request->input('poids');
        /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
        /*DB::table('student')->update($data);*/
        /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
        DB::update('update activites set code = ?,libellé = ?,Poids=? where id = ?',[$code,$libellé,$Poids,$id]);
        return redirect('/activites');
        }

        public function export() 
        {
            return Excel::download(new ActivitesExport, 'activites.xlsx');
        }
}
