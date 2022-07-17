<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\duree;
use Illuminate\Support\Facades\DB;
class dureeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(!Gate::any(['access-admin', 'access-direction'])){
            abort('403');
            }
        $duree = duree::all();

        return view('ADMIN/duree',[
            'duree' =>$duree,
        ]);
    }

    public function show($id) {
        $duree = DB::select('select * from durees where id = ?',[$id]);
        return view('ADMIN/duree_update',['duree'=>$duree]);
        }

    public function edit(Request $request,$id) {
        $pause = $request->input('pause');
        /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
        /*DB::table('student')->update($data);*/
        /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
        DB::update('update durees set pause = ? where id = ?',[$pause,$id]);
        return redirect('/dureePause');
        }

}
