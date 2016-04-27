<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class VerificationResponseController
 * @package App\Http\Controllers\response
 */
class VerificationResponseController extends Controller
{
    /**
     * @var
     */
    private $userId;

    /**
     * @var
     */
    private $samePerson;

    /**
     * @var
     */
    private $code;

    /**
     * @var
     */
    private $message;

    /**
     * VerificationResponseController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getSamePerson()
    {
        return $this->samePerson;
    }

    /**
     * @param mixed $samePerson
     */
    public function setSamePerson($samePerson)
    {
        $this->samePerson = $samePerson;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
