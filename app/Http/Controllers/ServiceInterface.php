<?php

namespace App\Http\Controllers;

use App\Http\Controllers\request\TrainingController;
use App\Http\Controllers\request\VerificationController;
use App\Http\Controllers\response\ResponseController;
use App\Http\Controllers\response\TrainingResponseController;
use App\Http\Controllers\response\VerificationResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;

class ServiceInterface extends Controller
{
    /**
     * @var array
     * Collection of trainings
     */
    private $training;

    /**
     * @var array
     * Collection of verifications
     */
    private $verification;

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
        $this->training = $data;
    }

    /**
     * @param VerificationController $data
     */
    public function addVerification(VerificationController $data){
        $this->verification = $data;
    }

    /**
     * @param Request $request
     * @param $requestType
     * @return Request
     */
    public function request(Request $request, $requestType)
    {
        if(strtolower($requestType) == "train")
        {
            $request = $request->json()->all();
            $this->addTraining(new TrainingController($request["UserId"], $request["images"], new TrainingResponseController()));
            #var_dump($this->getTraining()->getImageSet());
        }
        else if (strtolower($requestType) == "verify")
        {
            $request = $request->json()->all();
            var_dump($request);
            foreach ($request["image"] as $array => $image) {
                $this->addVerification(new VerificationController($request["UserId"], $image, new VerificationResponseController()));
            }
        }

        return true;
    }

    /**
     * @param $respondType
     * @return ResponseController
     */
    public function response($respondType)
    {
        if(strtolower($respondType) == "train")
        {
            return var_dump($this->getTraining()->getImageSet()[0]);
        }
        else if (strtolower($respondType) == "verify") {
        }

        return "";
    }

    /**
     * @return TrainingController
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
