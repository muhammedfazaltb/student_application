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

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
        @if($user->role==0)
      <h1 class="w3-text-teal">Admin Dashboard....</h1>
       @else
       <h1 class="w3-text-teal">Teacher's Dashboard...</h1>
       @endif

    </div>
  </div>

  

<!-- END MAIN -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
@endsection