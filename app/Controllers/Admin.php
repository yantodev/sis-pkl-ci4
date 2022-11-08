<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\MajorModel;
use App\Models\UsersModel;
use Config\YantoDevConfig;
use ReflectionException;

class  Admin extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->config = new YantoDevConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
    }

    public function index()
    {
        $session = session();
        $data = [
            'title' => "Dashboard",
            'users' => $session->get('name'),
            'role' => $session->get('role'),
        ];
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/dashboard', $data);
    }

    public function master_sekolah()
    {
        $session = session();
        $data = [
            'title' => "Master Sekolah",
            'users' => $session->get('name'),
            'role' => $session->get('role'),
            'sekolah' => $this->schoolModel->find(1)
        ];
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/master-sekolah', $data);
    }

    /**
     * menu master data
     */

    public function iduka()
    {
        $session = session();
        $jurusan = $this->major->findAll();
        $iduka = $this->idukaModel->where(['major' => $this->request->getVar('jurusan')])->findAll();
        $data = [
            'title' => "Iduka",
            'subtitle' => "Data Iduka",
            'role' => $session->get('role'),
            'users' => $session->get('name'),
            'iduka' => $iduka,
            'jurusan' => $jurusan
        ];
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/iduka', $data);
    }

    /*
     * Menu guru
     */
    public function guru()
    {
        $session = session();
        $guru = $this->guruModel->findAll();
        $data = [
            'title' => "Guru",
            'subtitle' => "Data Guru",
            'role' => $session->get('role'),
            'users' => $session->get('name'),
            'guru' => $guru,
        ];
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/guru', $data);
    }


    public function addGuru()
    {
        try {
            $this->guruModel->save([
                'email' => $this->request->getVar('nbm'),
                'nama' => $this->request->getVar('name'),
                'nbm' => $this->request->getVar('nbm'),
                'hp' => $this->request->getVar('hp'),
                'jabatan' => $this->request->getVar('jabatan'),
            ]);
        } catch (ReflectionException $e) {
            dd((array)$e);
        }
    }

    public function updateGuru($id)
    {
        try {
            $this->guruModel->update($id, [
                'nbm' => $this->request->getVar('nbm'),
                'nama' => $this->request->getVar('name'),
                'jabatan' => $this->request->getVar('jabatan'),
                'hp' => $this->request->getVar('hp'),
                'email' => $this->request->getVar('email'),
            ]);
        } catch (ReflectionException $e) {
            dd((array)$e);
        }
    }

    public function deleteGuru()
    {
        $this->guruModel->delete($this->request->getVar('id'));
    }

    public function tp()
    {
        $session = session();
        $data = [
            'title' => "Tahun Pelajaran",
            'subtitle' => "Data Tahun Pelajaran",
            'users' => $session->get('name'),
            'role' => $session->get('role'),
            'tp' => $this->tp->findAll()
        ];
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/tp', $data);
    }

    public function pdf()
    {
        $mpdf = new \Mpdf\Mpdf();
        $html = view('welcome_message', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('arjun.pdf', 'I'); // opens in browser
        //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
    }
}