<?php

namespace App\Enums;

enum RoomType: int
{
    //
    case UNKNOWN = 0;
    case SINGLE = 1;
    case SINGLE_DOUBLE = 2;
    case TRIPLE = 3;
    case QUARTER = 4;
}
