<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class FacilitatorIdController
 * @package App\Http\Controllers\response
 */
class FacilitatorIdController extends Controller
{
    /**
     * @var
     */
    private $facId;
    /**
     * @var
     */
    private $facType;

    /**
     * FacilitatorIdController constructor.
     * @param $facId
     * @param $facType
     */
    public function __construct($facId = "696c3ecd355c03bf86ad029a68b931cd", $facType = "Facepp")
    {
        $this->facId = $facId;
        $this->facType = $facType;

    }

    /**
     * @return mixed
     */
    public function getFacId()
    {
        return $this->facId;
    }

    /**
     * @param mixed $facId
     */
    public function setFacId($facId)
    {
        $this->facId = $facId;
    }

    /**
     * @return mixed
     */
    public function getFacType()
    {
        return $this->facType;
    }

    /**
     * @param mixed $facType
     */
    public function setFacType($facType)
    {
        $this->facType = $facType;
    }

    
}
