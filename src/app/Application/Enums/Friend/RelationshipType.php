<?php

namespace App\Application\Enums\Friend;

enum RelationshipType: int
{
    case FRIEND = 1;
    case REQUEST = 2;
}
