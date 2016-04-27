<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class TrainingResponseController
 * @package App\Http\Controllers\response
 */
class TrainingResponseController extends Controller
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $success;

    /**
     * @var array
     */
    private $facilitatorId = [];

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
        $this->facilitatorId[] = $facilitatorId;
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
     * @return ImageResultController
     */
    public function getImageResult()
    {
        return $this->imageResult;
    }

    /**
     * @param array $imageResult
     */
    public function setImageResult($imageResult)
    {
        $this->imageResult = $imageResult;
    }

    /**
     * @return array
     */
    public function getFacilitatorId()
    {
        return $this->facilitatorId;
    }

    /**
     * @param array $facilitatorId
     */
    public function setFacilitatorId($facilitatorId)
    {
        $this->facilitatorId = $facilitatorId;
    }


}
