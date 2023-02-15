<?php
declare(strict_types=1);

namespace App\Repository\Author;

class AuthorNotFoundException extends \RuntimeException
{
    static function byId(string $id): self
    {
        return new static('Author is not found by id:' . $id);
    }
}