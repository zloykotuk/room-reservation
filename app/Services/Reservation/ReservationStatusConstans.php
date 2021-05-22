<?php


namespace App\Services\Reservation;


class ReservationStatusConstans
{
    const NEW = 'new';
    const CONFIRMED = 'confirmed';
    const ARRIVED = 'arrived';
    const CHECKOUT = 'checkout';

    const STATUSES = [
        self::NEW,
        self::CONFIRMED,
        self::ARRIVED,
        self::CHECKOUT,
    ];
}
