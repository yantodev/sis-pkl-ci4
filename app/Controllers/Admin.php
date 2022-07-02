<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\UsersModel;

class  Admin extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $session = session();
        $data = [
            'title' => "Dashboard",
            'users' => $session->get('name'),
            'role' => $session->get('role_id'),
        ];
        if (!$session->get('logged_in'))
            return redirect()->to('/auth');
        return view('pages/admin/dashboard', $data);
    }

    public function master_sekolah(){
        $session = session();
        $data = [
            'title' => "Master Sekolah",
            'users' => $session->get('name'),
            'role' => $session->get('role_id'),
        ];
        if (!$session->get('logged_in'))
            return redirect()->to('/auth');
        return view('pages/admin/master-sekolah', $data);
}

    /**
     * menu master data
     */

    public function iduka()
    {
        $session = session();
        $jurusan = $this->jurusanModel->findAll();
        $iduka = $this->idukaModel->where(['jurusan' => $this->request->getVar('jurusan')])->findAll();
        $data = [
            'title' => "Iduka",
            'subtitle' => "Data Iduka",
            'role' => $session->get('role_id'),
            'users' => $session->get('name'),
            'iduka' => $iduka,
            'jurusan' => $jurusan
        ];
        if (!$session->get('logged_in'))
            return redirect()->to('/auth');
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
            'role' => $session->get('role_id'),
            'users' => $session->get('name'),
            'guru' => $guru,
        ];
        if (!$session->get('logged_in'))
            return redirect()->to('/auth');
        return view('pages/admin/guru', $data);
    }

        public function addGuru()
        {
            $this->guruModel->save([
                'email'=> $this->request->getVar('nbm'),
                'nama' => $this->request->getVar('name'),
                'nbm' => $this->request->getVar('nbm'),
                'hp' => $this->request->getVar('hp'),
                'jabatan' => $this->request->getVar('jabatan'),
            ]);
        }

    public function updateGuru($id)
    {
        $this->guruModel->update($id, [
            'nbm' => $this->request->getVar('nbm'),
            'nama' => $this->request->getVar('name'),
            'jabatan' => $this->request->getVar('jabatan'),
            'hp' => $this->request->getVar('hp'),
            'email' => $this->request->getVar('email'),
        ]);
    }
    public function deleteGuru($id)
    {
        $this->guruModel->delete($id);
    }

    public function pdf()
    {
        $mpdf = new \Mpdf\Mpdf(['mode'=>'utf-8']);
        $html = view('welcome_message',[]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('arjun.pdf','I'); // opens in browser
        //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
        //return view('welcome_message');
    }
}