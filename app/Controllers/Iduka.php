<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\IdukaModel;
use App\Models\MajorModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;
use ReflectionException;

/**
 * @property YantoDevConfig $config
 * @property MajorModel $major
 * @property IdukaModel $iduka
 * @property string $ok
 * @property string $error
 */
class RestApi extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->major = new MajorModel();
        $this->iduka = new IdukaModel();
        $this->ok = 'OK';
        $this->error = 'ERROR';
    }

    public function findAllMajor(): \CodeIgniter\HTTP\Response
    {
        $result = $this->config->ApiResponseBuilder($this->major->findAll());
        return $this->respond($result);
    }

    /**
     * @throws ReflectionException
     */
    public function addIduka(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'major' => $this->request->getVar('major')
        ];
        return $this->respond($this->config->ApiResponseBuilder($this->iduka->insert($data)));
    }

    /**
     * @throws ReflectionException
     */
    public function updateIduka(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'major' => $this->request->getVar('major'),
        ];
        return $this->respond($this->config->ApiResponseBuilder(
            $this->iduka->update($this->request->getVar('id'), $data)));
    }

    public function deleteIduka(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder($this->iduka->delete($this->request->getVar('id')))
        );
    }

    public function detailMajor(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->major->find($this->request->getVar('id'))
            )
        );
    }

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