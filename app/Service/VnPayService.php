<?php
/**
 * Created by PhpStorm .
 * User: datchitu .
 * Date: 1/4/23 .
 * Time: 10:56 AM .
 */

namespace App\Service;

use GuzzleHttp\Client;

class VnPayService
{
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";

    /**
     * @param null $domain
     * @return Client
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getClient($version = 'v1') {
        return new Client([
            "base_uri" => "https://sandbox.vnpayment.vn/",
            "verify" => false,
            "headers" => [
                'Content-Type'        => 'application/json'
            ]
        ]);
    }
}
