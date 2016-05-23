<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Stores the answers given by the register then of to fail
 * Class ImageResultController
 * @package App\Http\Controllers\response
 */
class ImageResultController extends Controller
{
    /**
     * @var int Should contain the image identification
     */
    private $pictureId;
    /**
     * @var boolean Should contain the success or failure of register an image
     */
    private $success;
    /**
     * @var int Should contain a error code
     */
    private $errorCode;
    /**
     * @var string Should contain a error message
     */
    private $errorMessage;

    /**
     * ImageResultController constructor.
     * @param string $pictureId
     * @param string $errorCode
     * @param string $errorMessage
     * @param string $success
     */
    public function __construct($pictureId="", $errorCode="", $errorMessage="", $success="")
    {
        $this->pictureId = $pictureId;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        $this->success = $success;
    }

    /**
     * @return int
     */
    public function getPictureId()
    {
        return $this->pictureId;
    }

    /**
     * @param int $pictureId
     */
    public function setPictureId($pictureId)
    {
        $this->pictureId = $pictureId;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }
    
    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }


    
}
