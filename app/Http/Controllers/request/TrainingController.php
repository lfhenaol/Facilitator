<?php

namespace App\Http\Controllers\request;

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

    //

    /**
     * TrainingController constructor.
     * @param $userId
     * @param $images
     * @internal param $image
     */
    public function __construct($userId, $images)
    {
        
        foreach ($images as $internalId => $image) {
            $this->addImage(new ImageController($userId, $image));
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
     * @return array
     */
    public function getImageSet()
    {
        return $this->imageSet;
    }
    
}
