<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\DataProvider\BookDataProvider;
use App\DataProvider\BooksDataProvider;
use App\Dto\FormBookDto;
use App\Dto\ListBookDto;
use App\State\BookDeleteProcessor;
use App\State\BookPostProcessor;
use App\State\BookPutProcessor;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    operations: [
        new Get(output: ListBookDto::class, provider: BookDataProvider::class, security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            output: ListBookDto::class,
            provider: BooksDataProvider::class,
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Post(processor: BookPostProcessor::class, input: FormBookDto::class, security: "is_granted('ROLE_ADMIN')",),
        new Put(provider: BookDataProvider::class, processor: BookPutProcessor::class, input: FormBookDto::class, security: "is_granted('ROLE_ADMIN')",),
        new Delete(provider: BookDataProvider::class, processor: BookDeleteProcessor::class,  security: "is_granted('ROLE_ADMIN')")
    ]
)]
class Book
{
    private string $id;

    private string $name;

    private string $description;

    private string $authorId;

    public function __construct()
    {
        $this->id = (string)Uuid::v4()->toRfc4122();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function setAuthorId(string $authorId): void
    {
        $this->authorId = $authorId;
    }


}