@extends('users.layout')
@section('content')
 
 
<div class="card">
  <div class="card-header">Users Page</div>
  <div class="card-body">
   
 
        <div class="card-body">
        <h5 class="card-title">Role : {{ $users->usertype }}</h5>
        <h5 class="card-title">Name : {{ $users->name }}</h5>
        <h5 class="card-title">Username : {{ $users->username }}</h5>
        <p class="card-text">Email : {{ $users->email }}</p>

        @if ($users->profile_photo_path)
    <img src="{{ asset('storage/' . $users->profile_photo_path) }}" alt="Profile Photo" class="img-fluid mb-3">
@else
    <p>No photo uploaded.</p>
@endif
  </div>
       
    </hr>
  
  </div>
</div>