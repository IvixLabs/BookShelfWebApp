<?php
declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Author;
use App\Service\BookService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: Author::class)]
class AuthorChangedEntityListener
{
    public function __construct(private BookService $bookService)
    {
    }

    public function postRemove(Author $author)
    {
        $this->bookService->removeBooksByAuthorId($author->getId());
    }
}