<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\BookRepositoryInterface;

class BookService
{

    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function removeBooksByAuthorId(string $authorId)
    {

        $books = $this->bookRepository->getBooks();
        foreach ($books as $book) {
            if ($book->getAuthorId() === $authorId) {
                $this->bookRepository->removeBook($book->getId());
            }
        }

    }
}