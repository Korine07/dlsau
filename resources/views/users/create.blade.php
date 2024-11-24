@extends('users.layout')
@section('content')
 
<div class="card">
  <div class="card-header">Users Page</div>
  <div class="card-body">
      
  <form action="{{ url('users') }}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    
    <!-- Role Selection -->
    <label for="usertype">Role</label>
    <select name="usertype" id="usertype" class="form-control">
        <option value="1">Admin</option>
        <option value="0">Staff</option>
    </select>
    </br>

    <label>Name</label></br>
    <input type="text" name="name" id="name" class="form-control"></br>

    <label>Username</label></br>
    <input type="text" name="username" id="username" class="form-control"></br>

    <label>Email</label></br>
    <input type="email" name="email" id="email" class="form-control"></br>

    <label>Password</label></br>
    <input type="password" name="password" id="password" class="form-control"></br>

    <label>Confirm Password</label></br>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"></br>

    <label>Profile Photo</label></br>
    <input type="file" name="profile_photo" id="profile_photo" class="form-control"></br>

    <input type="submit" value="Save" class="btn btn-success"></br>
</form>
   
  </div>
</div>
 
@stop