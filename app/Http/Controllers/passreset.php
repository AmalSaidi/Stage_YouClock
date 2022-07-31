<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Sentinel;
use Mail;
use Reminder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;







class passreset extends Controller
{
    public function index(){
        if(Gate::any(['access-admin', 'access-direction'])){
            return view('ADMIN.passReset');
            }
            else{
        return view('USER.passReset');
            }
    }
    public function showforgot(){
        return view('auth/forgotpass');
    }

    public function changepass(Request $request){
        if(User::where('email', $request->email)->count() > 0){
            DB::update('update users set password=? where email=?',
            [Hash::make('12345678'),$request->email]);
            return back()->with("status", "Le mot de passe a été réinitialisé");
        }
        else{
            return back()->with("error", "aucun utilisateur avec l'adresse mail saisie");
        }
    }

    public function changeinfo(Request $request){
        $user=Auth::user();
        $session_id = $user->identifiant;
        $employes = DB::select('select * from employes where identifiant=?',[$session_id]);
        $services = DB::select('select * from services');
        $structures = DB::select('select * from structures');
        if(Gate::any(['access-admin', 'access-direction'])){
            return view('ADMIN.changerInfo',[
                'employes' =>$employes,'services' =>$services,'structures' =>$structures,
            ]);
        }
        else{
            return view('USER.changerInfo',[
                'employes' =>$employes,'services' =>$services,'structures' =>$structures  ]);
        }
        
    }

    public function updateinfo(Request $request){
        $user=Auth::user();
        $session_id = $user->identifiant;
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $mail = $request->input('mail');
        $tel = $request->input('tel');
        $TypeContrat = $request->input('TypeContrat');
        $structure = $request->input('structure');
        $service = $request->input('service');
        $dateEmbauche = $request->input('dateEmbauche');
        $Datefin = $request->input('Datefin');
        DB::update('update employes set nom = ?,prenom = ?,mail=?,tel=?,TypeContrat=?,structure=?,service=?,dateEmbauche=?,Datefin=?
         where identifiant = ?',[$nom,$prenom,$mail,$tel,$TypeContrat,$structure,$service,$dateEmbauche,$Datefin,$session_id]);
         DB::update('update users set name = ?,email=?,structure=?,service=? where identifiant = ?',
         [$nom,$mail,$structure,$service,$session_id]);
        return back()->with("status", "Les changements ont été bien mises à jour");
    }


    
    public function updatePassword(Request $request)
{
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "L'ancien mot de passe est incorrect");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "le nouveau mot de passe a été bien enregistré!");
}


}
