<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PowerBiDataService;

class PowerBiDataControlller extends Controller
{
    public function __construct(
        private readonly PowerBiDataService $powerBiDataService
    ) {}

    public function __invoke()
    {
        return $this->powerBiDataService->getAllData();
    }
}
