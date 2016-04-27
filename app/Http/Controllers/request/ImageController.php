<?php

namespace App\Http\Controllers\request;

use Illuminate\Http\Request;

use App\Http\Requests;
#use App\Http\Controllers\Controller;

use App\Http\Controllers\FaceppController;

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


    /**
     * ImageController constructor.
     * @param $userID
     * @param $image
     */
    public function __construct($userID, $image)
    {
        $this->userId = $userID;
        $this->face = $image;

    }

    /**
     * Create a repository of faces
     *
     * @return bool
     * @throws \App\Http\Controllers\Exception
     */
    public function create(){
        $params['person_name'] = $this->userId;

        $response = $this->execute('/person/create', $params);

        if ($response['http_code'] == 200)
        {
            return true;
        }

        return false;
    }

    /**
     * Determines the image given or not a face
     *
     * @return bool
     * @throws \App\Http\Controllers\Exception
     */
    public function detect(){

        // Pasar de base64 a archivo físico
        $params['url'] = $this->face;

        $response = $this->execute('/detection/detect', $params);


        if ($response['http_code'] == 200) {
            $response = json_decode($response["body"],true);


            //Is checked if more than one face in the picture, if there is a single face or no face.
            if (count($response['face']) > 2)
            {
                #$response['message'] = "More than one face in the image";

                return false;
            }
            else if(count($response['face']) == 1)
            {

                $this->internalID = $response["face"][0]["face_id"];
                return true;
            }
        } else {
            $response['message'] = "Error";
        }
        return false;
    }

    /**
     * Add detected faces faces repository created
     *
     * @return bool
     * @throws \App\Http\Controllers\Exception
     */
    public function add(){
        $params["face_id"] = $this->internalID;
        $params["person_name"] = $this->userId;

        $response = $this->execute("/person/add_face", $params);

        if ($response['http_code'] == 200) {
            return true;
        }
        return false;
    }

    /**
     * Train the repository created in the system face
     *
     * @return bool
     * @throws \App\Http\Controllers\Exception
     */
    public function train(){
        $params["person_name"] = $this->userId;

        $response = $this->execute("/train/verify",$params);

        if ($response['http_code'] == 200) {
            return true;
        }
        return false;
    }

    /**
     * Check if the given image of a face is a series of faces and previously trained in face ++
     *
     * @return bool
     * @throws \App\Http\Controllers\Exception
     */
    public function verify(){
        $params["person_name"] = $this->userId;
        $params["face_id"] = $this->internalID;

        $response = $this->execute("/recognition/verify",$params);

        if ($response['http_code'] == 200) {
            $response = json_decode($response["body"],true);

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
