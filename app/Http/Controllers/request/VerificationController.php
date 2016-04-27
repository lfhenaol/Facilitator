<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\response\ImageResultController;
use App\Http\Controllers\response\VerificationResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

#use App\Http\Controllers\FaceppController;

/**
 * Class VerificationController
 * @package App\Http\Controllers\request
 */
class VerificationController extends Controller
{
    /**
     * @var
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
        $this->setImage(new ImageController($userId,$image, new ImageResultController()));
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getVerificationResponse(){
        
    }

    /**
     * @param ImageController $image
     */
    public function setImage(ImageController $image)
    {
        $image->detect();
        $image->verify();
        $image->add();
        $image->train();
        $this->image = $image;
    }
}
