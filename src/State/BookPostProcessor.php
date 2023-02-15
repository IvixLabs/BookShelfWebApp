<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\FormBookDto;
use App\Entity\Book;
use App\Mapper\BookDtoMapper;
use App\Repository\BookRepositoryInterface;

class BookPostProcessor implements ProcessorInterface
{


    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private BookDtoMapper $bookDtoMapper
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if($data instanceof FormBookDto) {

            $book = new Book();

            $this->bookDtoMapper->initByFormBookDto($book, $data);
            $this->bookRepository->saveBook($book);

            $data->id = $book->getId();

            return $data;
        }

        throw new \InvalidArgumentException('Wrong income data');
    }
}