<?php

namespace App\Http\Requests;

use App\Services\Reservation\ReservationStatusConstans;
use App\Services\Room\RoomStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'room_id' => 'required|exists:App\Models\Room,id',
            'status' => ['required', Rule::in(ReservationStatusConstans::STATUSES)],
            'paid' => 'required|integer',
        ];
    }
}
