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
    /**
     * @var TrainingResponseController
     */
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
        $response->addFacilitatorId(new FacilitatorIdController($userId));
        $response->setUserId($userId);
        $this->trainingResponse = $response;

        // Create a collection of images trained

        $i = 0; $flag=true;
        foreach ($images as $key => $value) {
            
            // Instance training image
            $this->imageSet[$i] = new ImageController($userId,trim($value["base64"]), new ImageResultController());
            // Verifies that only one person is thought throughout the process trained
            $this->imageSet[$i]->setInternalID($value["pictureId"]);
            if($i<1) {
                // If any error creating the person arises, the steps of detecting, add and train is avoided.
                if(!$this->imageSet[$i]->create()){
                    $flag = false;
                }
            }
            if($flag) {
                if($this->imageSet[$i]->detect()) {
                    if($this->imageSet[$i]->add()){
                        $this->imageSet[$i]->train();
                    }
                }
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
