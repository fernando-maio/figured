<?php

namespace App\Http\Controllers;

use App\Contracts\Services\InventoryInterface;
use App\Http\Requests\InventoryRequest;
use App\Services\InventoryService;

class InventoryController extends Controller
{
    /** @var InventoryService $inventoryService */
    private $inventoryService;

    /**
     * Dependency inversion using the interface.
     * 
     * @param InventoryInterface $inventoryInterface
     */
    public function __construct(InventoryInterface $inventoryInterface)
    {
        $this->inventoryService = $inventoryInterface;
    }

    /** Returning a view index.php*/
    public function index()
    {
        return view('index');
    }

    public function apply(InventoryRequest $request)
    {
        $inventory = $this->inventoryService->calculateApplication($request->input_apply);

        if (!$inventory) {
            return redirect()
                ->route('index')
                ->withErrors('Sorry, there is no stock to cover the requested amount. Check the value and try again.');
        }

        return view('index', array('inventory' => $inventory));
    }
}
