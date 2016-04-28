<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\response\FacilitatorIdController;
use App\Http\Controllers\response\ImageResultController;
use App\Http\Controllers\response\TrainingResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
#use App\Http\Controllers\request\ImageController;

/**
 * Class TrainingController
 * @package App\Http\Controllers\request
 */
class TrainingController extends Controller
{
    /**
     * @var array
     */
    private $imageSet = []; //Collection of images
    private $trainingResponse;

    //

    /**
     * TrainingController constructor.
     * @param $userId
     * @param $images
     * @param TrainingResponseController $response
     * @internal param $image
     */
    public function __construct($userId, $images, TrainingResponseController $response)
    {
        $response->addFacilitatorId(new FacilitatorIdController());
        $response->setUserId($userId);
        $this->trainingResponse = $response;

        // Create a collection of images trained

        $i = 0; $flag=true;
        foreach ($images as $key => $value) {
            
            // Instance training image
            $this->imageSet[$i] = new ImageController($userId, $value["base64_image"], new ImageResultController());
            // Verifies that only one person is thought throughout the process trained
            $this->imageSet[$i]->setInternalID($value["internal_id"]);
            if($i<1) {
                // If any error creating the person arises, the steps of detecting, add and train is avoided.
                if(!$this->imageSet[$i]->create()){
                    $flag = false;
                }
            }
            if($flag) {
                $this->imageSet[$i]->detect();
                $this->imageSet[$i]->add();
                $this->imageSet[$i]->train();
            }
            $i++;
        }
    }

    //Composition with Image in Class Diagram

    /**
     * @return ImageController
     */
    public function getImageSet()
    {
        return $this->imageSet;
    }

    /**
     * @return TrainingResponseController
     */

    public function getTrainingResponse()
    {
        return $this->trainingResponse;
    }
}
