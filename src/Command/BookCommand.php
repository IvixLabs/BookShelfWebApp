<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Book;
use App\Repository\BookRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BookCommand extends Command
{


    public function __construct(private BookRepositoryInterface $bookRepository)
    {
        parent::__construct('book');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return Command::SUCCESS;
    }


}