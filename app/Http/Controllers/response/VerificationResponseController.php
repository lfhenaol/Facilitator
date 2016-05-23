<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Stores the answers given by the authentication
 * Class VerificationResponseController
 * @package App\Http\Controllers\response
 */
class VerificationResponseController extends Controller
{

    /**
     * @var boolean It must contain the success or failure of authentication
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
     * VerificationResponseController constructor.
     */
    public function __construct()
    {

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


}
