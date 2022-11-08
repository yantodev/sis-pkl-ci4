<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 * @property UsersModel $user
 */
class User extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->user = new UsersModel();
    }

    public function addUser(): \CodeIgniter\HTTP\Response
    {
        $request = [
            'role_pkl' => $this->request->getVar('role'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'image' => "default.png"
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->user->insert($request)
            )
        );
    }

    public function userActivation(): \CodeIgniter\HTTP\Response
    {
        $response = $this->user->getWhere([
                'email' => $this->request->getVar('email'),
                'role_pkl' => $this->request->getVar('role'),
            ]
        )->getRow();
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->user->update(
                    $response->id,
                    [
                        'is_active' => 1,
                        'role_pkl' => $this->request->getVar('role')
                    ]))
        );
    }

    public function getUserByEmail(): \CodeIgniter\HTTP\Response
    {
        $email = $this->request->getVar('email');
        $result = $this->user->getWhere(['email' => $email])->getRow();
        $response = [
            'id' => $result->id,
            'name' => $result->name,
            'email' => $result->email,
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder($response)
        );
    }
}