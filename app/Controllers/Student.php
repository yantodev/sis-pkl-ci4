<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\MajorModel;
use App\Models\MasterDataModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\Session\Session;
use Config\YantoDevConfig;

/**
 * @property Session|mixed|null $session
 * @property ClassModel $class
 * @property UserDetailModel $userDetail
 */
class Student extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->class = new ClassModel();
        $this->userDetail = new UserDetailModel();
        $this->masterData = new MasterDataModel();
    }

    public function index()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $res = $this->masterData->findByNis($response ? $response->nis : null)->getRow();
        $data = [
            'title' => "Dashboard",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
            'master' => $res,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null)->getResult(),
            'dataIduka' => $this->idukaModel->find($res ? $res->iduka_id : null)
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 3) {
            $session->destroy();
            return redirect()->to('/auth/error');
        }
        if ($response && $res) {
            return view('pages/student/dashboard', $data);
        }
        return view('pages/student/validation', $data);
    }

    function addDetail(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->validate([
            'nis' => [
                'rules' => 'required|is_unique[user_details.user_id]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => '{field} sudah ada!Silahkan gunakan NIS lainnya'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/student')->withInput()->with('validation', $validation);
        }
        $data = [
            'user_id' => $this->request->getVar('nis'),
            'user_public_id' => $this->request->getVar('user_public_id'),
            'nisn' => $this->request->getVar('nisn'),
            'name' => $this->request->getVar('name'),
            'jk' => $this->request->getVar('jk'),
            'tp' => $this->request->getVar('tp'),
            'major_id' => $this->request->getVar('major_id'),
            'class_id' => $this->request->getVar('class_id')
        ];
        try {
            $this->userDetail->insert($data);
        } catch (\ReflectionException $e) {
            $this->session->setFlashdata('eror', $e);
        }
        $this->session->setFlashdata('success', 'Data is updated!!!');
        return redirect()->to('/student');
    }

    function addMasterData(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->validate([
            'nis' => [
                'rules' => 'required|is_unique[master_data.nis]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => '{field} sudah memilih lokasi PKL!!!'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/student')->withInput()->with('validation', $validation);
        }
        $data = [
            'nis' => $this->request->getVar('nis'),
            'tp_id' => $this->request->getVar('tp_id'),
            'iduka_id' => $this->request->getVar('iduka_id'),
        ];
        try {
            $this->masterData->insert($data);
        } catch (\ReflectionException $e) {
            $this->session->setFlashdata('eror', $e);
        }
        $this->session->setFlashdata('success', 'Data is updated!!!');
        return redirect()->to('/student');
    }

}