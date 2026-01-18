<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-products',
    description: 'Importe des produits depuis un fichier CSV (name, description, price).'
)]
class ImportProductCsvCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'file',
                InputArgument::OPTIONAL,
                'Chemin du CSV (relatif à la racine du projet ou absolu)',
                'public/products.csv'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = (string) $input->getArgument('file');

        if (!is_file($filePath)) {
            $io->error(sprintf('Fichier introuvable: %s', $filePath));
            return Command::FAILURE;
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $io->error('Impossible d’ouvrir le fichier.');
            return Command::FAILURE;
        }

        // Lecture en-tête
        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            $io->error('CSV vide ou illisible.');
            return Command::FAILURE;
        }

        // Normalisation header
        $header = array_map(fn($h) => strtolower(trim((string) $h)), $header);
        $expected = ['name', 'description', 'price'];

        foreach ($expected as $col) {
            if (!in_array($col, $header, true)) {
                fclose($handle);
                $io->error('CSV invalide : colonnes attendues: name, description, price.');
                return Command::FAILURE;
            }
        }

        $idxName = array_search('name', $header, true);
        $idxDesc = array_search('description', $header, true);
        $idxPrice = array_search('price', $header, true);

        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $name = trim((string) ($row[$idxName] ?? ''));
            $desc = trim((string) ($row[$idxDesc] ?? ''));
            $priceRaw = str_replace(',', '.', trim((string) ($row[$idxPrice] ?? '')));

            if ($name === '' || $desc === '' || $priceRaw === '' || !is_numeric($priceRaw)) {
                // Ligne invalide, on saute
                continue;
            }

            $product = new Product();
            $product->setName($name);
            $product->setDescription($desc);
            $product->setPrice((float) $priceRaw);

            $this->em->persist($product);
            $count++;

            // Flush par batch si gros fichier
            if ($count % 50 === 0) {
                $this->em->flush();
                $this->em->clear();
            }
        }

        fclose($handle);
        $this->em->flush();

        $io->success(sprintf('%d produits importés depuis %s', $count, $filePath));
        return Command::SUCCESS;
    }
}
