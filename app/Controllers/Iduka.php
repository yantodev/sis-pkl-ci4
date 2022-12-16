<?php

/**
 * The Iduka Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\DetailIdukaModel;
use App\Models\IdukaModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\APIResponseBuilder;
use Config\YantoDevConfig;

/**
 * @property YantoDevConfig $config
 * @property IdukaModel $iduka
 * @property DetailIdukaModel $detailIduka
 * @property APIResponseBuilder $ResponseBuilder
 */
class Iduka extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->config = new YantoDevConfig();
        $this->iduka = new IdukaModel();
        $this->detailIduka = new DetailIdukaModel();
    }

    public function addIduka(): \CodeIgniter\HTTP\Response
    {
        $request = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'major' => $this->request->getVar('major')
        ];
        try {
            $responseAddIduka = $this->iduka->insert($request);
            if (!is_null($responseAddIduka)) {
                $this->detailIduka->insert([
                    'id_iduka' => $responseAddIduka,
                    'address' => $this->request->getVar('address'),
                ]);
                $response = $this->ResponseBuilder->ok($responseAddIduka);
            }
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function updateIduka(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');
        $address = $this->request->getVar('address');
        $major = $this->request->getVar('major');
        $data = [
            'name' => $name,
            'address' => $address,
            'major' => $major,
        ];
        try {
            $responseDetail = $this->detailIduka->findByIdIduka($id);
            if (is_null($responseDetail)) {
                $this->detailIduka->insert([
                    'id_iduka' => $id,
                    'address' => $address
                ]);
            }
            $this->detailIduka->updateByIdIduka($id, $address);
            $response = $this->ResponseBuilder->ok($this->iduka->update($id, $data));
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
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
                $this->iduka->findById($this->request->getVar('id'))
            )
        );
    }

    public function findAllIdukaByMajorAndTp(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->findAllIdukaByIdAndTp(
                    $this->request->getVar('major'),
                    $this->request->getVar('tp'))
            )
        );
    }

    public function findAllIdukaByTp($tp): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->findAllIdukaByTp($tp)
            )
        );
    }

    public function findAllIdukaByMajor($major): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->iduka->findAllIdukaByMajor($major)
            )
        );
    }
}