@extends('create.layout')
@section('content')
<div class="container">
    <!-- Additional Container for Content Wrapping -->
    <div class="content-wrapper mt-5 p-4 shadow rounded bg-light">
        <h1>Venue Module</h1>
        <form method="POST" action="{{ route('venues.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Venue Name -->
            <div class="form-group">
                <label for="venue_name">Venue Name</label>
                <input type="text" class="form-control" id="venue_name" name="venue_name" required>
            </div>

            <!-- Venue Description -->
            <div class="form-group">
                <label for="venue_description">Venue Description</label>
                <textarea class="form-control" id="venue_description" name="venue_description" rows="3"></textarea>
            </div>

            <!-- Venue Details -->
            <div class="form-group">
                <label for="venue_details">Venue Details</label>
                <textarea class="form-control" id="venue_details" name="venue_details"></textarea>
            </div>

            <!-- Venue Capacity -->
            <div class="form-group">
                <label for="venue_capacity">Venue Capacity</label>
                <input type="number" class="form-control" id="venue_capacity" name="venue_capacity" min="0" required>
            </div>

            <!-- Select Category -->
            <div class="form-group">
                <label for="venue_category">Select Category</label>
                <select class="form-control" id="venue_category" name="venue_category" required>
                    <option value="" disabled selected>Please Select</option>
                    @foreach ($categories as $categories)
                        <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Guest Price -->
            <div class="form-group">
    <label for="guest_price">Guest Price</label>
    <input type="number" class="form-control" id="guest_price" name="guest_price" step="0.01" placeholder="0.00" required>
</div>

            <!-- Member Price -->
            <div class="form-group">
    <label for="member_price">Member Price</label>
    <input type="number" class="form-control" id="member_price" name="member_price" step="0.01" placeholder="0.00" required>
</div>

            <!-- Venue Notes -->
            <div class="form-group">
                <label for="venue_notes">Venue Notes</label>
                <textarea class="form-control" id="venue_notes" name="venue_notes"></textarea>
            </div>

            <!-- Upload Cover Photo -->
<div class="form-group">
    <label for="cover_photo">Upload Cover Photo</label>
    <input type="file" class="form-control" id="cover_photo" name="cover_photo">
</div>

            <!-- Upload Slider Images -->
            <div class="form-group">
                <label for="slider_images">Upload Slider Images</label>
                <input type="file" class="form-control" id="slider_images" name="slider_images[]" multiple>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            let coverPhoto = document.getElementById("cover_photo");
            let sliderImages = document.getElementById("slider_images");

            const maxSize = 5 * 1024 * 1024; // 5MB in bytes

            // Check cover photo size
            if (coverPhoto.files.length > 0 && coverPhoto.files[0].size > maxSize) {
                alert("Cover photo size must be less than 5MB!");
                event.preventDefault(); // Stop form submission
                return;
            }

            // Check each slider image size
            if (sliderImages.files.length > 0) {
                for (let i = 0; i < sliderImages.files.length; i++) {
                    if (sliderImages.files[i].size > maxSize) {
                        alert("One of the slider images exceeds 5MB! Please upload smaller files.");
                        event.preventDefault(); // Stop form submission
                        return;
                    }
                }
            }
        });
    });
</script>

@endsection