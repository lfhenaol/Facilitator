<?php

namespace App\Http\Controllers\request;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
##use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


/**
 * Class RequestController
 * @package App\Http\Controllers\request
 */
class RequestController extends Controller
{
    /**
     * @var array
     * Collection of trainings
     */
    private $training = [];

    /**
     * @var array
     * Collection of verifications
     */
    private $verification = [];

    //public function test(Request $request){
    //    if(!is_null($request["id"])){
    //        return $request["id"];
    //    }

    //   return "sd";
    //}

    /**
     * RequestController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param TrainingController $data
     */
    public function addTraining(TrainingController $data){
        $this->training[] = $data;
    }

    /**
     * @param VerificationController $data
     */
    public function addVerification(VerificationController $data){
        $this->verification[] = $data;
    }

    /**
     * @param Request $request
     * @return Request
     * @internal param $requestType
     */
    public function receive(Request $request, $requestType)
    {
        if(strtolower($requestType) == "train")
        {
            $request = $request->json()->all();
            $this->addTraining(new TrainingController($request["UserId"], $request["images"]));
        }
        else if (strtolower($requestType) == "verify")
        {
            $request = $request->json()->all();
            var_dump($request);
            foreach ($request["image"] as $array => $image) {
                $this->addVerification(new VerificationController($request["UserId"], $image));
            }
        }

        return "";
    }

    /**
     * @return JsonResponse
     */
    public function respond()
    {

    }

    /**
     * @return array
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @param array $training
     */
    public function setTraining($training)
    {
        $this->training = $training;
    }


}
