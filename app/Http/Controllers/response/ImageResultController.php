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
     */
    private $internalId;
    /**
     * @var
     */
    private $success;
    /**
     * @var
     */
    private $appCode;
    /**
     * @var
     */
    private $message;

    /**
     * ImageResultController constructor.
     * @param $internalId
     * @param $success
     * @param $appCode
     * @param $message
     */
    public function __construct($internalId="",$success="", $appCode="", $message="")
    {
        $this->internalId = $internalId;
        $this->success = $success;
        $this->appCode = $appCode;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getInternalId()
    {
        return $this->internalId;
    }

    /**
     * @param mixed $internalId
     */
    public function setInternalId($internalId)
    {
        $this->internalId = $internalId;
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

    /**
     * @return mixed
     */
    public function getAppCode()
    {
        return $this->appCode;
    }

    /**
     * @param mixed $appCode
     */
    public function setAppCode($appCode)
    {
        $this->appCode = $appCode;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    
}
