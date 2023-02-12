<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\FormBook;

class BookPutProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if($data instanceof FormBook) {

            $data->name .= ' Updated';

            return;
        }

        throw new \InvalidArgumentException('Wrong income data');
    }
}