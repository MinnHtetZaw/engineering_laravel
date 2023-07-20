<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    //
    protected function loginProcess(Request $request){

                $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required',
                ]);

                if ($validator->fails()) {

                    return response("Something Wrong! Validation Error.", 422);
                }

                $password = $request->password;


                $user = User::where('email',$request->email)->first();

                if (!isset($user)) {

                    return  response("Something Wrong! User Not Found.", 422);
                }
                elseif (!Hash::check($password, $user->password)) {

                    return  response("Password went wrong", 422);

                }

                else{

                   $tokenResult = Str::random(64);

                    return response()->json([
                        'message' => "Successful",
                        'status' => 200,
                        'access_token' => $tokenResult,
                        'employee' => Employee::where('user_id',$user->id)->with('user','role')->first()
                    ]);
                }
            }

            protected function logoutProcess(Request $request){

                $request->user()->token()->revoke();

                $message = "Successfully Logout!";

                return $this->sendSuccessResponse("logout-message", $message);
            }

            protected function updatePassword(Request $request){

                $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$@#%]).*$/',
                ]);

                if ($validator->fails()) {

                    return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
                }

                $user = User::find($request->user()->id);

                $current_pw = $request->current_password;

                if(!Hash::check($current_pw, $user->password)){

                    return $this->sendFailResponse("Something Wrong! Password doesn't match.", "400");
                }

                $has_new_pw = Hash::make($request->new_password);

                $user->password = $has_new_pw;

                $user->save();

                return $this->sendSuccessResponse("user", $user);
            }
}
