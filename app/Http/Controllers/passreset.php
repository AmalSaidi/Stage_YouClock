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
