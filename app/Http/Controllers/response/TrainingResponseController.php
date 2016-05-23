<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Stores the answers given by the register then of be success
 * Class TrainingResponseController
 * @package App\Http\Controllers\response
 */
class TrainingResponseController extends Controller
{
    /**
     * @var string Should contain a unique identifier for a user
     */
    private $userId;
    /**
     * @var boolean It must contain the success or failure of register an image
     */
    private $success;

    /**
     * @var FacilitatorIdController Should contain the answer given by the register then of be success
     */
    private $facilitatorId;

    /**
     * TrainingResponseController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param FacilitatorIdController $facilitatorId
     */
    public function addFacilitatorId(FacilitatorIdController $facilitatorId){
        $this->facilitatorId = $facilitatorId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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
     * @return FacilitatorIdController
     */
    public function getFacilitatorId()
    {
        return $this->facilitatorId;
    }
}
