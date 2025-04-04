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
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ReservationReportController;
use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ServiceReportController;


// Public Routes
//Route::get('/', function () {
//    return view('home.home');
//});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/booking', [BookingController::class, 'store']);
});

// Password Reset Routes
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get("/facilities",[FacilitiesController::class,"index"]); /*facilities */
Route::get("/contact",[ContactController::class,"index"]); /*contact */
//Route::get('/facilities', [FacilitiesController::class, 'index'])->name('facilities.facilities');
Route::get('/facilities', [FacilitiesController::class, 'index'])->name('facilities.index');



Route::get('/booking/success', function () {
    return view('success.success');
})->name('booking.success');

// Booking Routes
Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Reservation Status Routes
Route::get('/pending-reservations', [BookingController::class, 'pending'])->name('pending.reservations');
Route::get('/confirmed-reservations', [BookingController::class, 'confirm'])->name('confirmed.reservations');
Route::get('/completed-reservations', [BookingController::class, 'completed'])->name('completed.reservations');
Route::get('/cancelled-reservations', [BookingController::class, 'cancelled'])->name('cancelled.reservations');
Route::get('/archived-reservations', [BookingController::class, 'archived'])->name('archived.reservations');

// Calendar
Route::get('/calendar-events', [BookingController::class, 'getCalendarEvents']);
Route::get('/calendar-events', [CalendarController::class, 'getEvents']);

// Reservations
Route::patch('/reservations/{id}', [BookingController::class, 'update'])->name('reservations.update');
Route::delete('/reservations/{id}', [BookingController::class, 'destroy'])->name('reservations.destroy');
Route::patch('/reservations/complete/{id}', [BookingController::class, 'markAsCompleted'])->name('reservations.complete');
Route::patch('/reservations/archive/{id}', [BookingController::class, 'archive'])->name('reservations.archive');
Route::patch('/reservations/restore-archived/{id}', [BookingController::class, 'restoreArchived'])->name('reservations.restoreArchived');
Route::patch('/reservations/unarchive/{id}', [BookingController::class, 'unarchive'])->name('reservations.unarchive');
Route::patch('/reservations/restore/{id}', [BookingController::class, 'restore'])->name('reservations.restore');
Route::delete('/reservations/delete/{id}', [BookingController::class, 'delete'])->name('reservations.delete');

//email
Route::post('/reservations/{id}/send-confirmation-email', [BookingController::class, 'sendConfirmationEmail'])->name('reservations.send-confirmation-email');
Route::post('/reservations/{id}/send-completed-email', [BookingController::class, 'sendCompletedEmail'])->name('reservations.send-completed-email');
Route::post('/reservations/{id}/send-cancelled-email', [BookingController::class, 'sendCancelledEmail'])->name('reservations.send-cancelled-email');

Route::get('/get-fully-booked-dates', [BookingController::class, 'getFullyBookedDates']);
Route::get('/get-booked-times', function () {
    $reservations = Reservation::where('status', '!=', 'cancelled')->get();

    $bookedTimes = [];

    foreach ($reservations as $reservation) {
        $date = $reservation->check_in_date;

        $startTime = Carbon::parse($reservation->check_in_time)->format('H:i');
        $endTime = Carbon::parse($reservation->check_out_time)->format('H:i');

        if (!isset($bookedTimes[$date])) {
            $bookedTimes[$date] = [];
        }

        // Store all times between start and end time
        $current = Carbon::parse($startTime);
        while ($current < Carbon::parse($endTime)) {
            $bookedTimes[$date][] = $current->format('H:i');
            $current->addHour(); // Increment by 1 hour
        }
    }

    return response()->json($bookedTimes);
});

//Holidays
Route::get('/get-holidays', [BookingController::class, 'getHolidays']);
Route::get('/get-available-times', [BookingController::class, 'getAvailableTimes'])->name('available.times');
Route::get('/get-reservations-by-date', [CalendarController::class, 'getReservationsByDate']);


// Authentication Middleware Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


// Home and Admin Routes
Route::get("/users",[AdminController::class,"user"]);
Route::get("/deleteuser/{id}",[AdminController::class,"deleteuser"]);

Route::get('/holidays', [HolidayController::class, 'index']);
Route::post('/holidays', [HolidayController::class, 'store']);
Route::put('/holidays/{id}', [HolidayController::class, 'update']);
Route::delete('/holidays/{id}', [HolidayController::class, 'destroy']);

Route::get('/reservation-list', [ReservationReportController::class, 'showReservationList'])->name('reservation.list');
Route::post('/reservation-list/generate', [ReservationReportController::class, 'generateReservationReport'])->name('reservation.list.generate');

Route::get('/archived-list', [ReservationReportController::class, 'showArchivedList'])->name('reservation.archived');
Route::post('/archived-list/generate', [ReservationReportController::class, 'generateArchivedReport'])->name('reservation.archived.generate');

Route::get('/services-list', [ServiceReportController::class, 'showServiceList'])->name('services.list');
Route::post('/services-report', [ServiceReportController::class, 'generateServiceReport'])->name('services.report.generate');

Route::get('/venue-reports', [ReservationReportController::class, 'showVenueReportForm'])->name('venue.reservation.list');
Route::post('/venue-reports/generate', [ReservationReportController::class, 'generateVenueReport'])->name('venue.reservation.generate');

Route::get('/receipt/{id}', [BookingController::class, 'showReceipt'])->name('receipt.view');

Route::patch('/venue/disable/{id}', [VenuesController::class, 'disableVenue'])->name('venue.disable');
Route::patch('/venue/enable/{id}', [VenuesController::class, 'enableVenue'])->name('venue.enable');

Route::post('/venue-reservation/export', [ReservationReportController::class, 'exportToExcel'])
    ->name('venue.reservation.export');


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
//Route::resource('/create', VenuesController::class);
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



