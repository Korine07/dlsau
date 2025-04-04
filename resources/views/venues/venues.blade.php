@extends('venues.layout')
@section('content')
<div class="container-fluid">
    <!-- Form Wrapper -->
    <div class="content-wrapper mt-5 p-4 shadow rounded bg-light">
            <h1 class="mb-0 text-center" style="font-size: 30px;">Create New Venue</h1>

            @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <hr style="border: 1px solid green; margin-bottom: 20px;">

        <form method="POST" action="{{ route('venues.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-5">
                    <!-- Venue Name -->
                    <div class="mb-3">
                        <label for="venue_name" class="form-label">Venue Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" class="form-control @error('venue_name') is-invalid @enderror" id="venue_name" name="venue_name" value="{{ old('venue_name') }}" placeholder="Venue Name" required>
                        </div>
                        @error('venue_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Venue Description -->
                    <div class="mb-3">
                        <label for="venue_description" class="form-label">Venue Description</label>
                        <textarea class="form-control @error('venue_description') is-invalid @enderror" id="venue_description" name="venue_description" rows="5">{{ old('venue_description') }}</textarea>
                        @error('venue_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Venue Details -->
                    <div class="mb-3">
                        <label for="venue_details" class="form-label">Venue Details</label>
                        <textarea class="form-control @error('venue_details') is-invalid @enderror" id="venue_details" name="venue_details">{{ old('venue_details') }}</textarea>
                        @error('venue_details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Venue Capacity -->
                    <div class="mb-3">
                        <label for="venue_capacity" class="form-label">Venue Capacity</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                            <input type="number" class="form-control @error('venue_capacity') is-invalid @enderror" id="venue_capacity" name="venue_capacity" value="{{ old('venue_capacity') }}" min="0" required>
                        </div>
                        @error('venue_capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-5">
                    <!-- Select Category -->
                    <div class="mb-3">
                        <label for="venue_category" class="form-label">Select Category</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-columns"></i></span>
                            <select class="form-control" id="venue_category" name="venue_category" required>
                                <option value="" disabled selected>Please Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('venue_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                        <!-- Price Fields -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="guest_price" class="form-label">Guest Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control @error('guest_price') is-invalid @enderror" id="guest_price" name="guest_price" step="0.01" value="{{ old('guest_price') }}" required>
                                </div>
                                @error('guest_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="member_price" class="form-label">Partner Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control @error('member_price') is-invalid @enderror" id="member_price" name="member_price" step="0.01" value="{{ old('member_price') }}" required>
                                </div>
                                @error('member_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    

                    <!-- Venue Notes -->
                    <div class="mb-3">
                        <label for="venue_notes" class="form-label">Venue Notes</label>
                        <textarea class="form-control @error('venue_notes') is-invalid @enderror" id="venue_notes" name="venue_notes">{{ old('venue_notes') }}</textarea>
                        @error('venue_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Uploads -->
            <div class="row mb-4">
                <div class="col-md-5">
                    <label for="cover_photo" class="form-label">Upload Cover Photo</label>
                    <input type="file" class="form-control @error('cover_photo') is-invalid @enderror" id="cover_photo" name="cover_photo">
                    <small class="text-muted">Supported formats: JPG, PNG. Max size: 5MB.</small>
                    <div id="cover_photo_error" class="text-danger mt-2"></div>
                </div>

                <div class="col-md-5">
                    <label class="form-label">Upload Slider Images</label>
                    <div id="slider-images-container">
                        <div class="input-group mb-2 slider-image-input">
                            <input type="file" class="form-control" name="slider_images[]" accept="image/*">
                            <button type="button" class="btn btn-danger remove-row" style="display: none;">Remove</button>
                        </div>
                    </div>
                    <small class="text-muted">You can upload up to 10 images. Supported formats: JPG, PNG. Max size per image: 5MB.</small>
                    <div class="text-danger mt-2"></div>
                    <button type="button" class="btn btn-primary mt-2" id="add-slider-image">Add Row</button>
                    <div id="slider_images_error" class="text-danger mt-2"></div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

        function validateFileSize(inputElement, errorElement) {
            if (inputElement.files.length > 0) {
                const file = inputElement.files[0];

                if (file.size > maxFileSize) {
                    errorElement.textContent = "The selected file is too large! Maximum allowed size is 5MB.";
                    inputElement.value = ""; // Clear the file input
                } else {
                    errorElement.textContent = ""; // Clear error message if file is valid
                }
            }
        }

        // ✅ Validate Cover Photo
        const coverPhotoInput = document.getElementById("cover_photo");
        const coverPhotoError = document.getElementById("cover_photo_error");

        if (coverPhotoInput) {
            coverPhotoInput.addEventListener("change", function () {
                validateFileSize(coverPhotoInput, coverPhotoError);
            });
        }

        // ✅ Validate Slider Images
        const sliderImagesContainer = document.getElementById("slider-images-container");
        const sliderImagesError = document.getElementById("slider_images_error"); // Error message under the entire field

        sliderImagesContainer.addEventListener("change", function (event) {
            if (event.target.name === "slider_images[]") {
                validateFileSize(event.target, sliderImagesError);
            }
        });

        // ✅ Add Row Button for Slider Images
        const addButton = document.getElementById("add-slider-image");

        addButton.addEventListener("click", function () {
            const totalRows = sliderImagesContainer.querySelectorAll(".slider-image-input").length;

            if (totalRows < 10) {
                const newRow = document.createElement("div");
                newRow.classList.add("input-group", "mb-2", "slider-image-input");

                newRow.innerHTML = `
                    <input type="file" class="form-control" name="slider_images[]" accept="image/*">
                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                `;

                sliderImagesContainer.appendChild(newRow);
                updateRemoveButtons();
            } else {
                alert("You can upload a maximum of 10 images.");
            }
        });

        // ✅ Remove Row Button for Slider Images
        sliderImagesContainer.addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-row")) {
                event.target.parentElement.remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = sliderImagesContainer.querySelectorAll(".slider-image-input");
            rows.forEach((row, index) => {
                const removeButton = row.querySelector(".remove-row");
                removeButton.style.display = index > 0 ? "inline-block" : "none";
            });
        }

        updateRemoveButtons();
    });

    // Automatically hide the success alert after 3 seconds
    document.addEventListener("DOMContentLoaded", function () {
        let successAlert = document.querySelector(".alert-success");
        if (successAlert) {
            setTimeout(function () {
                successAlert.style.transition = "opacity 0.5s";
                successAlert.style.opacity = "0";
                setTimeout(() => successAlert.remove(), 500); // Remove after fade-out
            }, 2000);
        }
    });
</script>
@endsection
