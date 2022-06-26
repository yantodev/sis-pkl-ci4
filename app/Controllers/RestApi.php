<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class RestApi extends ResourceController
{
    use ResponseTrait;
    public function getUserByEmail()
    {
        $model = new UsersModel();
        // $data = $model->where(['email' => $this->request->getVar('email')])->findAll();
        // return $this->respond($data, 200);
        $email = $this->request->getVar('email');
        $user = $model->getWhere(['email' => $email])->getResult();
        if ($user) {
            $data = [
                'code' => 200,
                'message' => 'User found',
                'result' => $user
            ];
            return $this->respond($data);
        } else {
            $data = [
                'code' => 404,
                'message' => 'User not found',
                'result' => null
            ];
            return $this->respond($data);
            // $this->response->setStatusCode(200);
            // $this->response->setJSON(['data' => $user]);
        }
    }
}