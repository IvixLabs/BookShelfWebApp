<?php
declare(strict_types=1);

namespace App\Repository\Book;

class BookNotFoundException extends \RuntimeException
{

    static function byId(string $id): self
    {
        return new static('Book is not found by id:' . $id);
    }
}