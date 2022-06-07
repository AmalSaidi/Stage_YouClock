<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DemandeCongeAdmin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employes = DB::select('select * from employes where id = ?', [1]);
        $EmpSer = DB::select('select * FROM employes where intitule="compta" or intitule="Paie"');
        $getDemande = DB::select('select * FROM demandeconge WHERE EXISTS 
                                ( select id FROM employes WHERE nom = demandeur)');
        $conge =  DB::table('demandeconge')->get();
        $date = date('F Y');//Current Month Year
        $row_count=0;
        $col_count=0;
        $currDate = date('Y-m').'-01';
        $month = date('n');
        $year = date('Y');
        $m= date("t");
        function dateDiffInDays($date1, $date2) 
        {
            // Calculating the difference in timestamps
            $diff = strtotime($date2) - strtotime($date1);
        
            // 1 day = 24 hours
            // 24 * 60 * 60 = 86400 seconds
            return abs(round($diff / 86400));
        }

        switch ($month) {
            case 1:
                $month="Janvier";
                break;
            case 2:
                $month="Février";
                break;
            case 3:
                $month="Mars";
                break;
            case 4:
                $month="Avril";
                break;
            case 5:
                $month="Mai";
                break;
            case 6:
                $month="Juin";
                break;
            case 7:
                $month="Juillet";
                break;
            case 8:
                $month="Août";
                break;
            case 9:
                $month="Septembre";
                break;
            case 10:
                $month="Octobre";
                break;
            case 11:
                $month="Novembre";
                break;
            case 12:
                $month="Décembre";
                break;
        }
        return view('Admin.demandeConge',[
            'employes' =>$employes,
            'date'=>$date,
            'row_count'=>$row_count,
            'col_count'=>$col_count,
            'conge' => $conge,
            'month'=>$month,
            'year'=>$year,
            'EmpSer'=>$EmpSer,
            'm'=>$m,
            'getDemande'=>$getDemande,
        ]);
    }

    public function store(){
        DB::table('demandeconge')->insert([
            'type' => request('type'),
            'dateDebut' => request('start'),
            'dateFin' => request('fin'),
            'dateRetour' => request('retour')
        ]);

        return redirect()->back();

    }
    
    public function verifyDate(){
        $dateD = DB::select('select * from demandeconge');

        return view('USER.demandeConge',[
            'dateD' =>$dateD, 
        ]);

    }
    public function show($id) {
        $demande = DB::select('select * from demandeconge where id = ?',[$id]);
        $EmpSer = DB::select('select * FROM employes where intitule="compta" or intitule="Paie"');
        return view('Admin.CongeEdit',['demande'=>$demande,'EmpSer'=>$EmpSer,]);
        }

    public function confirm($id) {
        /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
        /*DB::table('student')->update($data);*/
        /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
        DB::update('update demandeconge set statut="Valide" where id = ?',[$id]);
        return redirect('mesConges');
        }
    public function refuse($id) {
            /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
            /*DB::table('student')->update($data);*/
            /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
            DB::update('update demandeconge set statut="Refuse" where id = ?',[$id]);
            return redirect('mesConges');
            }

    
}
