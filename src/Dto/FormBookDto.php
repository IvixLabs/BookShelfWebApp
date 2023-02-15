<?php
declare(strict_types=1);

namespace App\Dto;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class FormBookDto
{
    public ?string $id = null;

    #[Assert\NotBlank]
    public ?string $name = null;

    #[Assert\NotBlank]
    public ?string $description = null;

    #[Assert\NotBlank]
    public ?RefAuthorDto $author = null;
}