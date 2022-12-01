<?php

namespace App\Services;

use App\Contracts\Services\CsvInterface;
use App\Contracts\Services\InventoryInterface;
use NumberFormatter;

class InventoryService implements InventoryInterface
{
    /** @var CsvService $csvService */
    private $csvService;

    public function __construct(CsvInterface $csvInterface)
    {
        $this->csvService = $csvInterface;
    }

    /** Main function of InventoryService */
    public function calculateApplication(int $quantity): string|bool
    {
        /** First of all, I made a cleanning of the inventory, removing all lines that was already consumed from the CSV file. */
        $inventory = $this->cleanInventory();

        /** Check if the Inventory have enought itens to be requested. Case the user request more than total, retun as false. */
        if (!self::checkInventoryQuantity($inventory, $quantity)) {
            return false;
        }

        /** Here we calculate the ammount, according itens consumed by utem and their respective values. */
        $amount = $this->getAmount($inventory, $quantity);
        $fmt = new NumberFormatter( 'en_NZ', NumberFormatter::CURRENCY );

        /** And then, we return a converted ammount as string format. ($123.45) */
        return $fmt->formatCurrency($amount, "NZD");
    }

    private function cleanInventory(): array|bool
    {
        /** This method verify all Applycations, consuming oldest inventory first */
        $inventory = $this->checkApplyedDataFile();

        foreach ($inventory as $key => $value) {
            if (empty($value[2])) {
                unset($inventory[$key]);
            }
        }

        return array_values($inventory);
    }

    private static function checkInventoryQuantity(array $inventory, int $quantity): bool
    {
        $count = array_sum(array_column($inventory, 2));

        return (($count - $quantity) >= 0);
    }

    private function checkApplyedDataFile(): array|bool
    {
        $inventory = $this->csvService::readCsv();

        foreach ($inventory as $key => $value) {
            if ($value[1] == "Application") {
                for ($i = 0; $i < $key; $i++) {
                    if (empty($inventory[$i])) {
                        continue;
                    }

                    if ($inventory[$i][2] == 0) {
                        continue;
                    }

                    $quantity = abs($inventory[$key][2]);
                    $rest = $quantity - intval($inventory[$i][2]);

                    if ($rest >= 0) {
                        $inventory[$i][2] = 0;
                        $inventory[$key][2] = $rest;
                    } else {
                        $inventory[$i][2] = abs($rest);
                        $inventory[$key][2] = 0;
                    }
                }
            }
        }

        return $inventory;
    }

    private function getAmount(array $inventory, int $quantity): float
    {
        $amount = 0;
        foreach ($inventory as $key => $value) {
            $rest = $quantity - intval($value[2]);

            if ($rest >= 0) {
                $inventory[$key][2] = 0;
                $amount = $amount + ($value[2] * $value[3]);
                $quantity = $rest;
            } else {
                $inventory[$key][2] = abs($rest);
                $amount = $amount + ($quantity * $value[3]);
                break;
            }
        }

        return $amount;
    }
}
