<?php


namespace App\Services\Room;


class RoomStatusConstants
{
    const READY = 'Ready';
    const CLEANUP = 'Cleanup';
    const DIRTY = 'Dirty';

    const STATUSES = [
        self::READY,
        self::CLEANUP,
        self::DIRTY,
    ];
}
