<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\UserBook;

class BookDataProvider implements ProviderInterface
{

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return new UserBook(''.$uriVariables['id'], 'Hello from user book ' . $uriVariables['id']);
    }

}