<?php
declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Author;
use Doctrine\ORM\QueryBuilder;

class AuthorSuggestionFilter extends AbstractFilter
{

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {

        if ($property === 'search') {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $props = [Author::PROP_FIRST_NAME, Author::PROP_LAST_NAME];
            foreach ($props as $prop) {
                $parameterName = $queryNameGenerator->generateParameterName($prop);
                $queryBuilder
                    ->orWhere(sprintf('%s.%s LIKE :%s', $rootAlias, $prop, $parameterName))
                    ->setParameter($parameterName, "%" . $value . "%");
            }
        }

        $queryBuilder->setMaxResults(5);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'search' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
            ]
        ];
    }
}