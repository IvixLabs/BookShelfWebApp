<?php
declare(strict_types=1);

namespace App\Dto;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class FormBook
{
    public string $id;

    #[Assert\NotBlank]
    public ?string $name = null;

    #[Assert\NotBlank]
    public ?string $description = null;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

}