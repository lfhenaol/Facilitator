<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lucho
 * Date: 27/04/2016
 * Time: 11:02 PM
 */
namespace App\Library;

use Illuminate\Support\Facades\URL;

class ImagesFunction {
    /**
     * @var
     */
    public $imageBase64;

    /**
     * @param $base64_string
     * @param $output_file
     * @return mixed
     */
    public function base64ToJpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb");
        $seek = strpos($base64_string,",");
        if($seek !== false) {
            $data = explode(',', $base64_string);
            fwrite($ifp, base64_decode($data[1]));
        } else{
            fwrite($ifp, base64_decode($base64_string));
        }
        fclose($ifp);
        return $output_file;
    }

    /**
     * @param $image
     */
    public function deleteImage($image) {
        unlink($image);
    }

    /**
     * @param $imageId
     * @return mixed
     */
    public function createImage($imageId) {
        $file = $this->createName($imageId);
        return $this->base64ToJpeg($this->imageBase64, $file);
    }

    /**
     * @param $imageId
     * @return string
     */
    public function createName($imageId) {
        $date = time() + $imageId;

        return $date . ".jpeg";
    }
    
}