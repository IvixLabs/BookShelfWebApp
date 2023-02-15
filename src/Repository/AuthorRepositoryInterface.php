<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;

interface AuthorRepositoryInterface
{

    public function getAuthor(string $id): Author;
}