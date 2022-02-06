<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    private $maintenance;

    private $data;

    public function __construct(Maintenance $maintenance)
    {
        $this->maintenance = $maintenance;
    }

    public function check()
    {
        $status = 'off';
        $result = [];

        $data = Maintenance::all();

  

        return ['data' => 'asd'];
    }
}
