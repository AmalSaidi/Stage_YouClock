<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\services;
use Illuminate\Support\Facades\DB;
class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        $services = services::all();

        return view('ADMIN/services',[
            'services' =>$services,
        ]);
    }

    public function store(){

        $service = new services();

        $service->libellé = request('libelle');
        $service->responsable = request('responsable');

        $service->save();

        return redirect('/services');
    }

    public function show($id) {
        $services = DB::select('select * from services where id = ?',[$id]);
        return view('ADMIN/service_update',['services'=>$services]);
        }

    public function edit(Request $request,$id) {
        $libelle = $request->input('libelle');
        $responsable = $request->input('responsable');
        /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
        /*DB::table('student')->update($data);*/
        /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
        DB::update('update services set libellé = ?,responsable=? where id = ?',[$libelle,$responsable,$id]);
        return redirect('/services');
        }
}
