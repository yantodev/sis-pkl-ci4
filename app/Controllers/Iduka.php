<?php

/**
 * The Iduka Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\IdukaModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 * @property IdukaModel $iduka
 */
class Iduka extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->iduka = new IdukaModel();
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
            $this->config->ApiResponseBuilder(
                $this->iduka->delete($this->request->getVar('id'))
            )
        );
    }

    public function detail(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->find($this->request->getVar('id'))
            )
        );
    }

    public function getAllIdukaByMajor($id): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->findAllByMajorId($id)->getResult()
            )
        );
    }
}