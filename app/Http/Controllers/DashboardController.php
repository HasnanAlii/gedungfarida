<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Finance;
use App\Models\gallery;
use App\Models\Hall;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

     if ($user->hasRole('admin')) {
            return view('dashboard_admin', [
                'totalReservations' => Reservation::count(),
                'confirmedPayments' => Payment::where('status', 'paid')->count(),
                'totalIncome'       => Finance::where('type', 'income')->sum('amount'),
                'recentReservations'=> Reservation::latest()->take(5)->get(),
            ]);
        } else {
            return view('dashboard_user', [
                'myReservations' => Reservation::where('user_id', $user->id)->latest()->take(5)->get(),
                'myPayments'     => Payment::whereHas('reservation', fn($q) => $q->where('user_id', $user->id))->get(),
            ]);
        }
    }

    public function welcome()
    {
        $galleries = gallery::all();
        $halls = Hall::all();


        return view('welcome', compact('galleries', 'halls'));
    }
}
