<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Class Facilitator
 * @package App\Http\Controllers
 */
class Facilitator extends Controller
{
    /**
     * @var ServiceInterface
     */
    public $serviceInterface;

    /**
     *  The facilitator is responsible for receiving requests that require training images for later
     *  recognition, besides this responds to such requests, depending on whether training or verification.
     *
     * @param Request $request
     * @param $requestType
     * @return Response
     */
    public function Facilitator(Request $request, $requestType)
    {
        if($request->method() == "POST") {
            $this->serviceInterface = new ServiceInterface();
            $this->serviceInterface->request($request, $requestType);
            return $this->serviceInterface->response($requestType);
        } else{
            if (strtolower($requestType) == "login" or strtolower($requestType) == "register") {
                return response()->json(["method_http" => "GET"]);
            } else {
                abort("404");
            }
        }
    }
}
