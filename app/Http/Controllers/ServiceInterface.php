<?php

namespace App\Http\Controllers;

use App\Http\Controllers\request\TrainingController;
use App\Http\Controllers\request\VerificationController;
use App\Http\Controllers\response\FacilitatorIdController;
use App\Http\Controllers\response\TrainingResponseController;
use App\Http\Controllers\response\VerificationResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Class ServiceInterface
 * @package App\Http\Controllers
 */
class ServiceInterface extends Controller
{
    /**
     * @var array
     * Trainings
     */
    private $training;

    /**
     * @var array
     * Verifications
     */
    private $verification;


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
     * Request for either training or verification
     *
     * @param Request $request
     * @param $requestType
     * @return Request
     */
    public function request(Request $request, $requestType)
    {
        if(strtolower($requestType) == "register")
        {
            $request = $request->json()->all();
           
            $this->addTraining(new TrainingController(uniqid() /*unique identifier for userId*/, $request["pictures"], new TrainingResponseController()));

        }
        else if (strtolower($requestType) == "login")
        {
            $request = $request->json()->all();
            $facId = trim($request["facilitatorIds"][0]["facId"]);
            $picture = trim($request["picture"]);

            $this->addVerification(new VerificationController($facId,$picture, new VerificationResponseController()));
        } else{
            abort("404");
        }

        return true;
    }


    /**
     *  Response after conducting training or verification
     *
     * @param $respondType
     * @return mixed
     */
    public function response($respondType)
    {
        // Development of JSON to respond to the result of training or verification
        if(strtolower($respondType) == "register")
        {
            $picturesResult = array();
            $success = true;

            // The results are returned in JSON format

            foreach ($this->getTraining()->getImageSet() as $value => $item){
                
                if($item->getResponse()->getSuccess() == "false"){
                    array_push($picturesResult,["pictureId"=>$item->getResponse()->getPictureId(),
                    "errorCode"=>$item->getResponse()->getErrorCode(),
                    "errorMessage"=>$item->getResponse()->getErrorMessage()]);
                    $success = false;
                }
            }

            if($success == true){
                array_push($picturesResult,["facId" => $this->getTraining()->getTrainingResponse()->getFacilitatorId()->getFacId(),
                    "facType"=>$this->getTraining()->getTrainingResponse()->getFacilitatorId()->getFacType()]);
            }

            $json =["success"=>$success, (($success)? "facilitatorIds":"errors") => $picturesResult];

            return response()->json($json);
        }
        else if (strtolower($respondType) == "login") {

            $success = $this->getVerification()->getVerificationResponse()->getSuccess();
            $pictureResult = array();
            $json = ["success"=>$success];

            if($success == "false" || $success == false){
                array_push($pictureResult,["errorCode"=>$this->getVerification()->getVerificationResponse()->getErrorCode(),
                "errorMessage"=>$this->getVerification()->getVerificationResponse()->getErrorMessage()]);
                $json = ["success"=>$success, "errors"=>$pictureResult];
            }

            return response()->json($json);
        }
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

    /**
     * @return  VerificationController
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * @param array $verification
     */
    public function setVerification($verification)
    {
        $this->verification = $verification;
    }
}
