@extends('members.layout')
@section('content')
 
 
<div class="card">
  <div class="card-header">Members Page</div>
  <div class="card-body">
   
 
        <div class="card-body">
        <h5 class="card-title">Name : {{ $members->last_name }}, {{ $members->first_name }}</h5>
        <p class="card-text">Member Type : {{ $members->memtyp }}</p>
        <p class="card-text">ID Number : {{ $members->idnum }}</p>
  </div>
       
    </hr>
  
  </div>
</div>