@extends('members.layout')
@section('content')
 
<div class="card">
  <div class="card-header">Member Page</div>
  <div class="card-body">
      
      <form action="{{ url('members/' .$members->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" id="id" value="{{$members->id}}" id="id" />
        <label>Last Name</label></br>
        <input type="text" name="last_name" id="last_name" value="{{$members->last_name}}" class="form-control"></br>
        <label>First Name</label></br>
        <input type="text" name="first_name" id="first_name" value="{{$members->first_name}}" class="form-control"></br>

        <label>Member Type</label></br>
        <input type="text" name="address" id="address" value="{{$members->address}}" class="form-control"></br>
        <select name="memtyp" id="memtyp" required>
          <option value="student" {{ (isset($member) && $member->memtyp == 'student') ? 'selected' : '' }}>Student</option>
          <option value="employee" {{ (isset($member) && $member->memtyp == 'employee') ? 'selected' : '' }}>Employee</option>
        </select>

        <label>ID Number</label></br>
        <input type="text" name="idnum" id="idnum" value="{{$members->idnum}}" class="form-control"></br>
        <input type="submit" value="Update" class="btn btn-success"></br>
    </form>
   
  </div>
</div>
 
@stop