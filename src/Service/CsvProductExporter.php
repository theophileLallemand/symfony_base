<?php

namespace App\Service;

use App\Entity\Product;

class CsvProductExporter
{
    /**
     * @param Product[] $products
     */
    public function export(array $products): string
    {
        $handle = fopen('php://temp', 'r+');

        // On fixe explicitement la config CSV (PHP 8.4+)
        $separator = ',';
        $enclosure = '"';
        $escape = '\\';

        fputcsv($handle, ['name', 'description', 'price'], $separator, $enclosure, $escape);

        foreach ($products as $product) {
            fputcsv($handle, [
                $product->getName(),
                $product->getDescription(),
                $product->getPrice(),
            ], $separator, $enclosure, $escape);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv !== false ? $csv : '';
    }
}
