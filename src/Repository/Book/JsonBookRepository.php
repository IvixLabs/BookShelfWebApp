<?php
declare(strict_types=1);

namespace App\Repository\Book;

use App\Entity\Book;
use App\Repository\BookRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

class JsonBookRepository implements BookRepositoryInterface
{

    private $jsonFilePath;

    /**
     * @var Book[]
     */
    private ?array $books = null;

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, $booksJsonFilePath)
    {
        $this->serializer = $serializer;
        $this->jsonFilePath = $booksJsonFilePath;

    }

    /**
     * @inheritdoc
     */
    public function getBooks(): array
    {
        if ($this->books === null) {
            $this->books = $this->loadBooks();
        }

        return $this->books;
    }

    private function setBooks(array $books)
    {
        $this->books = $books;
    }

    private function flushBooks()
    {
        $strings = [];
        foreach ($this->books as $id => $book) {
            $strings[$id] = $this->serializer->serialize($book, 'json');
        }

        file_put_contents($this->jsonFilePath, serialize($strings));
    }

    private function loadBooks()
    {
        $books = [];
        if (file_exists($this->jsonFilePath)) {
            $strings = unserialize(file_get_contents($this->jsonFilePath));
            foreach ($strings as $id => $string) {
                $books[$id] = $this->serializer->deserialize($string, Book::class, 'json');
            }
        }
        return $books;
    }

    public function saveBook(Book $book)
    {
        $books = $this->getBooks();
        $books[$book->getId()] = $book;
        $this->setBooks($books);
        $this->flushBooks();
    }

    public function getBook(string $id): Book
    {
        $books = $this->getBooks();
        if (!isset($books[$id])) {
            throw BookNotFoundException::byId($id);
        }

        return $books[$id];

    }

    public function removeBook(string $id)
    {
        $books = $this->getBooks();
        if (isset($books[$id])) {
            unset($books[$id]);
            $this->setBooks($books);
            $this->flushBooks();
        }
    }
}