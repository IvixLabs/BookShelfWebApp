<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Author;
use App\Mapper\AuthorDtoMapper;

class AuthorSuggestionsProvider implements ProviderInterface
{


    public function __construct(
        private CollectionProvider $collectionProvider,
        private AuthorDtoMapper $authorDtoMapper
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $items = $this->collectionProvider->provide($operation, $uriVariables, $context);

        if ($items instanceof \Traversable) {
            $dtoItems = [];

            foreach ($items as $item) {
                if ($item instanceof Author) {
                    $dtoItems[] = $this->authorDtoMapper->getRefAuthorDto($item);
                }
            }

            return $dtoItems;
        }

        throw new \InvalidArgumentException();
    }


}