<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomCreate;
use App\Models\Room;
use App\Services\Room\RoomStatusConstants;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $rooms = ((int)$request->capacity === 0) ? Room::all() :
            Room::where('capacity', $request->capacity)->get();
        return response()->json($rooms);
    }

    public function create()
    {
        return view('new_room');
    }

    public function store(RoomCreate $request)
    {
        $data = $request->toArray();
        $data['status'] = RoomStatusConstants::READY;
        $room = Room::create($data);
        return response([
            'result' => 'OK',
            'message ' => 'Created with id: '.$room->id
        ]);
    }
}
