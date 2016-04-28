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
        //public function test(Request $request){
        //    if(!is_null($request["id"])){
        //        return $request["id"];
        //    }

        //   return "sd";
        //}
        if($request->method() == "POST") {
            $this->serviceInterface = new ServiceInterface();
            $this->serviceInterface->request($request, $requestType);
            return $this->serviceInterface->response($requestType);
        } else{
            return response()->json(["method_http"=>"GET"]);
        }
    }
}
