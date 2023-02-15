<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Dto\ListBookDto;
use App\Mapper\BookDtoMapper;
use App\Repository\BookRepositoryInterface;

class BooksDataProvider implements ProviderInterface
{

    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private BookDtoMapper $bookDtoMapper
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $books = $this->bookRepository->getBooks();
        $totalItems = count($books);
        $itemsPerPage = 2;

        $page = $context['filters']['page'];
        $first = $page * $itemsPerPage;
        $items = [];

        $i = 0;
        foreach ($books as $book) {
            if($i>= $first && $i < $totalItems) {
                $items[] = $this->bookDtoMapper->getListBookDto($book);
            }
            $i++;
        }

        return new TraversablePaginator(new \ArrayObject($items), (float)$page, $totalItems, $totalItems);
    }

}