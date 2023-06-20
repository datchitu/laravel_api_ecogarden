<?php
/**
 * Created by PhpStorm .
 * User: datchitu .
 * Date: 4/13/23 .
 * Time: 10:05 AM .
 */

namespace App\Service;

use GuzzleHttp\Exception\RequestException;

class ResponseService
{
    const SUCCESS = 'success';
    const ERROR = 'error';
    const FAIL = 'fail';

    /**
     * Get success
     *
     * @param array $data
     * @return array
     */
    public static function getSuccess($data = []) {
        return [
            'status' => ResponseService::SUCCESS,
            'data' => $data
        ];
    }

    /**
     * Get error
     *
     * @param $message
     * @return array
     */
    public static function getError($message, $status = ResponseService::ERROR) {
        return [
            'status' => $status,
            /*'data' => [
                'message' => $message
            ]*/
            'message' => "{$message}"
        ];
    }

    /**
     * Get error with messages
     *
     * @param $messages
     * @return array
     */
    public static function getErrorWithMessages($messages) {
        return [
            'status' => ResponseService::FAIL,
            /*'data' => [
                'messages' => $messages
            ]*/
            'data' => $messages
        ];
    }

    /**
     * @param $messages
     * @param int $error_code
     * @return array
     */
    public static function getResponseFail($messages, $data = []) {
        return [
            'status' => ResponseService::FAIL,
            'message' => $messages,
            'data' => $data
        ];
    }

    /**
     * @param \Exception|RequestException $e
     * @param string $message
     * @return array
     */
    public static function getExceptionError($e, string $message): array
    {
        logger()->debug($message, ['message' => $e->getMessage()]);
        return self::getError($message);
    }

    /**
     * @param $message
     * @param $code
     * @return array
     */
    public static function getErrorCode($message, $code) {
        return [
            'status' => ResponseService::ERROR,
            'code' => $code,
            'message' => $message
        ];
    }
}
