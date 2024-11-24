@extends('members.layout')
@section('content')

<div class="card">
  <div class="card-header">Member Page</div>
  <div class="card-body">
      <form action="{{ url('members') }}" method="post">
        {!! csrf_field() !!}
        
        <label>Last Name</label></br>
        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}"></br>
        
        <label>First Name</label></br>
        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}"></br>
        
        <label for="memtyp">Member Type</label>
        <select name="memtyp" id="memtyp" required>
          <option value="student" {{ old('memtyp') == 'student' ? 'selected' : '' }}>Student</option>
          <option value="employee" {{ old('memtyp') == 'employee' ? 'selected' : '' }}>Employee</option>
        </select>
        
        <label>ID Number</label></br>
        <input type="text" name="idnum" id="idnum" class="form-control" value="{{ old('idnum') }}"></br>
        
        <!-- Display validation error for ID Number -->
        @if($errors->has('idnum'))
            <div class="text-danger mt-2">
                {{ $errors->first('idnum') }}
            </div>
        @endif

        <input type="submit" value="Save" class="btn btn-success"></br>
    </form>
  </div>
</div>

@stop
