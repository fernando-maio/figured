<?php

namespace Tests\Unit;

use App\Services\CsvService;
use App\Services\InventoryService;
use Tests\TestCase;

class ApplicationRequestFailTest extends TestCase
{
    /**
     * ### For this test, I'm considering the CSV file provided for my data. 
     * ### Dynamic data is not being considered.
     * 
     * For this test, I used fake values as expected values to return a error message.
     *
     * @return void
     */
    public function testReturnValueExpectedSuccess()
    {
        $csv = new CsvService();
        $inventoryService = new InventoryService($csv);
        $result = $inventoryService->calculateApplication(42);

        $this->assertNotEquals($result, '$420.00');
    }
}
