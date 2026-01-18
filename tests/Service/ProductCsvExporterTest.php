<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\ProductCsvExporter;
use PHPUnit\Framework\TestCase;

class ProductCsvExporterTest extends TestCase
{
    public function testExportCsvGeneratesCorrectRows(): void
    {
        $p1 = (new Product())
            ->setName('Produit A')
            ->setDescription('Desc A')
            ->setPrice(10.5);

        $p2 = (new Product())
            ->setName('Produit B')
            ->setDescription('Desc B')
            ->setPrice(20);

        $exporter = new ProductCsvExporter();
        $csv = $exporter->export([$p1, $p2]);

        // Normalise retours ligne (Windows/Linux)
        $csv = str_replace("\r\n", "\n", $csv);
        $lines = array_values(array_filter(explode("\n", trim($csv))));

        // 1 ligne header + 2 produits
        $this->assertCount(3, $lines);

        // Paramètres CSV explicites (PHP 8.4+ : évite les deprecations)
        $separator = ',';
        $enclosure = '"';
        $escape = '\\';

        // Parse chaque ligne CSV
        $header = str_getcsv($lines[0], $separator, $enclosure, $escape);
        $row1   = str_getcsv($lines[1], $separator, $enclosure, $escape);
        $row2   = str_getcsv($lines[2], $separator, $enclosure, $escape);

        $this->assertSame(['name', 'description', 'price'], $header);
        $this->assertSame(['Produit A', 'Desc A', '10.5'], $row1);
        $this->assertSame(['Produit B', 'Desc B', '20'], $row2);
    }
}
