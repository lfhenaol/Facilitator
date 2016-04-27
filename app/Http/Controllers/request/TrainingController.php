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
        foreach ($images as $internalId => $image) {
            $this->addImage(new ImageController($userId, $image, new ImageResultController()));
        }
    }

    //Composition with Image in Class Diagram
    /**
     * @param ImageController $image
     */
    public function addImage(ImageController $image)
    {
        $image->create();
        $image->detect();
        $image->add();
        $image->train();
        $this->imageSet[] = $image;
    }

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
