<?php
/**
 * Created by PhpStorm.
 * User: Dragan
 * Date: 11/10/2018
 * Time: 6:33 PM
 */
namespace App\Http\Services;

use Log;
use RestClient;

class IpStack
{
    /**
     * API Access kry
     */
    private $apiAccessKey= '257d90a207b2d37569077a33724f4ce0';

    /**
     * Base url
     */
    private $baseUrl= 'http://api.ipstack.com';

    /**
     *
     * @var
     */
    private $ipAddress;

    /**
     * IpStack constructor.
     */
    public function __construct()
    {
        $this->ipAddress = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return mixed
     */
    public function callApi()
    {
        try {
            $api = new RestClient([
                'base_url' => $this->baseUrl,
            ]);

            if (env('APP_ENV') == 'local') {
                $this->setIpAddress('87.116.179.192');
            }

            $result = $api->get($this->ipAddress, ['access_key' => $this->apiAccessKey]);

            if($result->info->http_code == 200) {
                return $result->decode_response();
            } else {
                throw new \Exception('Error call to Api Stack', $result->info->http_code);
            }

        } catch (\Exception $e) {
            Log::error($e);
        }

    }

    /**
     * @param $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     *
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

}
