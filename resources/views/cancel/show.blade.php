@extends('cancel.layout')
@section('content')
 
 
<div class="card">
  <div class="card-header">Students Page</div>
  <div class="card-body">
   
 
        <div class="card-body">
        <h5 class="card-title">Name : {{ $cancel->name }}</h5>
        <p class="card-text">Address : {{ $cancel->address }}</p>
        <p class="card-text">Mobile : {{ $cancel->mobile }}</p>
  </div>
       
    </hr>
  
  </div>
</div>