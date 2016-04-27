<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\response\FacilitatorIdController;
use App\Http\Controllers\response\ImageResultController;
use App\Http\Controllers\response\TrainingResponseController;
use App\Http\Controllers\response\ResponseController;
use Illuminate\Http\Request;

use App\Http\Requests;
#use App\Http\Controllers\Controller;

use App\Http\Controllers\faceppSDK\FaceppController;

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
    private $userId;

    private $response;

    /**
     * ImageController constructor.
     * @param $userID
     * @param $image
     * @param ImageResultController $response
     */
    public function __construct($userID, $image, ImageResultController $response)
    {
        $this->userId = $userID;
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

        if ($result['http_code'] == 200)
        {
            return true;
        }

        return false;
    }

    public function getResponse(){
        return $this->response;
    }

    /**
     * Determines the image given or not a face
     *
     * @return bool
     */

    public function detect(){

        // Pasar de base64 a archivo físico
        $params['url'] = $this->face;

        $result = $this->execute('/detection/detect', $params);


        if ($result['http_code'] == 200) {
            $result = json_decode($result["body"],true);


            //Is checked if more than one face in the picture, if there is a single face or no face.
            if (count($result['face']) > 2)
            {
                #$response['message'] = "More than one face in the image";

                return false;
            }
            else if(count($result['face']) == 1)
            {

                $this->internalID = $result["face"][0]["face_id"];

                $this->response->setInternalId($this->internalID);
                $this->response->setSuccess("true");
                $this->response->setAppCode("200");
                $this->response->setMessage("OK");

                return true;
            }
        } else {
            $result['message'] = "Error";
        }
        return false;
    }

    /**
     * Add detected faces faces repository created
     *
     * @return bool
     */
    public function add(){
        $params["face_id"] = $this->internalID;
        $params["person_name"] = $this->userId;

        $result = $this->execute("/person/add_face", $params);

        if ($result['http_code'] == 200) {
            return true;
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
            return true;
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
        $params["face_id"] = $this->internalID;

        $result = $this->execute("/recognition/verify",$params);

        if ($result['http_code'] == 200) {
            $result = json_decode($result["body"],true);

            return true;
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
