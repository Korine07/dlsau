@extends('venues_list.layout')

@section('content')
<div class="container">
    <h1>Edit Venue</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit form -->
    <form action="{{ route('venues.update', $venue->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="venue_name">Venue Name</label>
            <input type="text" class="form-control" id="venue_name" name="venue_name" value="{{ old('venue_name', $venue->venue_name) }}" required>
        </div>

        <div class="form-group">
            <label for="venue_category">Category</label>
            <select class="form-control" id="venue_category" name="venue_category" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $venue->venue_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="guest_price">Guest Price</label>
            <input type="number" class="form-control" id="guest_price" name="guest_price" value="{{ old('guest_price', $venue->guest_price) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="member_price">Member Price</label>
            <input type="number" class="form-control" id="member_price" name="member_price" value="{{ old('member_price', $venue->member_price) }}" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('venues.list') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection