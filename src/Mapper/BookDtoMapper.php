<?php
declare(strict_types=1);

namespace App\Mapper;

use App\Dto\FormBookDto;
use App\Dto\ListBookDto;
use App\Entity\Book;
use App\Repository\AuthorRepositoryInterface;

class BookDtoMapper
{


    public function __construct(
        private AuthorRepositoryInterface $authorRepository,
        private AuthorDtoMapper           $authorDtoMapper,
    )
    {
    }

    public function getFormBookDto(Book $book): FormBookDto
    {
        $formBook = new FormBookDto();

        $formBook->id = $book->getId();
        $formBook->name = $book->getName();
        $formBook->description = $book->getDescription();
        $formBook->author = $this->authorDtoMapper->getRefAuthorDto($this->authorRepository->getAuthor($book->getAuthorId()));

        return $formBook;
    }

    public function initByFormBookDto(Book $book, FormBookDto $formBookDto)
    {

        $book->setName($formBookDto->name);
        $book->setDescription($formBookDto->description);
        $book->setAuthorId($formBookDto->author->id);
    }

    public function getListBookDto(Book $book): ListBookDto
    {
        return new ListBookDto(
            $book->getId(),
            $book->getName(),
            $this->authorDtoMapper->getRefAuthorDto($this->authorRepository->getAuthor($book->getAuthorId()))
        );
    }
}