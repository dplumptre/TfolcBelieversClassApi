<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Dclass;
use App\Lecture;
use App\Question;
use App\Answer;
use Hash;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Abstracts\users_transform;
use App\Abstracts\useful_functions;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostAnswers;





class ApiController extends Controller
{
    


    public function ShowOnlineclass(){
        $class = Dclass::all();
        // return response()->json([
        //     'result' => $transform($class)
        // ],200);
        return response()->json(['result'=>$class]);
    } 


    public function  ShowOnlinelec ($classnum){

        $theClass = Dclass::find($classnum);
        $lec = $theClass->lectures()->get(); 
       // $lec = Lecture::where('class_id','=',$classnum)->orderBy('position','Asc')->get();    
        // return response()->json([
        //     'result' =>  $this->transform->lectransform($lec)  
        // ],200);
        return response()->json(['result'=>$lec,'classInfo'=>$theClass]);
    }       


    public function   showQuestion($id){
        $theClass = Dclass::find($id);
        $q = $theClass->questions()->orderBy('id','Asc')->get();     
        return response()->json(['result'=>$q,'classInfo'=>$theClass]);
    }  


    public function   getAnswers(){
        $data = Answer::all();
        return response()->json(['result'=>$data]);
    }  




    public function   postQuestion($id, Request $request)
    {
        $input = $request->all();

        $rules = array();
        $data = $input;
        $count = count($data);
        $count = $count - 2; // i added two things user_id and the class 
        
        for ($i = 1; $i < $count+1; $i++)
        {
            $rules['question'.$i] ='required|min:2';   
        } 

        $validator = Validator::make($input,$rules);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()],422);
        }

        //getting all answers
        $fullans = array();
        for($i=1;$i<$count +1 ;$i++){    
        $fullans[]="<strong>Answer </strong>".$i."<br />".$data["question".$i]."<br /><br />";
        }
        $info = implode(',', $fullans);

        $A = new Answer();
        $A->dclass = $request->class_name;
        $A->answer = $info;
        $A->user_id = $request->user_id;
        $A->save();

    /*
    * send email
    * get user credential
    */            


        $user = User::find($request->user_id);
        $fullname = $user->lname." ".$user->fname;
        $email = $user->email;        
        
        $emailInfo = [
            'name' => $fullname,
            'classTitle' => $request->class_name,
            'email' => $email,
            'data'=> $data,
            'counts'=>$count,

        ];

        
        Mail::to('info@believersclass.tfolc.org')->send(new PostAnswers($emailInfo));
        return response()->json(['result'=>"successfully sent!"]);

    }  








}
