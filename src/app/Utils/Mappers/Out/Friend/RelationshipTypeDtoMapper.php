<?php

namespace App\Utils\Mappers\Out\Friend;

use App\Application\DTO\Out\Friend\RelationshipTypeDto;
use App\Infrastructure\Database\Models\FriendRelationshipType;

class RelationshipTypeDtoMapper
{
    /**
     * @param FriendRelationshipType $friendRelationshipType
     * @return RelationshipTypeDto
     */
    public static function fromFriendRelationshipTypeModel(FriendRelationshipType $friendRelationshipType): RelationshipTypeDto
    {
        return new RelationshipTypeDto(
            $friendRelationshipType->id,
            $friendRelationshipType->name
        );
    }
}
