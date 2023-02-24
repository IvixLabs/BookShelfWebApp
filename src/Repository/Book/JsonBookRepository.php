<?php
declare(strict_types=1);

namespace App\Repository\Book;

use App\Entity\Book;
use App\Repository\BookRepositoryInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use Symfony\Component\Serializer\SerializerInterface;

class JsonBookRepository implements BookRepositoryInterface
{
    private ?LockInterface $lock = null;

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly string              $booksJsonFilePath,
        private readonly LockFactory         $lockFactory
    )
    {
    }

    private function lock()
    {
        if (!$this->lock) {
            $this->lock = $this->lockFactory->createLock('books.db');
        }

        $this->lock->acquire(true);
    }

    private function unlock()
    {
        if (!$this->lock) {
            throw new \RuntimeException('Lock is null');
        }

        $this->lock->release();
    }

    /**
     * @inheritdoc
     */
    public function getBooks(): array
    {
        $this->lock();

        try {
            return $this->loadBooks();
        } finally {
            $this->unlock();
        }

    }

    private function flushBooks(array $books)
    {
        $strings = [];
        foreach ($books as $id => $book) {
            $strings[$id] = $this->serializer->serialize($book, 'json');
        }

        file_put_contents($this->booksJsonFilePath, serialize($strings));
    }

    private function loadBooks(): array
    {
        $books = [];
        if (file_exists($this->booksJsonFilePath)) {
            $strings = unserialize(file_get_contents($this->booksJsonFilePath));
            foreach ($strings as $id => $string) {
                $books[$id] = $this->serializer->deserialize($string, Book::class, 'json');
            }
        }
        return $books;
    }

    public function saveBook(Book $book)
    {
        $this->lock();

        try {
            $books = $this->loadBooks();
            $books[$book->getId()] = $book;
            $this->flushBooks($books);
        } finally {
            $this->unlock();
        }
    }

    public function getBook(string $id): Book
    {
        $this->lock();

        try {
            $books = $this->loadBooks();
            if (!isset($books[$id])) {
                throw BookNotFoundException::byId($id);
            }

            return $books[$id];
        } finally {
            $this->unlock();
        }

    }

    public function removeBook(string $id)
    {
        $this->lock();
        try {
            $books = $this->loadBooks();
            if (isset($books[$id])) {
                unset($books[$id]);
                $this->flushBooks($books);
            }
        } finally {
            $this->unlock();
        }
    }
}