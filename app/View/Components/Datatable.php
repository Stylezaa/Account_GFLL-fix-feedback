<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Route;
use Illuminate\View\Component;

class Datatable extends Component
{
    protected $data;
    protected $headers;
    protected $tableId;
    protected $displayKey;
    protected $deleteRoute;
    protected $editRoute;


    public function __construct(Collection $data, array $headers, string $tableId, array $displayKey, array $deleteRoute, array $editRoute)
    {
        $this->headers = $headers;
        $this->data = $data;
        $this->tableId = $tableId;
        $this->displayKey = $displayKey;
        $this->deleteRoute = $deleteRoute;
        $this->editRoute = $editRoute;
    }


    public function render()
    {
        return view('components.datatables-action', [
            'data' => $this->data,
            'headers' => $this->headers,
            'tableId' => $this->tableId,
            'displayKey' => $this->displayKey,
            'updateRoute' => $this->updateRoute,
            'editRoute' => $this->editRoute
        ]);
    }
}
