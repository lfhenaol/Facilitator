<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lucho
 * Date: 27/04/2016
 * Time: 11:02 PM
 */
namespace App\Library;

use Illuminate\Support\Facades\URL;
/**
 * Functions necessary to convert an image into base64 in a physical memory image
 *
 * Class ImagesFunction
 * @package App\Library
 */
class ImagesFunction {
    /**
     * @var string base64 image string
     */
    public $imageBase64;

    /**
     * @param string $base64_string
     * @param string $output_file
     * @return string
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
     * @param string $image
     */
    public function deleteImage($image) {
        unlink($image);
    }

    /**
     * @param int $imageId
     * @return string
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