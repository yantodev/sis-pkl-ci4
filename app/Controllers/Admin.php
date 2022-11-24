<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\KajurModel;
use App\Models\MajorModel;
use App\Models\SuratModel;
use App\Models\TutorModel;
use App\Models\UsersModel;
use Config\YantoDevConfig;
use Mpdf\MpdfException;
use ReflectionException;

/**
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property SuratModel $surat
 * @property KajurModel $kajur
 * @property TutorModel $tutor
 */
class  Admin extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->surat = new SuratModel();
        $this->kajur = new KajurModel();
        $this->tutor = new TutorModel();
    }

    public function index()
    {
        $session = session();
        $data = [
            'title' => "Dashboard",
            'users' => $session->get('email'),
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

    public function data()
    {
        $major = $this->request->getVar('major') ?: false;
        $data = [
            'title' => "Data",
            'subtitle' => "Data Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'siswa' => $major != null ? $this->users->findAllSiswaByMajor($major) : $this->users->findAllSiswa(),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/data-siswa', $data);
    }

    public function pendamping()
    {
        $tp = $this->request->getVar('tp') ?: false;
        $major = $this->request->getVar('major') ?: false;
        $data = [
            'title' => "Data Guru Pendamping",
            'subtitle' => "Guru Pendamping Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tutor' => $major != null ? $this->tutor->findByTpAndMajor($tp, $major) : $this->tutor->findAllBy(),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'teacher' => $this->users->findAllTeacher()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/data-pendamping', $data);
    }

    public function master_sekolah()
    {
        $session = session();
        $data = [
            'title' => "Master Sekolah",
            'users' => $session->get('email'),
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
            'users' => $session->get('email'),
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
            'users' => $session->get('email'),
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
            'users' => $session->get('email'),
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

    public function print()
    {
        $data = [
            'title' => "Cetak",
            'subtitle' => "Cetak Data",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to('/auth/error');
        }
        return view('pages/admin/print', $data);
    }

    /**
     * @throws MpdfException
     */
    public function printApplicationLetter()
    {
        $tp = $this->request->getVar('tp');
        $major = $this->request->getVar('major_id');
        $iduka = $this->request->getVar('iduka');
        $instansi = $this->request->getVar('instansi');
        $surat = $this->surat->findByTp($tp)->getRow();
        $master_data = $this->masterData->findByIdukaAndTp($iduka, $tp, $major)->getResult();
        $kajur = $this->kajur->findByMajor($major)->getRow();
        if ($surat === null) {
            $this->session->setFlashdata('info',
                'Anda belum melengkapi data surat, silahkan lengkapi terlebih dahulu!!!');
            return redirect()->to('/admin/print');
        }
        $data = [
            'iduka' => $this->idukaModel->find($iduka),
            'instansi' => $instansi,
            'surat' => $surat ?: '',
            'master_data' => $master_data,
            'kajur' => $kajur
        ];
        view('pages/general/permohonan1', $data);
        view('pages/general/permohonan2', $data);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/permohonan1', []);
        $mpdf->WriteHTML($html);

        $mpdf->AddPage();
        $mpdf->SetFooter('<p align="left">
                            1 lembar dikirim ke SMK Muh. Karangmojo<br />
                            1 lembar untuk arsip Kepala Kompetensi Keahlian<br />
                            1 lembar untuk arsip IDUKA (Instansi)<br />
                            *) Coret salah satu
                        </p>');
        $html2 = view('pages/general/permohonan2', []);
        $mpdf->WriteHTML($html2);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $iduka = $this->idukaModel->find($iduka);
        $mpdf->Output('Surat Permohonan ' . $iduka["name"] . '. pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function pdf()
    {
        $mpdf = new \Mpdf\Mpdf();
        $html = view('welcome_message', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content - Type', 'application / pdf');
        $mpdf->Output('arjun . pdf', 'I'); // opens in browser
        //$mpdf->Output('arjun . pdf','D'); // it downloads the file into the user system, with give name
    }
}