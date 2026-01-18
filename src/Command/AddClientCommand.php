<?php

namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:add-client',
    description: 'Ajoute un client via la ligne de commande'
)]
class AddClientCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $firstname = $helper->ask($input, $output, new Question('Prénom : '));
        $lastname = $helper->ask($input, $output, new Question('Nom : '));
        $email = $helper->ask($input, $output, new Question('Email : '));
        $phone = $helper->ask($input, $output, new Question('Téléphone : '));
        $address = $helper->ask($input, $output, new Question('Adresse : '));

        $client = new Client();
        $client->setFirstname($firstname);
        $client->setLastname($lastname);
        $client->setEmail($email);
        $client->setPhoneNumber($phone);
        $client->setAddress($address);
        $client->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($client);
        $this->em->flush();

        $output->writeln('<info>Client ajouté avec succès</info>');
        return Command::SUCCESS;
    }
}
