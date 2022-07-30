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
