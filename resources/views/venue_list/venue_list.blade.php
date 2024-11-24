@extends('venues_list.layout')

@section('content')
<div class="container">
    <h1>Venues List</h1>

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Member Price</th>
                <th>Guest Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venues as $venue)
                <tr>
                    <td>{{ $venue->venue_name }}</td>
                    <td>{{ $venue->categories->name }}</td>
                    <td>{{ $venue->member_price }}</td>
                    <td>{{ $venue->guest_price }}</td>
                    <td>
                        <!-- Edit button -->
                        <a href="{{ route('venues.edit', $venue->id) }}" class="btn btn-primary">Edit</a>

                        <!-- Delete button -->
                        <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this venue?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection