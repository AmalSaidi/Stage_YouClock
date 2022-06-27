<?php

namespace App\Http\Controllers;

use App\Exports\StructuresExport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\structures;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class StructuresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(!Gate::allows('access-admin')){
            abort('403');
            }
        $structures = structures::all();

        return view('ADMIN/structures',[
            'structures' =>$structures,
        ]);
    }

    public function store(){

        $structure = new structures();

        $structure->libellé = request('libelle');
        $structure->code = request('code');
        $structure->congePaye = request('congePaye');

        $structure->save();

        return redirect('/structures');
    }

    public function show($id) {
        $structures = DB::select('select * from structures where id = ?',[$id]);
        return view('ADMIN/structure_update',['structures'=>$structures]);
        }

    public function edit(Request $request,$id) {
        $libellé = $request->input('libelle');
        $code = $request->input('code');
        $congePaye = $request->input('congePaye');
        /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
        /*DB::table('student')->update($data);*/
        /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
        DB::update('update structures set libellé = ?,code = ?,congePaye=? where id = ?',[$libellé,$code,$congePaye,$id]);
        return redirect('/structures');
        }

        public function export() 
        {
            return Excel::download(new StructuresExport, 'structures.xlsx');
        }

}
