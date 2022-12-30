<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\MajorModel;
use App\Models\MasterDataModel;
use App\Models\TutorModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Session\Session;
use Config\APIResponseBuilder;
use Config\YantoDevConfig;

/**
 * @property Session|mixed|null $session
 * @property ClassModel $class
 * @property UserDetailModel $userDetail
 * @property TutorModel $tutor
 */
class Teacher extends BaseController
{
    use ResponseTrait;

    private APIResponseBuilder $ResponseBuilder;

    public function __construct()
    {
        $this->session = session();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->config = new YantoDevConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->class = new ClassModel();
        $this->userDetail = new UserDetailModel();
        $this->masterData = new MasterDataModel();
        $this->tutor = new TutorModel();
    }

    public function index()
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $tutor = $this->tutor->findByTeacherId($response->id);

        $data = [
            'title' => "Dashboard",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'tutor' => $tutor
        ];
        if ($response) {
            return $this->ResponseBuilder->ReturnViewValidationTeacher(
                $this->session,
                'pages/teacher/dashboard',
                $data
            );
        }
        return $this->ResponseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/validation',
            $data
        );
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
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null)->getResult(),
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
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null)->getResult(),
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

    public function updateTeacher(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $data = [
            'nbm' => $this->request->getVar('nbm'),
            'name' => $this->request->getVar('name'),
            'position' => $this->request->getVar('position'),
            'hp' => $this->request->getVar('hp')
        ];
        try {
            $result = $this->userDetail->updateTeacher($id, $data);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError("update teacher with id " . $id . " failed");
        }
        return $this->respond($response);
    }

    public function findTeacherByTp(): \CodeIgniter\HTTP\Response
    {
        $tp = $this->request->getVar('tp');
        try {
            $result = $this->tutor->findByTp($tp);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }
}