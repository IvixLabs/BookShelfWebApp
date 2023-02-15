<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\FormBookDto;
use App\Dto\ListBookDto;
use App\Mapper\AuthorDtoMapper;
use App\Mapper\BookDtoMapper;
use App\Repository\AuthorRepositoryInterface;
use App\Repository\BookRepositoryInterface;

class BookDataProvider implements ProviderInterface
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private BookDtoMapper $bookDtoMapper,
    )
    {

    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $book = $this->bookRepository->getBook($uriVariables['id']);
        return $this->bookDtoMapper->getFormBookDto($book);
    }

}