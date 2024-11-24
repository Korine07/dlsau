@extends('services.layout')
@section('content')
 
<div class="card">
  <div class="card-header">Services Page</div>
  <div class="card-body">
      
      <form action="{{ url('services/' .$services->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" id="id" value="{{$services->id}}" id="id" />
        <label>Name</label></br>
        <input type="text" name="name" id="name" value="{{$services->name}}" class="form-control"></br>
        <label>Price</label></br>
        <input type="text" name="price" id="price" value="{{$services->price}}" class="form-control"></br>
        <input type="submit" value="Update" class="btn btn-success"></br>
    </form>
   
  </div>
</div>
 
@stop