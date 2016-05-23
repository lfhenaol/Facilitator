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
 * Functions required to register or authenticate a user
 * Class ImageController
 * @package App\Http\Controllers\request
 */
class ImageController extends FaceppController
{
    /**
     * @var int Should contain the image identification
     */
    private $pictureId;
    /**
     * @var string Should contain the base64 image string
     */
    private $face;
    /**
     * @var string Should contain an id that provides Faceplusplus after identifying a face
     */
    private $face_id;
    /**
     * @var string Should contain a unique identifier for a user
     */
    private $userId;
    /**
     * @var ImageResultController Should contain the answers given by the register then of to fail
     */
    private $response;

    /**
     * ImageController constructor.
     * @param string $userID
     * @param string $image
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
        $params['person_name'] = $this->userId; // User ID is set to Face++

        $result = $this->execute('/person/create', $params); // Executes the function create person Face++

        // Verify that the procedure will be successful or that the person already exists
        if ($result['http_code'] == 200 || $result['http_code'] == 453) { // Response Face++ OK
            return true;
        }else{ // Response Face++ error
            $result = json_decode($result["body"],true);
            $this->response->setPictureId("");
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($this->normalizeError($result["error"]));
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
        // Create base64 image within a hard disk directory
        $imageFunction = new ImagesFunction();
        $imageFunction->imageBase64 = $this->face;
        $params['img'] = $imageFunction->createImage($this->pictureId); //The address of the hard disk is delivered

        $results = $this->execute('/detection/detect', $params); // Executes the function detect face Face++

        $result = json_decode($results["body"],true);

        $this->response->setPictureId($this->pictureId);

        if ($results['http_code'] == 200) { // Response Face++ OK
            //Is checked if more than one face in the picture, if there is a single face or no face.
            if (count($result['face']) > 2) // Case 1: More than a face in the image
            {
                $this->response->setSuccess(false); // Process register error
                $this->response->setErrorCode("13");
                $this->response->setErrorMessage("More than a face in the image");
                return false;
            }
            else if(count($result['face']) == 1) // Case 2: A face in the image
            {
                $this->face_id = $result["face"][0]["face_id"]; // Continue process register
                return true;
            } else{ // Case 3: No face could be detected in the image
                $this->response->setSuccess(false); //Process register error
                $this->response->setErrorCode("2");
                $this->response->setErrorMessage("No face could be detected in the image.");
            }
        } else { // Response Face++ error
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($this->normalizeError($result["error"]));
        }
        return false;
    }

    /**
     * Add detected faces to repository created
     *
     * @return bool
     */
    public function add(){
        $params["face_id"] = $this->face_id; // Face ID is set to Face++
        $params["person_name"] = $this->userId; // User ID is set to Face++

        $result = $this->execute("/person/add_face", $params); // Executes the function add face person Face++

        if ($result['http_code'] == 200) { // Response Face++ OK
            return true;
        }else{ // Response Face++ error
            $result = json_decode($result["body"],true);
            $this->response->setPictureId($this->pictureId);
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($this->normalizeError($result["error"]));
        }
        return false;
    }

    /**
     * Train the repository created in the system face
     *
     * @return bool
     */
    public function train(){
        $params["person_name"] = $this->userId; // User ID is set to Face++

        $result = $this->execute("/train/verify",$params); // Executes the function train Face++

        if ($result['http_code'] == 200) { // Response Face++ OK
            $this->response->setSuccess(true); // Process register OK
            return true;
        } else{// Response Face++ error
            $result = json_decode($result["body"],true);
            $this->response->setPictureId($this->pictureId);
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($this->normalizeError($result["error"]));
        }
        return false;
    }

    /**
     * Check if the given image of a face is a series of faces and previously trained in face ++
     *
     * @return bool
     */
    public function verify(){
        $params["person_name"] = $this->userId; // User ID is set to Face++
        $params["face_id"] = $this->face_id; // Face ID is set to Face++

        $result = $this->execute("/recognition/verify",$params); // Executes the function recognition verify Face++

        if ($result['http_code'] == 200) { // Response Face++ OK
            $result = json_decode($result["body"],true);

            $this->response->setSuccess($result["is_same_person"]); // Verification successful or failed

            if($result["is_same_person"]) { // Verification successful
                return true;
            } else{ // Verification failed
                $this->response->setErrorCode("14");
                $this->response->setErrorMessage("It is not the same person");
                return false;
            }

        } else{
            $result = json_decode($result["body"],true);
            $this->response->setPictureId("");
            $this->response->setSuccess(false);
            $this->response->setErrorCode($result["error_code"]);
            $this->response->setErrorMessage($this->normalizeError($result["error"]));
        }
        return false;
    }

    /**
     * Normalizes the error message given by Face++
     *
     * @param  string $str
     * @return string
     */
    public function normalizeError($str){
        $strings = explode("_",strtolower($str));
        $string = ucfirst((string) $strings[0]);
        for($i=1;$i<count($strings);$i++){
            $string = $string." ".$strings[$i];
        }
        return $string;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getFace()
    {
        return $this->face;
    }

    /**
     * @param string $face
     */
    public function setFace($face)
    {
        $this->face = $face;
    }

    /**
     * @return string
     */
    public function getPictureId()
    {
        return $this->pictureId;
    }

    /**
     * @param int $pictureId
     */
    public function setPictureId($pictureId)
    {
        $this->pictureId = $pictureId;
    }
}
