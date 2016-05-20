<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\response\ImageResultController;
use App\Http\Controllers\response\VerificationResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


/**
 * Class VerificationController
 * @package App\Http\Controllers\request
 */
class VerificationController extends Controller
{
    /**
     * @var ImageController
     */
    private $image;
    private $verificationResponse;

    /**
     * VerificationController constructor.
     * @param $userId
     * @param $image
     * @param VerificationResponseController $verificationResponse
     */
    public function __construct($userId, $image, VerificationResponseController $verificationResponse)
    {
        $this->verificationResponse = $verificationResponse;
        $this->image = new ImageController($userId,$image, new ImageResultController());
        if($this->image->detect()){
            if($this->image->verify()){
                if($this->image->add()) {
                    $this->image->train();
                }
            }
        }
        $this->verificationResponse->setSuccess($this->image->getResponse()->getSuccess());
        $this->verificationResponse->setErrorCode($this->image->getResponse()->getErrorCode());
        $this->verificationResponse->setErrorMessage($this->image->getResponse()->getErrorMessage());
    }

    /**
     * @return ImageController
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getVerificationResponse(){
        return $this->verificationResponse;
    }
}
