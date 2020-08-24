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












        /*
        *  when u do json_decode u get
        * values like this below
        * $data->{'answer1'};
        * create the answers below 
        */
        // $ans = $request->arrcount + 1 ;
        // $startNum = 1;
        // $fullans = array();
        // for($i=$startNum;$i<$ans;$i++){
        //     $fullans[]="<strong>Answer </strong>".$i."<br />".$data->{'answer'.$i}."<br /><br />";    
        // //$fullans[]="<strong>Answer </strong>".$i."<br /><br /><br />";
        // }
        // $info = implode(',', $fullans);



    /* add to the database
    * 
    */
    // $A = new Answer();
    // $A->dclass = $request->theclaz;
    // $A->answer = $info;
    // $A->user_id = $request->user_id;
    // $A->save();          

    /**  ============================ */

//     $credentials = $request->all();
//     $count = count($credentials);//  dd($count);

//     $counts = $count - 3; 
//     $rules = array();
//     for ($i = 1; $i < $counts+1; $i++)
//     {
//         $rules['answer'.$i] ='required';   
//     } 
   
// $v = User::validate($credentials,$rules);
// if($v !== true){    
// return Redirect::to('user-area/question/'.Input::get('quest_id'))->withErrors($v)->withInput(); 

//     $user =User::find(Auth::user()->id);
//     $fullname = $user->lname." ".$user->fname;
//     $email = $user->email;
    
           
//     //getting all answers
//     $ans = $counts + 1 ;
//     $startNum = 1;
   
//     $ans = $counts + 1 ;
//     $startNum = 1;
//     $fullans = array();
//     for($i=$startNum;$i<$ans;$i++){    
//     $fullans[]="<strong>Answer </strong>".$i."<br />".$credentials["answer".$i]."<br /><br />";
    
//     }
//     $info = implode(',', $fullans);

//     $A = new Answer();
//     $A->dclass = Input::get('class_title');
//     $A->answer = $info;
//     $A->user_id = $user->id;
//     $A->save();



    /**  ============================ */

    /*
    * send email
    * get user credential
    */            


  //  $user = User::find($request->user_id);
  //  $fullname = $user->lname." ".$user->fname;
   // $email = $user->email;            

/*
    Mail::send('mail.message-answer',  array('name'=>$fullname,'classtitle'=>$request->theclaz,
    'email'=>$email,'data' => $data,'startNum'=>$startNum,
    'ans'=>$ans,'counts'=>$request->arrcount), function($message)
    {
    $message->to($site_email,'Believers Class')
    ->replyTo($site_email,"Belivers Class")
    ->subject('The Fountain of Life:Belivers Class - Answers To '.$request->theclaz);
    });

    */

    }  








}
