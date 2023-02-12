<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\DataProvider\BookDataProvider;
use App\DataProvider\BooksDataProvider;
use App\Dto\FormBook;
use App\Dto\UserBook;
use App\State\BookPostProcessor;
use App\State\BookPutProcessor;

#[ApiResource(
    operations: [
        new Get(output: UserBook::class, provider: BookDataProvider::class, security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            output: UserBook::class,
            provider: BooksDataProvider::class,
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Post(processor: BookPostProcessor::class, input: FormBook::class, security: "is_granted('ROLE_ADMIN')",),
        new Put(provider: BooksDataProvider::class, processor: BookPutProcessor::class, input: FormBook::class, security: "is_granted('ROLE_ADMIN')",),
    ]
)]
class Book
{
    private string $id;

    private string $name;

    private string $description;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->name = 'Mega name ' . $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}