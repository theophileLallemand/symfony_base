#[AsCommand(name: 'app:import-products')]
class ImportProductCsvCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = fopen('public/products.csv', 'r');
        fgetcsv($file);

        while ($row = fgetcsv($file)) {
            $product = new Product();
            $product->setName($row[0]);
            $product->setDescription($row[1]);
            $product->setPrice((float)$row[2]);

            $this->em->persist($product);
        }

        $this->em->flush();
        return Command::SUCCESS;
    }
}
