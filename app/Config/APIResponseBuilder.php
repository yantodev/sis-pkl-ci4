<?php
/**
 * @Author : yantodev
 * mailto: ekocahyanto007@gmail.com
 * link : http://yantodev.github.io/
 */

namespace Config;

use CodeIgniter\Config\BaseConfig;

class APIResponseBuilder extends BaseConfig
{
    public function ok($result): array
    {
        return [
            'result' => $result,
            'responseData' => [
                'responseCode' => 200,
                'responseMsg' => 'success'
            ],
            'metaData' => [
                'total_data' => $this->cekData($result)
            ]
        ];
    }

    public function cekData($data): int
    {
        if (is_object($data)) {
            return 1;
        } elseif (is_array($data)) {
            return sizeof($data);
        } else {
            return 0;
        }
    }

    public function noContent($message): array
    {
        return [
            'result' => '',
            'responseData' => [
                'responseCode' => 404,
                'responseMsg' => $message
            ],
            'metaData' => [
                'total_data' => is_array($message) ? sizeof($message) : 0
            ]
        ];
    }

    public function internalServerError(string $message): array
    {
        return [
            'result' => '',
            'responseData' => [
                'responseCode' => 404,
                'responseMsg' => $message
            ],
            'metaData' => [
                'total_data' => 0
            ]
        ];
    }
}