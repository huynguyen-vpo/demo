<?php

namespace App\Enums;

enum BookingStatus: int
{
    //
    case PENDING = 0;
    case BOOKING = 1;
    case CANCELLED = 2;
    case COMPLETED = 3;
}
