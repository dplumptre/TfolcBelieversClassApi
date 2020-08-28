<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\Registration;
use App\Mail\ForgetPassword;




class ApiAuthController extends Controller
{

    /**
     * 
     * LOGIN WITH PHONE AND NUMBER
     *  */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try { 
            if (! $token = JWTAuth::attempt($credentials)) {

                // you need to loop api in for response to work
                return response()->json(['error' =>  ["error"=>["invalid_credentials"]]], 400);
            }

            $user=User::where('email',$request->email)->first();
            if($user->activation !== '1'){
             return response()->json(['error' => ["error"=>["Your account has not been activated. check your inbox/spam for activation link"]]],422);
            }


        } catch (JWTException $e) {
            return response()->json(['error' => ["error"=>['could_not_create_token']]], 500);
        }
        
        $user = JWTAuth::user();


        return response()->json([
            'token' => $token,
            'user' => [
                "userId" => $user->id,
                "firstname" => $user->fname,
                "access" => $user->access
            ],
            'type'=>'bearer',
            'expires'=> JWTAuth::factory()->getTTL()*60,
        ]);


    }



    public function testEmail(){

        Mail::to('dp@aol.com')->send(new Registration('dplumptre@yahoo.com'));
        return response()->json(['success'=>'worked!']);

    }


    public function register(Request $request)
    {
        
      //  return response()->json(['result'=>$role_user->id]);
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone'=> 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
        }

        //dd($request->all());
     
         $token = Str::random(80);
         $users = new User;
         $users->fname      = $request->firstname;
         $users->lname      = $request->lastname;
         $users->email      = $request->email;
         $users->password   = Hash::make($request->password);
         $users->phone      = $request->phone;
         $users->mstatus    = $request->gender;
         $users->country    = $request->country;
         $users->remember_token = Str::random(80);
         $users->activation = $token;
         $users->username = $request->firstname.$request->lastname;
         $users->dob        = "general date";
         $users->access     = '1';
         $users->save();


         Mail::to($request->email)->send(new Registration($token,$users->email));

         return response()->json([
            'result' => "IMPORTANT! Check your inbox, we have sent an activation link to your email. 
            If you dont see it after a few minutes check your spam and mark the email as 'not spam' 
            so subsequent emails will arrive in your inbox "
        ],200); 

    }



    // public function changePassword(Request $request,User $user)
    // {
    //     $user->password = Hash::make($request->password);
    //     $user->save();
    //     return response()->json(['success'=>'Password updated successfully'],201);
    // }



    

    public function activateAccount($token){

        //dd($token);

        $user=User::where('activation',$token)->first();
        if(!$user){
         return response()->json(['error' => 'no activation key'],422);
        }

        $user->update([
            'activation' => '1'          
        ]);
        return response()->json(['result'=>'successful'],201);
    }








    /***  forget password starts */

    public function forgetPassword(Request $request,User $user)
    {
        $input = $request->only('email');
        $rules=[
            'email'=>'required|email|exists:users'
        ];   
        $validator = Validator::make($input,$rules);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()],422);
        }
        $this->sendMail($request->email);
        return response()->json([
            'result' => "Check your inbox, we have sent a reset link to your email. 
            If you dont see it after a few minutes check your spam and mark the email as 'not spam' 
            so subsequent emails will arrive in your inbox "
        ],200); 
       //return 1;
    }



   public function resetToken(Request $request){
       $user=User::where('remember_token',$request->token)->first();
       if(!$user){
        return response()->json(['error' => ["error"=>['Token does not exist! contact admin']]],422);
       }
       $user->password = Hash::make($request->password);
       $user->save();
       return response()->json(['result'=>'You can now login with your new password!'],201);
   }




    public function generateToken($email){
        $isOtherToken = User::where('email', $email)->first();
  
        if($isOtherToken->remember_token !== "") {
         return $isOtherToken->remember_token;
        }
  
        $token = Str::random(80);
        $this->storeToken($token,$isOtherToken);
        return $token;
    }

    public function storeToken($token, $user){
        $user->update([
            'remember_token' => $token           
        ]);
    }

    public function sendMail($email){
        $token = $this->generateToken($email);
        Mail::to($email)->send(new ForgetPassword($token));
    }

    /***  forget password starts */



   public function getAuthenticatedUser()
  {
        try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                        return response()->json(['user_not_found'], 404);
                }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }




}
