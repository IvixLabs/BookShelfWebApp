<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;

interface BookRepositoryInterface
{

    public function saveBook(Book $book);

    public function getBook(string $id): Book;

    public function removeBook(string $id);

    /**
     * @return Book[]
     */
    public function getBooks(): array;
}