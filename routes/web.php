<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OneController;
use App\Http\Controllers\VenuesController;
use App\Http\Controllers\VenueListController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\CompletedController;
use App\Http\Controllers\CancelController;
use App\Http\Controllers\CalendarController;








// Public Routes
Route::get('/', function () {
    return view('home.home');
});

// Home
Route::get("/home",[HomeController::class,"index"]); /*home */
Route::get("/facilities",[FacilitiesController::class,"index"]); /*facilities */
Route::get("/contact",[ContactController::class,"index"]); /*contact */
Route::get("/booking",[BookingController::class,"index"]); /*booking */
Route::get("/one",[OneController::class,"index"]); /*facility 1 */
Route::get('/facilities', [FacilitiesController::class, 'index'])->name('facilities.facilities');


// Authentication Middleware Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

// Home and Admin Routes
Route::get("/users",[AdminController::class,"user"]);
Route::get("/deleteuser/{id}",[AdminController::class,"deleteuser"]);


// Resource Controllers
Route::resource("/categories", CategoriesController::class); /*categories*/
Route::resource("/members", MembersController::class); /*members*/
Route::resource("/services", ServicesController::class); /*services*/
Route::resource("/users", UsersController::class); /*users*/
Route::resource('/venues', VenuesController::class); /*venues_create*/
Route::resource("/venue_list", VenueListController::class);
Route::resource("/pending", PendingController::class);
Route::resource("/confirm", ConfirmController::class);
Route::resource("/completed", CompletedController::class);
Route::resource("/cancel", CancelController::class);
Route::resource('/create', VenuesController::class);
Route::resource('/venue_list', VenuesController::class);
Route::resource('/calendar', CalendarController::class);


});

// Logout Route
Route::post('/logout', function () {
    Auth::logout();  // Logs out the user
    request()->session()->invalidate(); // Invalidates the session
    request()->session()->regenerateToken(); // Regenerates CSRF token for security
    return redirect('/login'); // Redirects to login page
})->middleware('auth')->name('logout');


Route::get("/redirects",[HomeController::class,"redirects"]); /*home admin*/