<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Dclass;
use App\Lecture;
use App\Question;
use App\Answer;
use App\Notification;
use Hash;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Abstracts\users_transform;
use App\Abstracts\useful_functions;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostAnswers;
use App\Mail\Score;
use PDF;





class ApiController extends Controller
{

    public function ShowOnlineclass(){
        $class = $this->getClass();
        return response()->json(['result'=>$class]);
    } 


    public function  ShowOnlinelec ($classnum){

        $theClass = Dclass::find($classnum);
        $lec = $theClass->lectures()->get(); 
        return response()->json(['result'=>$lec,'classInfo'=>$theClass]);
    }       


    public function   showQuestion($id){
        $theClass = Dclass::find($id);
        $q = $theClass->questions()->orderBy('id','Asc')->get();     
        return response()->json(['result'=>$q,'classInfo'=>$theClass]);
    }  


    public function   getAnswers(){
        // $data = Answer::with('user')->orderBy('id','Desc')->get();

        // $data = Answer::with(['user' => function($query) {
        //     $query->where('favorites.user_id', auth()->id);
        // }])->get();

        $data = User::with('answers')->orderBy('id','Desc')->get();
        return response()->json(['result'=>$data]);
    }  



    // public function   getSingleAnswers($id){
    //     $ans = Answer::find($id);
    //     $user_id = $ans->user_id;
    //     $data = Answer::where('user_id',$user_id)->orderBy('id','Desc')->get();
    //     return response()->json(['result'=>$data,'user_id'=> $user_id]);
    // }  

    public function   getSingleAnswers($id){
        $ans = Answer::find($id);
        $user_id = $ans->user_id;
        $data = User::with('answers')->orderBy('id','Desc')->get();
        return response()->json(['result'=>$data,'user_id'=> $user_id]);
    } 

    public function   postQuestion($id, Request $request)
    {
        $input = $request->all();
        $rules = array();
        $data = $input;
        $count = count($data);
        $count = $count - 3; // i added two things user_id,the class and token


        //return response()->json(['count'=>$count,'data'=>$data]);
        //dd($data);
        
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
        $info =  preg_replace('/[^a-zA-Z0-9_:)(><\/ -]/s','',$info); //escaping special chars

        $A = new Answer();
        $A->dclass = $request->class_name;
        $A->answer = utf8_encode($info);
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

    private function nextClass($class,$counts,$currentClass){
        $nextClass ="";
        for($i=0;$i <$counts ; $i++){
            if($currentClass == $class[$i]['class'] && $i == $counts - 1){
                $nextClass = "";
            }elseif($currentClass == $class[$i]['class'] && $i < $counts ){
                $nextClass = $class[$i+1]['class'];
            }
        }
        return $nextClass;

    }



    private function getClass(){
        $class = Dclass::all();
        return $class;
    }


    public function scoreUser(Request $request){

        $classes = $this->getClass();
        $counts = count($classes);


        $status = $request->status;
        $ans_id = $request->answerId;
        //$name = $request->name,
        $currentClass = $request->dclass;
        //$email = $request->email,
        $comments = $request->comments;

        $ans = Answer::find($ans_id);
        $class = Dclass::where('class',$ans->dclass)->first();


        $nextClass = $this->nextClass($classes,$counts,$currentClass);



        //return response()->json(['status'=>$class,'count'=>$counts,'nextclass'=>$nextClass,'test'=>$classes[0]['class']]);




        if($nextClass ==""){
            $message = "You have passed.\n ";
            $message .= $comments;
            $message .= "Congrats on the completion of the Believers Class";
        }
        $message = "You have passed. ";
        $message .= $comments." \n";
        $message .= "Kindly move to ".$nextClass."\n";
        
        if($status !== "passed"){
            // edit status @ answers
            $data = Answer::find($ans_id);
            $data->status = $status;
            $data->save();

            $message = "Your answers were not satisfactory .\n";
            $message .= $comments." \n";
            $message .=  "Kindly repeat ".$currentClass;

            $n = Notification::updateOrCreate(
                ['user_id' => $ans->user_id,'answer_id'=>$ans->id, 'class_id'=>$class->id], // conditions & input
                ['answer_id'=>$ans->id,'class_id'=>$class->id,'user_id' => $ans->user_id,'message' => $message,'status'  => $status] // inputs
            );
        // send email
        $emailInfo = [
            'name' => $data->user->fname,
            'message' => $message,
            'question' => $data->dclass

        ];            
        Mail::to($data->user->email)->send(new Score($emailInfo));
        return response()->json(['status'=>$status]);

        }else{
            // update answer status
            $data = Answer::find($ans_id);
            $data->status = $status;
            $data->save();

            // create a notification insert
            // check and delete row

  
            $n = Notification::updateOrCreate(
                ['user_id' => $ans->user_id,'answer_id'=>$ans->id, 'class_id'=>$class->id], // conditions & input
                ['answer_id'=>$ans->id,'class_id'=>$class->id,'user_id' => $ans->user_id,'message' => $message,'status'  => $status] // inputs
            );


        // send email
        $emailInfo = [
            'name' => $data->user->fname,
            'message' => $message,
            'question' => $data->dclass

        ];            
        Mail::to($data->user->email)->send(new Score($emailInfo));
        return response()->json(['status'=>$status]);

        }



      
      

    } 


    public function notification(User $user){
        //$data = $user->notifications()->get();
        $data = $user->notifications()->with('classes')->orderBy('id','DESC')->get();
        return response()->json(['result'=>$data]);
    }




    public function getPercentage(User $user){
        $class_no = count($this->getClass());
        $percentage_level = 100/$class_no;
        $notification_passed = $user->notifications()->distinct('class_id')->where('status','passed')->count();
        $percent = $percentage_level * $notification_passed;

        $roundedValue = round($percent,0);
        if($roundedValue === 100 || $roundedValue > 99 ){


        if($user->completed_date === NULL){

          // update user status
          $user->status = "completed";
          $user->completed_date = date('Y-m-d\TH:i:s.uP', time());
          $user->save();

        }


        }

        return response()->json([
        'result'=>$roundedValue
        ]);

    }


    public function getReports(){
        $data = User::where('status','completed')->get();
        return response()->json(['result'=>$data]);
    }




    public function downloadReports(Request $request) 
    {
        //https://www.positronx.io/laravel-pdf-tutorial-generate-pdf-with-dompdf-in-laravel/
        //pdf

        $from = $request->from;
        $to = $request->to;

        if($from == "" && $to != ""){
            return response()->json(['error'=>'To date required!'], 400);
        }elseif($from != "" && $to == ""){
            return response()->json(['error'=>'From date required!'], 400);
        }elseif($from == "" || $to == ""){
            // get  all reports
            $data=  User::where('status','completed')->get();
            view()->share('reports',$data);
            $pdf = PDF::loadView('pdf/pdf_view', $data);
            return $pdf->download('pdf_file.pdf');
        }


        
         // get selected reports
        $data=  User::where('status','completed')
        ->whereBetween('completed_date', [$from,$to])->get();

        // share data to view
        view()->share('reports',$data);
        $pdf = PDF::loadView('pdf/pdf_view', $data);
  
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');



    }


}
