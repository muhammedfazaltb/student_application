<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentClass;
use App\Models\StudentDivision;
use App\Models\ClassSubject;
use App\Models\Students;
use App\Models\User;
use App\Models\StudentMarks;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        return view('home')->with($data);
         }
         else
         {
            return view('home')->with($data); 
         }
    }
    public function AddStudent()
    {
         $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        return view('warning');
        }
        else
        {
          $data['classes']=StudentClass::get();
          $data['divisions']=StudentDivision::join('table_class','table_class.id','table_division.class_id')->get();
          return view('add_student')->with($data);    
        }      
    }
    public function CreateStudent(Request $request)
    { 
          $file_url="";
                if ($request->hasFile('image')) {
                    $file = request()->file('image');
                    $file_url =$file->store('toPath', ['disk' => 'my_files']);
                }
         // dd($file_url);
        // dd($request->file('image'));

      $teacher_id=Auth::user(); 
      $result=Students::create([
            'name'=>$request->get('name'),
            'address_one'=>$request->get('address1'),
            'address_two'=>$request->get('address2'),
            'role_no'=>$request->get('roleno'),
            'class_id'=>$request->get('class_id'),
            'division_id'=>$request->get('division_id'),
            'teacher_id'=>$teacher_id->id,
            'image'=>$file_url
        ]);
        return redirect()->back();      
    }

     public function AddMark(Request $request)
    {
        $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        return view('warning');
        }
        else
        {
            $data['classes']=StudentClass::get();
            return view('add_student_mark')->with($data);
        }

    }
     public function CreateMarks(Request $request)
    { 
    $teacher_id=Auth::user(); 
     
      $result=StudentMarks::create([
            'student_id'=>$request->get('student'),
            'subject_id'=>$request->get('subject'),
            'teacher_id'=>$teacher_id->id,
            'mark'=>$request->get('mark'),
        ]);
        return redirect()->back();      
    }
  public function userPostManage(Request $request){
      $user = Auth::user();
      $message = "";
      $statusCode = 6004;
      $result = null;
      $url = "";
     switch ($request->get('type')){
      case 'check_class' :
      // dd('hit');
      $class_id = $request->get('val');
      $results=StudentClass::where('table_class.id',$class_id)->join('table_division','table_division.class_id','table_class.id')->get();
      $html="";
      if($results)
      {
         foreach($results as $res){
          $html.="<option value='".$res->id."'>".$res->division_name."</option>";
         } 
      }
      $statusCode=6000;
      $message="success";
      return response()->json(['statusCode' => $statusCode, 'message' => $message, 'result' => $html]);

      break;
      case 'check_student' :
      $class_id = $request->get('val');
      $result['student']=StudentClass::where('table_class.id',$class_id)->join('table_student','table_student.class_id','table_class.id')->get();
      $studentopt="";
      if($result['student'])
      {
         foreach($result['student'] as $res){
          $studentopt.="<option value='".$res->id."'>".$res->name."</option>";
         } 
      }
      $result['subject']=StudentClass::where('table_class.id',$class_id)->join('class_subject','class_subject.class_id','table_class.id')->get();
      $subjectopt="";
      if($result['subject'])
      {
         foreach($result['subject'] as $res){
          $subjectopt.="<option value='".$res->id."'>".$res->subject."</option>";
         } 
      }
      $data['students']=$studentopt;
      $data['subjects']=$subjectopt;

      $statusCode=6000;
      $message="success";
      return response()->json(['statusCode' => $statusCode, 'message' => $message, 'result' => $data]);

      break;   
      }
  }
}
