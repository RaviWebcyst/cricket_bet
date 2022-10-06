<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\rate;
use App\wallet;
use App\team;
use App\virtual_wallet;
use App\matchs;
use App\session;
use App\session_virtualWallet;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTManager as JWT;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RateController extends Controller
{

    public function index(Request $request){
        
        if($request->value!="" && $request->calrate !="" && $request->rate != ""){
            if($request->value == 1){
                // $team_a = ($request->calrate/($request->rate*10)) * $request->calrate;
                $res = (($request->rate*10)/1000) * $request->calrate;
            }
            if($request->value == 3){
                // $team_a = (($request->rate *10)/$request->calrate)*($request->rate * 10);
                $res = $request->calrate/(1000/($request->rate * 10));
            }
            if($request->value == 2){
                $res = (($request->rate*10)/1000) * $request->calrate;
            }
            if($request->value == 4){
                $res = $request->calrate/(1000/($request->rate * 10));
            }
            return response()->json($res);
        }
        $wallet_credit_a = virtual_wallet::where("team",1)->where("status",0)->sum("amount");
        $wallet_debit_a = virtual_wallet::where("team",1)->where("status",1)->sum("amount");
        $wallet_balance_a = $wallet_credit_a - $wallet_debit_a;

        $wallet_credit_b = virtual_wallet::where("team",2)->where("status",0)->sum("amount");
        $wallet_debit_b = virtual_wallet::where("team",2)->where("status",1)->sum("amount");

        $wallet_balance_b = $wallet_credit_b - $wallet_debit_b;


        $rate = rate::latest()->first();
        $team_a = team::where("name","Team A")->first();
        $team_b = team::where("name","Team B")->first();

        $credit = wallet::where('status',0)->where('user_id',1)->sum("amount");
        $debit = wallet::where('status',1)->where('user_id',1)->sum("amount");
        $balance = $credit-$debit;
        return view("rating",compact('rate','balance','team_a','team_b','wallet_credit_a','wallet_debit_a','wallet_credit_b','wallet_debit_b','wallet_balance_b','wallet_balance_a'));
    }

    public function game(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        
        $rate = rate::latest()->first();
        $team_a = team::where("name","Team A")->where("match_id",$request->match_id)->first();
        $team_b = team::where("name","Team B")->where("match_id",$request->match_id)->first();


            $wallet_credit_a =0;
            $wallet_debit_a = 0;
            $wallet_credit_b =0;
            $wallet_debit_b = 0;

        if(!empty($team_a)){
            $wallet_credit_a = virtual_wallet::where("team",$team_a->id)->where("user_id",$user->id)->where("status",0)->sum("amount");
            $wallet_debit_a = virtual_wallet::where("team",$team_a->id)->where("user_id",$user->id)->where("status",1)->sum("amount");
        }
        $wallet_balance_a = $wallet_credit_a - $wallet_debit_a;
        if(!empty($team_a)){
            $wallet_credit_b = virtual_wallet::where("team",$team_b->id)->where("user_id",$user->id)->where("status",0)->sum("amount");
            $wallet_debit_b =virtual_wallet::where("team",$team_b->id)->where("user_id",$user->id)->where("status",1)->sum("amount");
        }
        $wallet_balance_b = $wallet_credit_b - $wallet_debit_b;


      
        $credit = wallet::where('status',0)->where("user_id",$user->id)->sum("amount");
        $debit = wallet::where('status',1)->where("user_id",$user->id)->sum("amount");
        $balance = $credit-$debit;

        $url = "https://mern-stack.live/vue/api/marketData?id=".$request->match_id;

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $result = json_decode($result);
        $result = (array)$result;

        return response()->json(compact('rate','balance','team_a','team_b','wallet_credit_a','wallet_debit_a','wallet_credit_b','wallet_debit_b','wallet_balance_b','wallet_balance_a','result'));


    }

    public function store(Request $request){
        rate::create([
            "rate1"=>$request->rate1,
            "rate2"=>$request->rate2,
            "rate3"=>$request->rate3,
            "rate4"=>$request->rate4
        ]);

        return redirect()->back();
    }

    public function betStore(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        // return response()->json($request->id);

        $credit1  = wallet::where("user_id",$user->id)->where('status',0)->sum('amount');
        $debit1  = wallet::where("user_id",$user->id)->where('status',1)->sum('amount');
        $amount1 = $credit1-$debit1;

        // $credit2  = wallet::where("user_id",2)->where('status',0)->sum('amount');
        // $debit2  = wallet::where("user_id",2)->where('status',1)->sum('amount');
        // $amount2 = $credit2-$debit2;

            if( $request->amount > $amount1){
                return response()->json(["error"=>"not enough amount in wallet"],500);
                exit;
            }

            $value = $request->value;
            $amount = number_format((float)$request->tAmnt, 2, '.', '');
            $bet_amount = $request->betAmnt;

            if($value == 3 || $value == 1){
               
                
                if($value == 3){
                virtual_wallet::create([
                        "user_id"=>$user->id,
                        "amount"=>$amount,
                        "team"=>$request->team_a,
                        "status"=>1,
                        "match_id"=>$request->id

                ]);
                virtual_wallet::create([
                    "user_id"=>$user->id,
                    "amount"=>$bet_amount,
                    "team"=>$request->team_b,
                    "match_id"=>$request->id
                ]);
                wallet::create([
                    "status"=>1,
                    "user_id"=>$user->id,
                    "amount"=>$amount,
                    "match_id"=>$request->id
                ]);


                }
                else{
                    virtual_wallet::create([
                        "user_id"=>$user->id,
                        "amount"=>$bet_amount,
                        "team"=>$request->team_b,
                        "status"=>1,
                        "match_id"=>$request->id
                    ]);
                    virtual_wallet::create([
                        "user_id"=>$user->id,
                        "amount"=>$amount,
                        "team"=>$request->team_a,
                        "match_id"=>$request->id
                        
                    ]);
                    wallet::create([
                        "status"=>1,
                        "user_id"=>$user->id,
                        "amount"=>$bet_amount,
                        "match_id"=>$request->id
                    ]);
                    
                }
                $wallet_credit_a = virtual_wallet::where("team",$request->team_a)->where("user_id",$user->id)->where("status",0)->sum("amount");
                $wallet_debit_a = virtual_wallet::where("team",$request->team_a)->where("user_id",$user->id)->where("status",1)->sum("amount");
                $wallet_balance_a = $wallet_credit_a - $wallet_debit_a;
        
                $wallet_credit_b = virtual_wallet::where("team",$request->team_b)->where("user_id",$user->id)->where("status",0)->sum("amount");
                $wallet_debit_b = virtual_wallet::where("team",$request->team_b)->where("user_id",$user->id)->where("status",1)->sum("amount");
        
                $wallet_balance_b = $wallet_credit_b - $wallet_debit_b;

                $value = min($wallet_balance_a,$wallet_balance_b);
                if($value < 0){
                    wallet::where("user_id",$user->id)->where("match_id",$request->id)->where("status",1)->where("description",null)->delete();
                    $wallet = new wallet();
                    $wallet->user_id = $user->id;
                    $wallet->match_id = $request->id;
                    $wallet->status = 1;
                    $wallet->amount = -$value;
                    $wallet->save();
                }

                $credit1  = wallet::where("user_id",$user->id)->where('status',0)->sum('amount');
                $debit1  = wallet::where("user_id",$user->id)->where('status',1)->sum('amount');
                $amount1 = $credit1-$debit1;

                return response()->json(["status"=>"bet successfully placed!","balance"=>$amount1,"wallet_credit_a"=>$wallet_credit_a,"wallet_debit_a"=>$wallet_debit_a,"wallet_balance_a"=>$wallet_balance_a,"wallet_credit_b"=>$wallet_credit_b,"wallet_debit_b"=>$wallet_debit_b,"wallet_balance_b"=>$wallet_balance_b]);

            }

            if($value == 2 || $value == 4){
                
                if($value == 4){
                virtual_wallet::create([
                    "user_id"=>$user->id,
                    "amount"=>$bet_amount,
                    "team"=>$request->team_a,
                    "match_id"=>$request->id
                ]);


                virtual_wallet::create([
                    "user_id"=>$user->id,
                    "amount"=>$amount,
                    "team"=>$request->team_b,
                    "status"=>1,
                    "match_id"=>$request->id
                ]);

                wallet::create([
                    "status"=>1,
                    "user_id"=>$user->id,
                    "amount"=>$amount,
                    "match_id"=>$request->id
                ]);

                }
                else{
                    virtual_wallet::create([
                        "user_id"=>$user->id,
                        "amount"=>$amount,
                        "team"=>$request->team_b,
                        "match_id"=>$request->id
                    ]);
                    virtual_wallet::create([
                        "user_id"=>$user->id,
                        "amount"=>$bet_amount,
                        "team"=>$request->team_a,
                        "status"=>1,
                        "match_id"=>$request->id
                        
                    ]);

                    wallet::create([
                        "status"=>1,
                        "user_id"=>$user->id,
                        "amount"=>$bet_amount,
                        "match_id"=>$request->id
                    ]);
    
                }

                
                
                $wallet_credit_a = virtual_wallet::where("team",$request->team_a)->where("user_id",$user->id)->where("status",0)->sum("amount");
                $wallet_debit_a = virtual_wallet::where("team",$request->team_a)->where("user_id",$user->id)->where("status",1)->sum("amount");
                $wallet_balance_a = $wallet_credit_a - $wallet_debit_a;
        
                $wallet_credit_b = virtual_wallet::where("team",$request->team_b)->where("user_id",$user->id)->where("status",0)->sum("amount");
                $wallet_debit_b = virtual_wallet::where("team",$request->team_b)->where("user_id",$user->id)->where("status",1)->sum("amount");
        
                $wallet_balance_b = $wallet_credit_b - $wallet_debit_b;

                $value = min($wallet_balance_a,$wallet_balance_b);
                if($value < 0){
                    wallet::where("user_id",$user->id)->where("match_id",$request->id)->where("status",1)->where("description",null)->delete();
                    $wallet = new wallet();
                    $wallet->user_id = $user->id;
                    $wallet->match_id = $request->id;
                    $wallet->status = 1;
                    $wallet->amount = -$value;
                    $wallet->save();
                }
                $credit1  = wallet::where("user_id",$user->id)->where('status',0)->sum('amount');
                $debit1  = wallet::where("user_id",$user->id)->where('status',1)->sum('amount');
                $amount1 = $credit1-$debit1;

                return response()->json(["status"=>"bet successfully placed!","balance"=>$amount1,"wallet_credit_a"=>$wallet_credit_a,"wallet_debit_a"=>$wallet_debit_a,"wallet_balance_a"=>$wallet_balance_a,"wallet_credit_b"=>$wallet_credit_b,"wallet_debit_b"=>$wallet_debit_b,"wallet_balance_b"=>$wallet_balance_b]);


            }
            // $ba = $request->betAmnt;

            // if($value == 1 || $value == 3){
            //     virtual_wallet::create([
            //         "user_id"=>1,
            //         "team"=>"A",
            //         "amount"=>$ta,
            //     ]);
            //     virtual_wallet::create([
            //         "user_id"=>1,
            //         "team"=>"B",
            //         "amount"=>$ba,
            //         "status"=>1
            //     ]);
            // }
            // if($value == 2){
            //     virtual_wallet::create([
            //         "user_id"=>1,
            //         "team"=>"B",
            //         "amount"=>$ta,
            //     ]);
            //     virtual_wallet::create([
            //         "user_id"=>1,
            //         "team"=>"A",
            //         "amount"=>$ba,
            //         "status"=>1
            //     ]);
            // }
            // if($value == 4){
            //     virtual_wallet::create([
            //         "user_id"=>1,
            //         "team"=>"B",
            //         "amount"=>$ba,
            //     ]);
            //     virtual_wallet::create([
            //         "user_id"=>1,
            //         "team"=>"A",
            //         "amount"=>$ta,
            //         "status"=>1
            //     ]);
            // }

            // wallet::create([
            //     "amount"=>$request->amount,
            //     "status"=>1,
            //     "user_id"=>1
            // ]);
        
        // return redirect()->back()->with("success","bet successfully placed!");
    }

    public function match(){
        $matchs = matchs::orderBy("id","desc")->get();
        $url = "http://mern-stack.live/vue/test";

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $result = json_decode($result);
        $result = (array)$result;
        return response()->json(compact('matchs','result'));
    }

    public function session(Request $request){
        $session = session::where("match_id",$request->match_id)->get();
        $session->map(function($data){
            $data->team = team::where("id",$data->team_id)->first();
            return $data;
        });
        return response()->json($session);
    }

    public function storeSession(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        $session = new session_virtualWallet();
        $session->team_id = $request->team_id;
        $session->user_id = $user->id;
        $session->match_id = $request->match_id;
        $session->side = $request->side;
        $session->amount = $request->amount;
        $session->status = 1;
        $session->save();

        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->amount = $request->amount;
        $wallet->status = 1;
        $wallet->match_id = $request->match_id;
        $wallet->description = "session";
        $wallet->save();

        $credit1  = wallet::where("user_id",$user->id)->where('status',0)->sum('amount');
        $debit1  = wallet::where("user_id",$user->id)->where('status',1)->sum('amount');
        $amount1 = $credit1-$debit1;

        return response()->json(["balance"=>$amount1]);

    }
}
