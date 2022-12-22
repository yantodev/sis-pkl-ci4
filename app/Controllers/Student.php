<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\MajorModel;
use App\Models\MasterDataModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\Session\Session;
use Config\APIResponseBuilder;
use Config\YantoDevConfig;

/**
 * @property Session|mixed|null $session
 * @property ClassModel $class
 * @property UserDetailModel $userDetail
 * @property APIResponseBuilder $ResponseBuilder
 */
class Student extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
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
        if ($response && $res) {
            return $this->ResponseBuilder->ReturnViewValidationStudent(
                $this->session,
                'pages/student/dashboard',
                [
                    'title' => "Dashboard",
                    'validation' => \Config\Services::validation(),
                    'users' => $this->session->get('email'),
                    'users_id' => $this->session->get('id'),
                    'role' => $this->session->get('role'),
                    'data' => $response,
                    'master' => $res,
                    'dataIduka' => $this->masterData->findByUserPublicId($response->id),
                    'major' => $this->major->findAll(),
                    'tp' => $this->tp->findAll(),
                    'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
                    'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
                ]
            );
//            return view('pages/student/dashboard', $data);
        }
        return view('pages/student/validation', [
            'title' => "Dashboard",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'tp' => $this->tp->findAll(),
            'major' => $this->major->findAll(),
            'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
            'data' => $response,
            'master' => $res,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : false),
        ]);
    }

    function addDetail(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->validate([
            'nis' => [
                'rules' => 'required|is_unique[user_details.user_id]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => '{field} sudah ada! Silahkan gunakan NIS lainnya'
                ]
            ],
            'user_public_id' => [
                'rules' => 'required|is_unique[user_details.user_public_id]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => 'user sudah ada! Silahkan hubungi admin anda!!!'
                ]
            ]
        ])) {
            return redirect()->to('/student')->withInput();
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
            return redirect()->to('/student')->withInput();
        }
        $data = [
            'user_public_id' => $this->request->getVar('user_public_id'),
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

    public function profile()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $res = $this->masterData->findByNis($response ? $response->nis : null)->getRow();
        $data = [
            'title' => "Profile",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
            'master' => $res,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
            'dataIduka' => $this->idukaModel->findById($res ? $res->iduka_id : null)
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 3) {
            $this->session->destroy();
            return redirect()->to('/auth/error');
        }
        if ($response && $res) {
            return view('pages/student/profile', $data);
        }
        return view('pages/student/validation', $data);
    }

    /**
     * @throws \ReflectionException
     */
    public function updateProfile(): \CodeIgniter\HTTP\RedirectResponse
    {
        helper(['form']);
        if (!$this->validate($this->config->formValidationUserDetail())) {
            return redirect()->to('/student/profile')->withInput();
        }

        $oldImage = $this->request->getVar('oldImage');
        $fileImage = $this->request->getFile('profile');
        if ($fileImage->getError() == 4) {
            $imageName = $oldImage;
        } else {
            $imageName = $fileImage->getRandomName();
            $fileImage->move('assets/img/users', $imageName);
            if ($oldImage != 'default.png') {
                unlink('assets/img/users/' . $oldImage);
            }
        }


        $major = $this->class->find($this->request->getVar('class_id'));
        if ($major != null) {
            $data = [
                'name' => $this->request->getVar('name'),
                'nis' => $this->request->getVar('nis'),
                'nisn' => $this->request->getVar('nisn'),
                'jk' => $this->request->getVar('jk'),
                'tp' => $this->request->getVar('tp'),
                'class_id' => $this->request->getVar('class_id'),
                'major_id' => $major['major_id']
            ];

            $this->users->update(
                $this->request->getVar('id'), [
                'image' => $imageName]);
            $this->userDetail->update($this->request->getVar('ids'), $data);

            $this->session->setFlashdata('success', 'Data is updated!!!');
            return redirect()->to('/student/profile');
        }
        $this->session->setFlashdata('error', 'major is null');
        return redirect()->to('/student/profile');
    }

    public function iduka()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $res = $this->masterData->findByNis($response ? $response->nis : null)->getRow();
        $data = [
            'title' => "Daftar Iduka",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
            'dataIduka' => $this->idukaModel->findById($res ? $res->iduka_id : null)
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 3) {
            $this->session->destroy();
            return redirect()->to('/auth/error');
        }
        return view('pages/student/iduka', $data);
    }

    public function verifikasi()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $id = $this->request->getVar('id');
        $data = [
            'title' => "Verifikasi Data",
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'validation' => \Config\Services::validation(),
            'data' => $response,
            'master' => $this->masterData->findById($id),
            'statusData' => $this->request->getVar('statusData')
        ];
        return $this->ResponseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/admin/verifikasi-data-pkl',
            $data
        );
    }
}