<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\response\ImageResultController;
use App\Http\Controllers\response\VerificationResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


/**
 * This verifies a user with a unique identifier and an image of your face
 * Class VerificationController
 * @package App\Http\Controllers\request
 */
class VerificationController extends Controller
{
    /**
     * @var string Should contain the base64 image string
     */
    private $image;
    /**
     * @var ImageController Should contain the functions for authenticate an user
     */
    private $verificationResponse;

    /**
     * VerificationController constructor.
     * @param string $userId
     * @param string $image
     * @param VerificationResponseController $verificationResponse
     */
    public function __construct($userId, $image, VerificationResponseController $verificationResponse)
    {
        $this->verificationResponse = $verificationResponse; // Instance of verification response
        $this->image = new ImageController($userId,$image, new ImageResultController()); //Instance the functions for authenticate an user
        if($this->image->detect()){ // Detects a face in the image
            if($this->image->verify()){ // Verifies a face in the image
                if($this->image->add()) { // Add a face to the user Face++
                    $this->image->train(); // Finally train
                }
            }
        }
        // It fills the object verification response
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
    /**
     * @return VerificationResponseController
     */
    public function getVerificationResponse(){
        return $this->verificationResponse;
    }
}
