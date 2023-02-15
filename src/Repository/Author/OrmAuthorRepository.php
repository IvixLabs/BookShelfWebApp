<?php
declare(strict_types=1);

namespace App\Repository\Author;

use App\Entity\Author;
use App\Repository\AuthorRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class OrmAuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(private ManagerRegistry $managerRegistry)
    {
    }

    public function getAuthor(string $id): Author
    {
        $manager = $this->managerRegistry->getManagerForClass(Author::class);
        $repo = $manager->getRepository(Author::class);

        $author = $repo->find($id);

        if ($author === null) {
            throw AuthorNotFoundException::byId($id);
        }

        return $author;
    }


}