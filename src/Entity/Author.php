<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\DataProvider\AuthorSuggestionsProvider;
use App\Dto\RefAuthorDto;
use App\Filter\AuthorListFilter;
use App\Filter\AuthorSuggestionFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/authors/suggestions',
            security: "is_granted('ROLE_ADMIN')",
            filters: [AuthorSuggestionFilter::class],
            output: RefAuthorDto::class,
            provider: AuthorSuggestionsProvider::class,
        ),
        new Get(security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            paginationMaximumItemsPerPage: 50,
            paginationClientItemsPerPage: true,
            security: "is_granted('ROLE_ADMIN')",
            filters:[AuthorListFilter::class]
        ),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
)]
#[ORM\Entity]
#[ORM\UniqueConstraint(
    name:'author_unique_idx',
    columns: ['first_name', 'middle_name', 'last_name']
)]
#[UniqueEntity(
    fields: [Author::PROP_FIRST_NAME, Author::PROP_MIDDLE_NAME, Author::PROP_LAST_NAME],
    message: 'Author with same fullname already exists',
    errorPath: Author::PROP_FIRST_NAME,
)]
class Author
{
    const PROP_ID = 'id';
    const PROP_FIRST_NAME = 'firstName';
    const PROP_MIDDLE_NAME = 'middleName';
    const PROP_LAST_NAME = 'lastName';

    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private string $id;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private string $firstName;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $middleName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private string $lastName;

    public function __construct()
    {
        $this->id = (string)Uuid::v4()->toRfc4122();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }


}