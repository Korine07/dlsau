<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch total reservations based on status
        $total_pending = Reservation::where('status', 'Pending')->count();
        $total_confirmed = Reservation::where('status', 'Confirmed')->count();
        $total_completed = Reservation::where('status', 'Completed')->count();
        $total_revenue = Reservation::where('status', 'Completed')->sum('total_price');

        // Data for Graphs (Revenue by Month)
        $monthlyRevenue = Reservation::where('status', 'Completed')
            ->selectRaw('SUM(total_price) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Fetch upcoming reservations (next 5 reservations from today onward)
        $upcomingReservations = Reservation::where('check_in_date', '>=', now()->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('check_in_date')
            ->limit(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'total_pending', 'total_confirmed', 'total_completed',
            'total_revenue', 'monthlyRevenue', 'upcomingReservations'
        ));
    }
    
    public function user()
    {
        $data=user::all();
        return view("admin.users", compact("data"));
    }

    public function deleteuser($id)
    {
        $data=user::find($id);
        $data->delete();
        return redirect()->back(); 
    }
}