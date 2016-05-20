<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class ImageResultController
 * @package App\Http\Controllers\response
 */
class ImageResultController extends Controller
{
    /**
     * @var
     * @change private $internalId; for private $pictureId;
     */
    private $pictureId;
    /**
     * @var
     *
     */
    private $success;
    /**
     * @var
     * @change private $appCode; for private $errorCode
     */
    private $errorCode;
    /**
     * @var
     * @change private $message; for private $errorMessage;
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
     * @return mixed
     */
    public function getPictureId()
    {
        return $this->pictureId;
    }

    /**
     * @param mixed $pictureId
     */
    public function setPictureId($pictureId)
    {
        $this->pictureId = $pictureId;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param mixed $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }
    
    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }


    
}
