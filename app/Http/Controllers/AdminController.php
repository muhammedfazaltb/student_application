<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\StudentClass;
use App\Models\StudentDivision;
use App\Models\ClassSubject;
use App\Models\Students;
use App\Models\User;
use App\Models\StudentMarks;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    //
    public function adminDashboard()
    {
        $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        return view('home')->with($data);
         }
         else
         {
            return view('warning'); 
         }
    }
    public function teacherDashboard()
    {
      $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        return view('warning');
         }
         else
         {
           return view('home')->with($data);
         }
    }
    public function createclass()
    {   
        $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        $data['classes']=StudentClass::get();
        return view('create_class')->with($data);
        }  
        else
        {
         return view('warning');   
        }     
    }
     public function AddClass(Request $request)
    {
        $result=StudentClass::create([
            'class_name'=>$request->get('class_name')
        ]);
        return redirect()->back();
    }
     public function createdivision()
    {
         $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        $data['classes']=StudentClass::get();
        $data['divisions']=StudentDivision::join('table_class','table_class.id','table_division.class_id')->get();
        return view('create_division')->with($data);
        }
        else
        {
          return view('warning');    
        }

        
    }
     public function AddDivision(Request $request)
    {
        $result=StudentDivision::create([
            'class_id'=>$request->get('class_id'),
            'division_name'=>$request->get('name')

        ]);
        return redirect()->back();
    }
    public function addTeacher()
    {   
        $data['user']= Auth::user();
        $data['error']="";
        if($data['user']->role ==0)
        {
        return view('add_new_teacher')->with($data);
        }  
        else
        {
         return view('warning');   
        }     
    }
    
     public function createSubject()
    {
         $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        $data['classes']=StudentClass::get();
        $data['subjects']=ClassSubject::join('table_class','table_class.id','class_subject.class_id')->get();
        return view('create_subject')->with($data);
        }
        else
        {
          return view('warning');    
        }      
    }
     public function AddSubject(Request $request)
    {
        $result=ClassSubject::create([
            'class_id'=>$request->get('class_id'),
            'subject'=>$request->get('name')

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
   
    public function createTeacher(Request $request)
    {   
        $data['user']= Auth::user();
        $validator= Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        $validate= Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);
        if($validate->fails()) {
            $data['error']="Duplicate email";
            return view('add_new_teacher')->with($data);
        }
        if($validator->fails()) {
            $data['error']="Password mismatch";
            return view('add_new_teacher')->with($data);
        }
        else
        {
            $result = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => 1,
            ]);
            $data['error']="Success";
            return view('add_new_teacher')->with($data);
        }
      
           
    }
    public function Studentreport()
    {
         $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        $data['teachers']=User::where('role',1)->get(); 
        if( $data['teachers']){
            foreach($data['teachers'] as $key=>$result){
               $students=Students::where('teacher_id', $result->id)->join('table_class','table_class.id','table_student.class_id')->get();    
               $data['teachers'][$key]['students']=$students;
            }



          return view('student_report')->with($data); 
        }
        }
        else
        {
            
          return view('warning'); 
        }      
    }
    
    public function Studentmarkreport()
    {
         $data['user']= Auth::user();
        if($data['user']->role ==0)
        {
        $data['students']=Students::join('table_class','table_class.id','table_student.class_id')->select('table_student.*','table_class.*','table_student.id as stud_id')->get();
        //dd($data['students']);
        if( $data['students']){
            foreach($data['students'] as $key=>$result){
               $marklist=StudentMarks::where('student_id', $result->stud_id)->join('class_subject','class_subject.id','student_mark.subject_id')->get();
               $data['students'][$key]['marks']=$marklist;
              
            }

      
          return view('student_mark_report')->with($data); 
        }
    }
        else
        {
            
          return view('warning'); 
        }      
    }

}
