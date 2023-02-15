<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RefAuthorDto
{
    public function __construct(
        #[Assert\NotBlank]
        public ?string $id = null,
        #[Assert\NotBlank]
        public ?string $name = null)
    {
    }
}