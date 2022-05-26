@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<title>Student System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
</style>
</head>
<body>
<!-- Sidebar -->
 <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>Menu</b></h4>
  @if($user->role==0)
  
  <a class="w3-bar-item w3-button w3-hover-black" href="{{ route('admin.dashboard') }}">Dashboard</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{ route('admin.createteacher') }}">Create New Teacher</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('admin.addclass')}}">Add new class</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('admin.adddivision')}}">New Division</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('admin.addsubject')}}">Add subject</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('admin.students')}}">Student Report</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('admin.student.mark')}}">Student Mark Report</a>
  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}     </a>
   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
     @csrf
   </form>
   
  @else
  
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('teacher.dashboard')}}">Dashboard</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="{{route('teacher.addstudent')}}">Add student</a>
<a class="w3-bar-item w3-button w3-hover-black" href="{{route('teacher.addmark')}}">Mark list</a>

  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}  </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
     @csrf
    </form>
  @endif
 
</nav>

<!-- Listing Event of Authenticated user -->
<div class="w3-main" style="margin-left:250px">
<h3>class</h3>
<form method="POST" action="{{route('teacher.createmark')}}">
                        @csrf
<div class="row">
     
        <div class="col-4">
            
            <label>Class:</label>
            <select name="class_id" id="class_id">
                <option value="">--select--</option>
                @foreach($classes as $class)
                <option value="{{$class->id}}">{{$class->class_name}}</option>
                @endforeach
            </select>
            <br>
            <label>Student:</label>
            <select name="student" id="student">
               
            </select>

            <br>
             <label>Subject:</label>
            <select name="subject" id="subject">
               
            </select><br>
            <label>Mark:</label>
            <input  type="text" class="form-control"  name="mark"><br>
        </div>
        <div class="col-4">
        </div>
        <div class="col-6">
            <input type="submit" name="submit" value="Save">  
        </div>
    
      </div> 
      </form>
    <hr>

</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
 $("#class_id").change(function(){
    var val=$("#class_id :selected").val();
    $.ajax({
          type: 'post',
          url: '{{ URL::route("UserPostManage") }}',
          data: {_token:'{{ csrf_token() }}',type:'check_student',val:val},
          success: function(data) {
            if(data.statusCode == 6000){
                
                $("#student").empty();
                $("#student").append(data.result.students);
                $("#subject").empty();
                $("#subject").append(data.result.subjects);
                 // swal(data.message).then(function(){
                 // window.location.reload();
                 // });
            }
            else{
                return false;
                window.location.reload();
            }
          }
    });
  
});
});
     
</script>
@endsection