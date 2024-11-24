@extends('services.layout')
@section('content')
 
 
<div class="card">
  <div class="card-header">Services Page</div>
  <div class="card-body">
   
 
        <div class="card-body">
        <h5 class="card-title">Name: {{ $services->name }}</h5>
            <!-- Display the formatted price -->
            <p class="card-text">Price: ₱{{ $formattedPrice }}</p>
  </div>
       
    </hr>
  
  </div>
</div>