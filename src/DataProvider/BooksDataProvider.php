<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Dto\UserBook;
use App\Entity\Book;

class BooksDataProvider implements ProviderInterface
{

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Put) {
            return ['her'=>'bla'];//new Book('abc');//$uriVariables['id']);
        }


        $page = $context['filters']['page'];
        $first = $page * 2;
        $items = [];
        for ($i = $first; $i < $page * 2 + 2; $i++) {
            $items[] = new UserBook((string)$i, 'Hello from user book ' . $i);
        }

        return new TraversablePaginator(new \ArrayObject($items), (float)$page, 2, 10);
    }

}