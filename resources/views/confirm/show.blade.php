@extends('confirm.layout')
@section('content')
 
 
<div class="card">
  <div class="card-header">Students Page</div>
  <div class="card-body">
   
 
        <div class="card-body">
        <h5 class="card-title">Name : {{ $confirm->name }}</h5>
        <p class="card-text">Address : {{ $confirm->address }}</p>
        <p class="card-text">Mobile : {{ $confirm->mobile }}</p>
  </div>
       
    </hr>
  
  </div>
</div>