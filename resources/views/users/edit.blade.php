@extends('users.layout')
@section('content')

<div class="card">
  <div class="card-header">Edit User</div>
  <div class="card-body">
      
      <form action="{{ url('users/' . $users->id) }}" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        @method("PATCH")

        <!-- Role Selection -->
        <label for="usertype">Role</label></br>
        <select name="usertype" id="usertype" class="form-control">
            <option value="1" {{ $users->usertype == 1 ? 'selected' : '' }}>Admin</option>
            <option value="0" {{ $users->usertype == 0 ? 'selected' : '' }}>Staff</option>
        </select>
        </br>

        <!-- Name -->
        <label for="name">Name</label></br>
        <input type="text" name="name" id="name" value="{{ $users->name }}" class="form-control"></br>

        <!-- Username -->
        <label for="username">Username</label></br>
        <input type="text" name="username" id="username" value="{{ $users->username }}" class="form-control"></br>

        <!-- Email -->
        <label for="email">Email</label></br>
        <input type="email" name="email" id="email" value="{{ $users->email }}" class="form-control"></br>

        <!-- Profile Photo -->
    <label for="profile_photo">Profile Photo</label></br>
    @if ($users->profile_photo_path)
        <!-- Display the current profile photo -->
        <img src="{{ asset('storage/' . $users->profile_photo_path) }}" alt="Profile Photo" width="100" class="mb-2">
    @else
        <p>No photo uploaded.</p>
    @endif
    <!-- Upload a new photo -->
    <input type="file" name="profile_photo" id="profile_photo" class="form-control"></br>

        <input type="submit" value="Update" class="btn btn-success"></br>
      </form>
   
  </div>
</div>

@stop