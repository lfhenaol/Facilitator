<?php

namespace App\Http\Controllers\request;

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

    /**
     * VerificationController constructor.
     * @param $userId
     * @param $image
     */
    public function __construct($userId, $image)
    {
        $this->setImage(new ImageController($userId,$image));
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
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
