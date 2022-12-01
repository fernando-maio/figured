<?php

namespace Tests\Unit;

use App\Services\CsvService;
use App\Services\InventoryService;
use Tests\TestCase;

class ApplicationRequestSuccessTest extends TestCase
{
    /**
     * ### For this test, I'm considering the CSV file provided for my data. 
     * ### Dynamic data is not being considered.
     * 
     * This test verify if the requested application return the expected values or false, 
     *  case the total requested is higher than current inventory.
     *
     * @return void
     */
    public function testReturnValueExpectedSuccess()
    {
        $csv = new CsvService();
        $inventoryService = new InventoryService($csv);

        /** Multiple use cases to use multiply by different values */
        $applicationRequests = array(
            array("input" => 10, "expected" => '$42.00'),
            array("input" => 20, "expected" => '$89.60'),
            array("input" => 42, "expected" => '$204.60'),
            array("input" => 60, "expected" => false)
        );

        foreach ($applicationRequests as $requested) {
            $result = $inventoryService->calculateApplication($requested["input"]);
            $this->assertEquals($result, $requested["expected"]);
        }
    }
}
