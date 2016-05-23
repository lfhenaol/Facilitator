<?php

namespace App\Http\Controllers\response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Stores the answers given by the register then of be success
 * Class FacilitatorIdController
 * @package App\Http\Controllers\response
 */
class FacilitatorIdController extends Controller
{
    /**
     * @var string Unique identifier for an user
     */
    private $facId;
    /**
     * @var string The facial recognition service name, identifies the service
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
     * @return string
     */
    public function getFacId()
    {
        return $this->facId;
    }

    /**
     * @param string $facId
     */
    public function setFacId($facId)
    {
        $this->facId = $facId;
    }

    /**
     * @return string
     */
    public function getFacType()
    {
        return $this->facType;
    }

    /**
     * @param string $facType
     */
    public function setFacType($facType)
    {
        $this->facType = $facType;
    }

    
}
