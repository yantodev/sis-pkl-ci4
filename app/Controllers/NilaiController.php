<?php
/**
 * Copyright (c) yantodev all right reserved
 * Nilai Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\MajorModel;
use App\Models\MasterCategoryNilaiModel;
use App\Models\TpModel;
use App\Models\UsersModel;
use Config\APIResponseBuilder;
use Config\IApplicationConstantConfig;
use Config\YantoDevConfig;

/**
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property YantoDevConfig $config
 * @property APIResponseBuilder $ResponseBuilder
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property UsersModel $usersModel
 * @property MajorModel $major
 * @property MasterCategoryNilaiModel $masterCategoryNilai
 */
class NilaiController extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->tp = new TpModel();
        $this->masterCategoryNilai = new MasterCategoryNilaiModel();
    }

    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $majorId = $this->request->getVar("jurusan");
        $tp = $this->request->getVar("tp");
        $iduka = $this->request->getVar("iduka");
        $result = $this->usersModel->findAllSiswaByMajorAndTpId($majorId, $tp, $iduka);
        $data = [
            'title' => "Daftar Nilai Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $result,
            'jurusan' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'categoryNilai' => $this->masterCategoryNilai->findByMajorId($majorId),
            'majorId' => $majorId ? $majorId : 0,
            'tpId' => $tp ? $tp : 0,
            'idukaId' => $iduka ? $iduka : 0
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/nilai/index',
            $data
        );
    }

    public function addNilai(): \CodeIgniter\HTTP\RedirectResponse
    {
        $tp = $this->request->getVar('tp');
        $major = $this->request->getVar('majorId');
        $iduka = $this->request->getVar('idukaId');
        $userPublicId = $this->request->getVar('userPublicId[]');
        $id = $this->request->getVar('id[]');
        $nilai1 = $this->request->getVar('nilai_1[]');
        $nilai2 = $this->request->getVar('nilai_2[]');
        $nilai3 = $this->request->getVar('nilai_3[]');
        $nilai4 = $this->request->getVar('nilai_4[]');
        $nilai5 = $this->request->getVar('nilai_5[]');
        $nilai6 = $this->request->getVar('nilai_6[]');
        $nilai7 = $this->request->getVar('nilai_7[]');
        $nilai8 = $this->request->getVar('nilai_8[]');
        $nilai9 = $this->request->getVar('nilai_9[]');
        $nilai10 = $this->request->getVar('nilai_10[]') != null ? $this->request->getVar('nilai_10[]') : "-";
        $nilai11 = $this->request->getVar('nilai_11[]') != null ? $this->request->getVar('nilai_11[]') : "-";
        $result = [];
        foreach ($userPublicId as $key => $val) {
            if (!isset($nilai10[$key]) && !isset($nilai11[$key])) {
                $nilaiFix10 = '-';
                $nilaiFix11 = '-';
            } else {
                $nilaiFix10 = $nilai10[$key];
                $nilaiFix11 = $nilai11[$key];
            }
            $result[] = [
                'user_public_id' => $userPublicId[$key],
                'nilai_1' => $nilai1[$key],
                'nilai_2' => $nilai2[$key],
                'nilai_3' => $nilai3[$key],
                'nilai_4' => $nilai4[$key],
                'nilai_5' => $nilai5[$key],
                'nilai_6' => $nilai6[$key],
                'nilai_7' => $nilai7[$key],
                'nilai_8' => $nilai8[$key],
                'nilai_9' => $nilai9[$key],
                'nilai_10' => $nilaiFix10,
                'nilai_11' => $nilaiFix11,
            ];
        }

        try {
            $query = $this->masterNilai->updateBatch($result, 'user_public_id');
            if ($query) {
                $this->session->setFlashdata('success', 'update nilai berhasil!!!');
            } else {
                $this->masterNilai->insertBatch($result);
                $this->session->setFlashdata('success', 'insert nilai berhasil!!!');
            }
        } catch (\ReflectionException $e) {
            $this->session->setFlashdata('error', $e);
        }
        return redirect()->to("nilai?tp=$tp&jurusan=$major&iduka=$iduka");
    }
}