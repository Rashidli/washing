<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function show()
    {
        $id = auth()->user()->id;
        $reservation = Reservation::where('user_id', $id)->get();
        return response()->json($reservation);
    }

    public function index()
    {
        $reservations = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->join('washings', 'reservations.washing_id', '=', 'washings.id')
            ->select('reservations.*', 'users.name', 'washings.washing_name')
            ->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function store(Request $req)
    {
        $reservation = New Reservation();

        $reservation->user_id = auth()->user()->id;
        $reservation->washing_id = $req->washing_id;
        $reservation->vehicle_type = $req->vehicle_type;
        $reservation->service_type = $req->service_type;
        $reservation->day = $req->day;
        $reservation->time = $req->time;

        $reservation->save();
    }


}
