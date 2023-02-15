<?php
declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Api\IdentifiersExtractorInterface;
use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Author;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class AuthorListFilter extends AbstractFilter
{

    private SearchFilter $searchFilter;

    public function __construct(
        ManagerRegistry               $managerRegistry,
        IriConverterInterface         $iriConverter,
        PropertyAccessorInterface     $propertyAccessor,
        LoggerInterface               $logger,
        IdentifiersExtractorInterface $identifiersExtractor,
        NameConverterInterface        $nameConverter = null
    )
    {
        parent::__construct($managerRegistry,$logger, null, $nameConverter);

        $this->searchFilter = new SearchFilter(
            $managerRegistry,
            $iriConverter,
            $propertyAccessor,
            $logger,
            [Author::PROP_FIRST_NAME => SearchFilter::STRATEGY_START],
            $identifiersExtractor,
            $nameConverter
        );
    }


    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->searchFilter->filterProperty($property, $value, $queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
    }

    public function getDescription(string $resourceClass): array
    {
        return $this->searchFilter->getDescription($resourceClass);
    }
}