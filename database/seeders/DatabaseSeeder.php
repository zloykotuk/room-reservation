<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Services\Reservation\ReservationStatusConstans;
use App\Services\Room\RoomStatusConstants;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 5) as $key) {
            Room::create([
               'name' => 'Room ' . $key,
               'capacity' => rand(2, 4),
               'status' => RoomStatusConstants::STATUSES[array_rand(RoomStatusConstants::STATUSES)]
            ]);
        }

        foreach (range(1, 7) as $key) {
            $rand = rand(10, 21);
            Reservation::create([
                'name' => 'Reservation ' . $key,
                'start' => Carbon::create((int)date('Y'), (int)date('m'), $rand),
                'end' => Carbon::create((int)date('Y'), (int)date('m'), $rand + $key),
                'room_id' => rand(1, 5),
                'status' => match(true) {
                    $rand < (((int) date('d')) - 3)  => ReservationStatusConstans::ARRIVED,
                    $rand < (int) date('d')  => ReservationStatusConstans::CONFIRMED,
                    $rand === (int) date('d') => ReservationStatusConstans::CHECKOUT,
                    $rand > (int) date('d') => ReservationStatusConstans::NEW,
                },
                'paid' => rand(0, 100)
            ]);
        }
    }
}
