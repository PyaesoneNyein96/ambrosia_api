<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // SIGN IN -=============================================

    public function login(Request $req)
    {
        $user = User::where('email',$req->email)->first();



        if($user){
            if(Hash::check($req->password, $user->password)){
                $token = $this->TokenGenerator($user);
                User::where('email', $req->email)->update(['userToken' => $token]);
                return response()->json([
                    'userInfo' => $user,
                    'userToken' =>$token,
                    'auth' => true
                ], 200);
            }else{
                // password wrong
                return response()->json([
                    'userInfo' => null,
                    'auth' =>false,
                    'message' => 'Your Password is wrong!!'
                ], 401);
            }


        }else{
            // user doesn't exist
            return response()->json([
                  'userInfo' => null,
                  'auth' => false,
                  'message' => "Your email wasn't register yet !!"
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

    public function passwordUpdate(Request $request){

        $this->Password_Validation($request);

        $db_pass = User::find($request->user_id)->password;

        if($db_pass){

            if(Hash::check($request->oldPassword , $db_pass )){
                User::where('id', $request->user_id)->update(['password'=> Hash::make($request->newPassword) ]);
                return 200;
            }else{
                //  old pass not match
            return 401;
            }

        }else{
            return 403;
        }




    }



    // =======================================
    // Private Functions
    // =======================================


    // Data COllect xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    private function RegCollectData($req){
        return [
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password),
            'userToken'=> null
        ];
    }

    // TOKEN GENERATOR XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    private function TokenGenerator($req){
        return $token = $req->createToken(time())->plainTextToken;
    }

    // Validation XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX


    private function Password_Validation($request){

        Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword',
            'user_id' => 'required'
        ], [
            'oldPassword.required' => 'Current password is required',
            'oldPassword.oldPassword' => 'Your old password is invalid !!!',

            'newPassword.required' => 'Your new password is required',
            'newPassword.confirmPassword' => 'New password and confirm password must be same',

        ]

        )->validate();
    }


}
