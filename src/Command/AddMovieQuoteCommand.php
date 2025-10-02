<?php

namespace App\Command;

use App\Entity\Quote;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'addMovieQuote',
    description: 'adding a movie quote',
)]
class AddMovieQuoteCommand extends Command
{
    public function __construct(protected EntityManagerInterface $entityManager, protected MovieRepository $movieRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('movie_id', InputArgument::OPTIONAL, 'The Movie ID')
            ->addArgument('quote_name', InputArgument::OPTIONAL, 'The Quote name')
            ->addArgument('quote_msg', InputArgument::OPTIONAL, 'The Quote message')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('movie_id');
        $arg2 = $input->getArgument('quote_name');
        $arg3 = $input->getArgument('quote_msg');

        if (!$arg1 || !$arg2 || !$arg3) $io->error('Missing arguments!');

        $movie = $this->movieRepository->findOneBy(['id' => $arg1]);

        $newQuote = new Quote();
        $newQuote->setName($arg2);
        $newQuote->setMsg($arg3);
        $newQuote->setMovieRelation($movie);

        $this->entityManager->persist($newQuote);
        $this->entityManager->flush();

        $io->success('You have know created a quote!');

        return Command::SUCCESS;
    }
}
