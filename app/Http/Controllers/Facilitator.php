<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Facilitator extends Controller
{
    /**
     * @var ServiceInterface
     */
    public $serviceInterface;

    public function Facilitator(Request $request, $requestType)
    {
        $this->serviceInterface = new ServiceInterface();
        $this->serviceInterface->request($request, $requestType);
        $this->serviceInterface->response($requestType);
    }
}
