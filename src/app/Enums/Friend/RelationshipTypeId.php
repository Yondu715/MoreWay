<?php

namespace App\Enums\Friend;

enum RelationshipTypeId: int
{
    case FRIEND = 1;
    case REQUEST = 2;
}