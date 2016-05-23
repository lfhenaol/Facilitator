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
 * Registers a user with a unique identifier and a set of images of your face
 * Class TrainingController
 * @package App\Http\Controllers\request
 */
class TrainingController extends Controller
{
    /**
     * @var ImageController Should contain the functions for authenticate an user
     */
    private $imageSet = []; //Collection of images
    /**
     * @var TrainingResponseController Should contain the answers given by the register then of be success
     */
    private $trainingResponse;

    /**
     * TrainingController constructor.
     * @param string $userId
     * @param array $images
     * @param TrainingResponseController $response
     * @internal param $image
     */
    public function __construct($userId, $images, TrainingResponseController $response)
    {
        //Instance answers given by the register then of be success
        $response->addFacilitatorId(new FacilitatorIdController($userId));
        $response->setUserId($userId);
        $this->trainingResponse = $response;

        // Create a collection of images trained

        $i = 0; $flag=true;
        foreach ($images as $key => $value) {
            
            // Instance training image
            $this->imageSet[$i] = new ImageController($userId,trim($value["base64"]), new ImageResultController());
            // Verifies that only one person is thought throughout the process trained
            $this->imageSet[$i]->setPictureId($value["pictureId"]);
            if($i<1) {
                // If any error creating the person arises, the steps of detecting, add and train is avoided.
                if(!$this->imageSet[$i]->create()){
                    $flag = false; // Only happen if users stored in the account reaches its limit Face++
                }
            }
            if($flag) {
                if($this->imageSet[$i]->detect()) { // Detects a face in the image
                    if($this->imageSet[$i]->add()){ // Add a face to the user Face++
                        $this->imageSet[$i]->train(); // Finally train
                    }
                }
            }
            $i++; // Counter
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
