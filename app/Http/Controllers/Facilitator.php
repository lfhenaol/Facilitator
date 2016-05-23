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
     *  recognition, besides this responds to such requests, depending on whether register or authentication(login).
     *
     * @param Request $request
     * @param $requestType
     * @return Response
     */
    public function Facilitator(Request $request, $requestType)
    {
        if($request->method() == "POST") { // Method http POST
            $this->serviceInterface = new ServiceInterface(); //launch the service interface
            $this->serviceInterface->request($request, $requestType); // request
            return $this->serviceInterface->response($requestType); //response
        } else{
            if (strtolower($requestType) == "login" or strtolower($requestType) == "register") { //ignore, only method http GET
                return response()->json(["method_http" => "GET"]);
            } else {
                abort("404");
            }
        }
    }
}
