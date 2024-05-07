<?php

namespace App\Enums;

enum GroupStatus: int
{
    //
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BANNED = 2;
}
