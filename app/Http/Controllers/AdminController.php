<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\wallet;
use App\matchs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users(Request $request){
        $users= User::where("is_admin","!=",1)->latest()->get();
        $users->map(function($data){
            $credit  = wallet::where("user_id",$data->id)->where('status',0)->sum('amount');
            $debit = wallet::where("user_id",$data->id)->where('status',1)->sum('amount');
            $balance = $credit-$debit;
            $data->balance = $balance;
            return $data;
        });

        return view("admin.users",compact('users'));
    }
    public function walletSend($id){
        return view('admin.walletSend',compact('id'));
    }
    public function walletStore(Request $request,$id){
        $wallet = new wallet();
        $wallet->user_id = $id;
        $wallet->amount = $request->amount;
        $wallet->save();
        return redirect()->back()->with("success","Amount Send Successfully");
    }

    public function login(){
        if(Auth::check() && Auth::user()->is_admin == 1 ){
          return redirect()->route('admin.home');
        }
        else{
            return view("admin.login");
        }
  }

    public function matches(){
        $matchs = matchs::orderBy("id","desc")->get();
        return view("admin.matchs",compact('matchs'));
    }


    public function addUser(){
        return view('admin.addUser');
    }

    public function storeUser(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.users')->with("success","User Added Successfully!");
    }
}
