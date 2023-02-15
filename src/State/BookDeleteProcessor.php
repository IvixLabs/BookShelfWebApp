<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\BookRepositoryInterface;

class BookDeleteProcessor implements ProcessorInterface
{

    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->bookRepository->removeBook($uriVariables['id']);
    }
}