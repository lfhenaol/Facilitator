<?php

namespace App\Http\Controllers\faceppSDK;


use App\Http\Controllers\Controller;
use CURLFile;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Class Facepp - Face++ PHP SDK
 *
 * @author Tianye
 * @author Rick de Graaff <rick@lemon-internet.nl>
 * @since  2013-12-11
 * @version  1.1
 * @modified 16-01-2014
 * @copyright 2013 - 2015 Tianye
 **/
class FaceppController extends Controller
{
    ######################################################
    ### If you choose Amazon(US) server,please use the ###
    ### http://apius.faceplusplus.com/v2               ###
    ### or                                             ###
    ### https://apius.faceplusplus.com/v2              ###
    ######################################################
    #public $server          = 'http://apicn.faceplusplus.com/v2';
    #public $server         = 'https://apicn.faceplusplus.com/v2';
    /**
     * @var string
     */
    public $server = "http://apius.faceplusplus.com/v2";
    #public $server         = 'https://apius.faceplusplus.com/v2';

    /**
     * @var string
     */
    public $api_key = "d68142c13b8cc10c00eca8f9812bee87";           // set your API KEY or set the key static in the property
    /**
     * @var string
     */
    public $api_secret = "6wXFVq-Mv3CvM5POi6jbFR7RiH3lyFZX";        // set your API SECRET or set the secret static in the property
    /**
     * @var string
     */
    private $useragent="Faceplusplus PHP SDK/1.1";

    /**
     * FaceppController constructor.
     */
    function __construct()
    {

    }

    /**
     * @param $method - The Face++ API
     * @param array $params - Request Parameters
     * @return array - {'http_code':'Http Status Code', 'request_url':'Http Request URL','body':' JSON Response'}
     * @throws Exception
     */
    public function execute($method, array $params)
    {
        if( ! $this->apiPropertiesAreSet()) {
           # throw new Exception('API properties are not set');
        }

        $params['api_key']      = $this->api_key;
        $params['api_secret']   = $this->api_secret;
        
        return $this->request("{$this->server}{$method}", $params);
    }

    /**
     * @param $request_url
     * @param $request_body
     * @return array
     */
    private function request($request_url, $request_body)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);
        curl_setopt($curl_handle, CURLOPT_FILETIME, true);
        curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, false);
        if(version_compare(phpversion(),"5.5","<=")){
            curl_setopt($curl_handle, CURLOPT_CLOSEPOLICY,CURLCLOSEPOLICY_LEAST_RECENTLY_USED);
        }else{
            curl_setopt($curl_handle, CURLOPT_SAFE_UPLOAD, false);
        }
        curl_setopt($curl_handle, CURLOPT_MAXREDIRS, 5);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 5184000);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 1200);
        curl_setopt($curl_handle, CURLOPT_NOSIGNAL, true);
        curl_setopt($curl_handle, CURLOPT_REFERER, $request_url);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, $this->useragent);


        if (extension_loaded('zlib')) {
            curl_setopt($curl_handle, CURLOPT_ENCODING, '');
        }

        curl_setopt($curl_handle, CURLOPT_POST, true);

        if (array_key_exists('img', $request_body)) {
            $request_body['img'] = new CurlFile($request_body['img'], 'image/jpeg');
        } else {
            $request_body = http_build_query($request_body);
        }

        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $request_body);

        $response_text      = curl_exec($curl_handle);
        $response_header    = curl_getinfo($curl_handle);
        curl_close($curl_handle);

        return array (
            'http_code'     => $response_header['http_code'],
            'request_url'   => $request_url,
            'body'          => $response_text
        );
    }

    /**
     * @return bool
     */
    private function apiPropertiesAreSet()
    {
        if( ! $this->api_key) {
            return false;
        }

        if( ! $this->api_secret) {
            return false;
        }

        return true;
    }
}
