<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class ResponseController
 * @package App\Http\Controllers\response
 */
class ResponseController extends Controller
{
    /**
     * @var array
     */
    private $trainingResponse = [];
    /**
     * @var array
     */
    private $verificationResponse = [];

    /**
     * ResponseController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param TrainingResponseController $trainingResponse
     */
    public function addTrainingResponse(TrainingResponseController $trainingResponse){
        $this->trainingResponse[] = $trainingResponse;
    }

    /**
     * @param VerificationResponseController $verificationResponse
     */
    public function addVerificationResponse(VerificationResponseController $verificationResponse){
        $this->verificationResponse[] = $verificationResponse;
    }

    /**
     *
     */
    public function send(){

    }

    /**
     * @return array
     */
    public function getTrainingResponse()
    {
        return $this->trainingResponse;
    }

    /**
     * @param array $trainingResponse
     */
    public function setTrainingResponse($trainingResponse)
    {
        $this->trainingResponse = $trainingResponse;
    }

    /**
     * @return array
     */
    public function getVerificationResponse()
    {
        return $this->verificationResponse;
    }

    /**
     * @param array $verificationResponse
     */
    public function setVerificationResponse($verificationResponse)
    {
        $this->verificationResponse = $verificationResponse;
    }

}
