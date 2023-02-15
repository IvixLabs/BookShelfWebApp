<?php
declare(strict_types=1);

namespace App\Mapper;

use App\Dto\RefAuthorDto;
use App\Entity\Author;

class AuthorDtoMapper
{
    public function getRefAuthorDto(Author $author): RefAuthorDto
    {
        $fullName = $author->getFirstName() . ' ' . $author->getMiddleName() . ' ' . $author->getLastName();
        $fullName = preg_filter('/ +/', ' ', $fullName);

        return new RefAuthorDto($author->getId(), $fullName);
    }
}