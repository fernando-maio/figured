<?php

namespace App\Services;

use App\Contracts\Services\CsvInterface;

class CsvService implements CsvInterface
{
    /** This Path could be on .env file, but for this test I decided to include directly here. */
    const CSV_DATA_PATH = "app/public/data/inventory.csv";

    public function __construct()
    {
    }

    /** readCsv have a responsability of open, read, save the data in a variable and close the file.
     * It have a validation case the file not exits, returning false;
     */
    public static function readCsv(): array|bool
    {
        if (!file_exists(storage_path(self::CSV_DATA_PATH))) {
            return false;
        }

        // Open, Read and Close CSV file.
        $handle = fopen(storage_path(self::CSV_DATA_PATH), 'r');
        $inventory = array();
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            if (!empty($data)) {
                $inventory[] = $data;
            }
        }
        fclose($handle);
        array_shift($inventory);

        return $inventory;
    }
}
