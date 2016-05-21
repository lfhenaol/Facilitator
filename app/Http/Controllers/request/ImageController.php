<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\response\FacilitatorIdController;
use App\Http\Controllers\response\ImageResultController;
use App\Http\Controllers\response\TrainingResponseController;
use App\Library\ImagesFunction;
use Illuminate\Http\Request;

use App\Http\Requests;
#use App\Http\Controllers\Controller;

use App\Http\Controllers\faceppSDK\FaceppController;
use Illuminate\Support\Facades\URL;

/**
 * Class ImageController
 * @package App\Http\Controllers\request
 */
class ImageController extends FaceppController
{
    /**
     * @var
     */
    private $internalID;
    /**
     * @var
     */
    private $face;
    /**
     * @var
     */
    private $face_id;
    /**
     * @var
     */
    private $userId;

    /**
     * @var ImageResultController
     */
    private $response;

    /**
     * ImageController constructor.
     * @param $userID
     * @param $image
     * @param ImageResultController $response
     */
    public function __construct($userID, $image, ImageResultController $response)
    {
        $this->userId = $userID; // It generates a unique identifier representing the user
        $this->face = $image;
        $this->response = $response;
    }

    /**
     * Create a repository of faces
     *
     * @return bool
     */
    public function create(){
        $params['person_name'] = $this->userId;

        $result = $this->execute('/person/create', $params);

        // Verify that the procedure will be successful or that the person already exists
        if ($result['http_code'] == 200 || $result['http_code'] == 453)
        {
            return true;
        }else{
            $result = json_decode($result["body"],true);
            $this->response->setPictureId("");
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($result["error"]);
        }

        return false;
    }

    /**
     * @return ImageResultController
     */
    public function getResponse(){
        return $this->response;
    }

    /**
     * Determines the image given or not a face
     *
     * @return bool
     */

    public function detect(){

        $imageFunction = new ImagesFunction();
        $imageFunction->imageBase64 = $this->face;
        $params['img'] = $imageFunction->createImage($this->internalID);

        $results = $this->execute('/detection/detect', $params);

        $result = json_decode($results["body"],true);

        $this->response->setPictureId($this->internalID);

        if ($results['http_code'] == 200) {

            //Is checked if more than one face in the picture, if there is a single face or no face.
            if (count($result['face']) > 2)
            {

                $this->response->setSuccess(false);
                $this->response->setErrorCode("13");
                $this->response->setErrorMessage("More than a face in the image");

                return false;
            }
            else if(count($result['face']) == 1)
            {
                $this->face_id = $result["face"][0]["face_id"];

                return true;
            } else{
                $this->response->setSuccess(false);
                $this->response->setErrorCode("2");
                $this->response->setErrorMessage("No face could be detected in the image.");
            }
        } else {

            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($result["error"]);
        }
        return false;
    }

    /**
     * Add detected faces faces repository created
     *
     * @return bool
     */
    public function add(){
        $params["face_id"] = $this->face_id;
        $params["person_name"] = $this->userId;

        $result = $this->execute("/person/add_face", $params);

        if ($result['http_code'] == 200) {
            return true;
        }else{
            $result = json_decode($result["body"],true);
            $this->response->setPictureId($this->internalID);
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($result["error"]);
        }
        return false;
    }

    /**
     * Train the repository created in the system face
     *
     * @return bool
     */
    public function train(){
        $params["person_name"] = $this->userId;

        $result = $this->execute("/train/verify",$params);

        if ($result['http_code'] == 200) {
            $this->response->setSuccess(true);

            return true;
        } else{
            $result = json_decode($result["body"],true);
            $this->response->setPictureId($this->internalID);
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($result["error"]);
        }
        return false;
    }

    /**
     * Check if the given image of a face is a series of faces and previously trained in face ++
     *
     * @return bool
     */
    public function verify(){
        $params["person_name"] = $this->userId;
        $params["face_id"] = $this->face_id;

        $result = $this->execute("/recognition/verify",$params);

        if ($result['http_code'] == 200) {
            $result = json_decode($result["body"],true);

            $this->response->setSuccess($result["is_same_person"]);

            if($result["is_same_person"]) {
                return true;
            } else{

                $this->response->setErrorCode("14");
                $this->response->setErrorMessage("It is not the same person");
                return false;
            }

        } else{
            $result = json_decode($result["body"],true);
            $this->response->setPictureId("");
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($result["error"]);
        }
        return false;
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
    public function getFace()
    {
        return $this->face;
    }

    /**
     * @param mixed $face
     */
    public function setFace($face)
    {
        $this->face = $face;
    }

    /**
     * @return mixed
     */
    public function getInternalID()
    {
        return $this->internalID;
    }

    /**
     * @param mixed $internalID
     */
    public function setInternalID($internalID)
    {
        $this->internalID = $internalID;
    }
}
