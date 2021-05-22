<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationChangeDate;
use App\Http\Requests\ReservationCreate;
use App\Http\Requests\ReservationUpdate;
use App\Models\Reservation;
use App\Models\Room;
use App\Services\Reservation\ReservationStatusConstans;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $reservations = Reservation::whereMonth('start', '=', (int)date('m'))
            ->whereMonth('end', '=', (int)date('m'))
            ->get();
        $reservations = $reservations->each(function($item, $key){
            $item->text = $item->name;
            $item->resource = $item->room_id;
            $item->text = $item->name;
            $item->bubbleHtml = "Reservation details: ".$item->text;
        });
        $reservations->forget('name', 'room_id', 'name');
        return response()->json($reservations);
    }

    public function create(Request $request)
    {
        return view('new_reservation', [
            'name' => '',
            'start' => date('Y-m-d H:i:s', strtotime($request->start)),
            'end' => date('Y-m-d H:i:s', strtotime($request->end)),
            'resource' => $request->resource,
            'isEdit' => false,
            'rooms' => Room::all()
        ]);
    }

    public function store(ReservationCreate $request)
    {
        $data = $request->toArray();
        $data['paid'] = 0;
        $data['status'] = ReservationStatusConstans::NEW;
        return response()->json(Reservation::create($data));
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('new_reservation', [
            'name' => $reservation->name,
            'start' => $reservation->start,
            'end' => $reservation->end,
            'resource' => $reservation->room_id,
            'reservation' => $reservation,
            'isEdit' => true,
            'rooms' => Room::all()
        ]);
    }

    public function update(ReservationUpdate $request, int $id)
    {
        return Reservation::find($id)->update($request->toArray());
    }

    public function changeDate(ReservationChangeDate $request, $id)
    {
        $newStart = date('Y-m-d H:i:s', strtotime($request->newStart));
        $newEnd = date('Y-m-d H:i:s', strtotime($request->newEnd));
        $reservation = Reservation::where('end', '<=', $newStart)
                                  ->orWhere('start', '>=', $newEnd)
                                  ->where('id', $id)
                                  ->where('room_id', $request->newResource)
                                  ->get();

        if (!$reservation->isEmpty()) {
            return response([
                'result' => 'Error',
                'message' => 'This reservation overlaps with an existing reservation.'
            ]);
        }

        $reservation = Reservation::find($id);
        $reservation->update([
            'start' => $newStart,
            'end' => $newEnd,
            'room_id' => $request->newResource
        ]);

        return response([
            'result' => 'OK',
            'message' => 'Update successful'
        ]);
    }

    public function delete($id)
    {
        Reservation::find($id)->delete();
        return response([
            'result' => 'OK',
            'message' => 'Delete successful'
        ]);
    }
}
