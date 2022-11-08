<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\IdukaModel;
use App\Models\MajorModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 * @property MajorModel $major
 * @property IdukaModel $iduka
 */
class Iduka extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->major = new MajorModel();
        $this->iduka = new IdukaModel();
    }

    public function findAllMajor(): \CodeIgniter\HTTP\Response
    {
        $result = $this->config->ApiResponseBuilder($this->major->findAll());
        return $this->respond($result);
    }

    public function addIduka(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'major' => $this->request->getVar('major')
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->insert($data)
            )
        );
    }

    public function updateIduka(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'major' => $this->request->getVar('major'),
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->update(
                    $this->request->getVar('id'), $data)
            )
        );
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
}