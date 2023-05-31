<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // SIGN IN -=============================================

    public function login(Request $req)
    {
        $user = User::where('email',$req->email)->first();

        $token = $this->TokenGenerator($user);
        User::where('email', $req->email)->update(['userToken' => $token]);

        if($user){
            if(Hash::check($req->password, $user->password)){
                return response()->json([
                    'userInfo' => $user,
                    'userToken' =>$token,
                    'auth' => true
                ], 200);
            }else{
                // password wrong
                return response()->json([
                    'userInfo' => null,
                    'auth' =>false
                ], 401);
            }


        }else{
            // user doesn't exist
            return response()->json([
                  'userInfo' => null,
                  'auth' => false
            ], 404);
        }

    }

    //Register -=============================================

    public function register(Request $req)
    {
        $data = $this->RegCollectData($req);
        User::create($data);

        $user = User::where('email', $req->email)->first();

        $token = $this->TokenGenerator($user);
        User::where('email', $user->email)->update(['userToken' => $token]);

        return response()->json([
            'userInfo' => $user,
            'userToken' => $token,
            'auth' => true
        ], 200);
    }



    // AUTO_LOGIN -=============================================
    public function autoLogin(Request $req){

    $user = User::where('userToken', $req->token)->first();

    $token = $this->TokenGenerator($user);
    User::where('email', $req->email)->update(['userToken' => $token]);


    return response()->json([
        'userInfo' => $user,
        'userToken' => $token,
        'auth' => true
    ], 200);

    }




    // Data COllect xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    private function RegCollectData($req){
        return [
            'name'=>null,
            'email'=>$req->email,
            'password'=>Hash::make($req->password),
            'userToken'=> null
        ];
    }

    // TOKEN GENERATOR XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    private function TokenGenerator($req){
        return $token = $req->createToken(time())->plainTextToken;
    }


}