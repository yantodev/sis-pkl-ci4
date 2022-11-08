<?php
/**
 * @Author : yantodev
 * mailto: ekocahyanto007@gmail.com
 * link : http://yantodev.github.io/
 */

namespace Config;

use CodeIgniter\Config\BaseConfig;

class YantoDevConfig extends BaseConfig
{
    public $name = 'YantoDev';
    public $baseURL = 'http://localhost/yantodev/';

    public function getdata()
    {
        return $this->name;
    }

    public function ApiResponseBuilder($result): array
    {
        return [
            'code' => $result ? 200 : 404,
            'message' => $result ? 'success' : 'error',
            'result' => $result ?: null
        ];
    }

    public function baseUrl($url): array
    {
        return [
            'url' => $url
        ];
    }

}