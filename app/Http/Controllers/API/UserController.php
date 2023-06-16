<?php

namespace App\Http\Controllers\API;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function updateProfile(Request $request){

        logger($request);
        $this->validation($request);

        $user = User::with('tag')->where('id', $request->id)->first();
        // $token = $user->createToken(time())->plainTextToken;

        $data = $this->setData($request);

        $user = User::find($request->id);

        if($request->hasFile('image')){

            if($user->image != null){
                Storage::delete('public/profile/'.$user->image);
            }
            $uniqueName = uniqid().'_profile_'.$request->image->getClientOriginalName();
            $request->file('image')->storeAs('public/profile',$uniqueName);
            $data['image'] = $uniqueName;
        }



        $user->update($data);
        $userUpdated = User::find($request->id);

        return response()->json([
            'userInfo' => $userUpdated,
            'auth' => true,
            'userToken' => $userUpdated->userToken
        ], 200);

    }


    // ------------------- ADMIN side  User List

    public function list(Request $request) {

         return $userList = User::with('tag')->get();


        //  return return response()->json([
        //     'userInfo' => $user
        //  ], 200, $headers);


    }


    public function delete($id){
        logger($id);
        $user = User::find($id);
        $user->delete();

        return $user;
    }

    public function update(Request $request){


        if(isset($request->role)){
            $user = User::find($request->id)->update(['role'=> $request->role]);
        }else{
            $user = User::find($request->id)->update(['membership'=> $request->membership]);
        }

        return $userUpdate = User::find($request->id);

    }


    public function getUserByRole($role){
        if($role == 0){
            return User::with('tag')->where('role',0)->get();
        }else if($role ==1){
            return User::with('tag')->where('role',1)->get();
        }else{
            return User::with('tag')->get();

        }


    }

    // ------------------- End ADMIN side  User List








    private function validation ($request) {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
        ])->validate();
    }

    private function setData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender == 'null' ? Null: $request->gender,
            'birthday' => $request->birthday == 'null' ? Null: $request->birthday,
            'role' => $request->role,
            'restrictions' => $request->restrictions == true? 1: 0 ,
            'allergies' => $request->allergies == true? 1: 0 ,
            'preferred_cuisine' => $request->preferred_cuisine == 'null' ? Null : $request->preferred_cuisine ,
            'membership' =>$request->membership,

            // 'address' => $request->address == 'null' ? Null: $request->address,
            // 'gender' => $request->gender == 'null' ? Null: $request->gender,
            // 'birthday' => $request->birthday == 'null' ? Null: $request->birthday,
            // 'role' => $request->role,
            // 'restrictions' => $request->restrictions == true? 1: 0 ,
            // 'allergies' => $request->allergies == true? 1: 0 ,
            // 'preferred_cuisine' => $request->preferred_cuisine == 'null' ? Null : $request->preferred_cuisine,
            // 'membership' =>$request->membership == 'null' ? Null : $request->membership,
            'updated_at' => Carbon::now(),
        ];
    }

}