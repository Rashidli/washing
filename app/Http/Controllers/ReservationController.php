<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\SMS;
use DOMDocument;
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
            ->select('reservations.*', 'users.name', 'washings.washing_name', 'washings.owner_tel')
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
        $owner_tel = $reservation->owner_tel;

        $reservation->save();
        $message = $req->vehicle_type . $req->service_type . $req->time . $req->day;
        $sms = SMS::query()->orderByDesc('control_id')->first();
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('request');
        $dom->appendChild($root);

        $result = $dom->createElement('head');
        $root->appendChild($result);

        $result->appendChild($dom->createElement('operation', 'submit'));
        $result->appendChild($dom->createElement('login', 'washing'));
        $result->appendChild($dom->createElement('password', 'w@shin2022!'));
        $result->appendChild($dom->createElement('controlid', "$sms->control_id"));
        $result->appendChild($dom->createElement('title', 'Washing'));
        $result->appendChild($dom->createElement('scheduled', date("Y-m-d H:i:s")));
        $result->appendChild($dom->createElement('isbulk', 'false'));

        $result = $dom->createElement('body');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('message', $message));
        $result->appendChild($dom->createElement('msisdn', $owner_tel));

        $xml = $dom->saveXML();

        $curl = curl_init("https://sms.atatexnologiya.az/bulksms/api");
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_RETURNTRANSFER => true
        ]);
        $result = curl_exec($curl);
        curl_close($curl);

        SMS::query()->insert(['control_id' => $sms->control_id + 1]);
    }

    public function update(Request $req)
    {
        $id = auth()->user()->id;
        $reservation = Reservation::find('user_id', $id);
        $reservation->washing_id = $req->washing_id;
        $reservation->vehicle_type = $req->vehicle_type;
        $reservation->service_type = $req->service_type;
        $reservation->day = $req->day;
        $reservation->time = $req->time;
        $reservation->cancel = $req->cancel;
        $owner_tel = $reservation->owner_tel;

        $reservation->save();
        $message = $req->vehicle_type . $req->service_type . $req->time . $req->day . $req->cancel;
        $sms = SMS::query()->orderByDesc('control_id')->first();
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('request');
        $dom->appendChild($root);

        $result = $dom->createElement('head');
        $root->appendChild($result);

        $result->appendChild($dom->createElement('operation', 'submit'));
        $result->appendChild($dom->createElement('login', 'washing'));
        $result->appendChild($dom->createElement('password', 'w@shin2022!'));
        $result->appendChild($dom->createElement('controlid', "$sms->control_id"));
        $result->appendChild($dom->createElement('title', 'Washing'));
        $result->appendChild($dom->createElement('scheduled', date("Y-m-d H:i:s")));
        $result->appendChild($dom->createElement('isbulk', 'false'));

        $result = $dom->createElement('body');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('message', $message));
        $result->appendChild($dom->createElement('msisdn', $owner_tel));

        $xml = $dom->saveXML();

        $curl = curl_init("https://sms.atatexnologiya.az/bulksms/api");
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_RETURNTRANSFER => true
        ]);
        $result = curl_exec($curl);
        curl_close($curl);

        SMS::query()->insert(['control_id' => $sms->control_id + 1]);
    }

}
