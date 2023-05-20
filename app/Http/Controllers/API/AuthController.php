<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $req)
    {
        $user = User::where('email',$req->email)->first();

        if($user){

            if(Hash::check($req->password, $user->password)){
                return response()->json([
                    'userInfo' => $user,
                    'userToken' =>$user->createToken(time())->plainTextToken,
                    'auth' => true
                ], 200);
            }else{
                return response()->json([
                    'userInfo' => null,
                    'auth' =>false
                ], 401);
            }


        }else{
            return response()->json([
                  'userInfo' => null,
                  'auth' => false
            ], 404);
        }

    }

    //Register

    public function register(Request $req)
    {
        $data = $this->RegCollectData($req);
        User::create($data);

        $user = User::where('email', $req->email)->first();

        return response()->json([
            'user' => $user,
            'userToken' => $user->createToken(time())->plainTextToken
        ], 200);
    }



    // Data COllect
    private function RegCollectData($req){
        return [
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password),
        ];
    }


}
