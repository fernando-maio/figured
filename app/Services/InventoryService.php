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

    public function calculateApplication(int $quantity): string|bool
    {
        $inventory = $this->cleanInventory();

        if (!self::checkInventoryQuantity($inventory, $quantity)) {
            return false;
        }

        $amount = $this->getAmount($inventory, $quantity);
        $fmt = new NumberFormatter( 'en_NZ', NumberFormatter::CURRENCY );

        return $fmt->formatCurrency($amount, "NZD");
    }

    private function cleanInventory(): array|bool
    {
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
