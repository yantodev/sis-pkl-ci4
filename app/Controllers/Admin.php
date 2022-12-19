<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\KajurModel;
use App\Models\KategoriSuratModel;
use App\Models\MajorModel;
use App\Models\NomorSuratModel;
use App\Models\SuratModel;
use App\Models\TeacherModel;
use App\Models\TutorModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use Config\APIResponseBuilder;
use Config\IApplicationConstantConfig;
use Config\YantoDevConfig;
use Mpdf\MpdfException;
use ReflectionException;

/**
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property APIResponseBuilder $ResponseBuilder
 * @property IApplicationConstantConfig $IApplicationConstant
 */
class  Admin extends BaseController
{
    use ResponseTrait;

    protected $usersModel;
    private TeacherModel $teacher;
    private SuratModel $surat;
    private KajurModel $kajur;
    private TutorModel $tutor;
    private KategoriSuratModel $kategoriSurat;
    private NomorSuratModel $nomorModel;

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->surat = new SuratModel();
        $this->kajur = new KajurModel();
        $this->tutor = new TutorModel();
        $this->teacher = new TeacherModel();
        $this->kategoriSurat = new KategoriSuratModel();
        $this->nomorModel = new NomorSuratModel();
    }

    public function index()
    {
        $session = session();
        $data = [
            'title' => "Dashboard",
            'users' => $session->get('email'),
            'role' => $session->get('role'),
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/dashboard',
            $data
        );
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

        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/data-student-pkl',
            $data
        );
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
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
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
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/master-sekolah', $data);
    }

    /**
     * menu master data
     */

    public function iduka()
    {
        $majorId = $this->request->getVar('jurusan');
        $jurusan = $this->major->findAll();
        $iduka = $this->idukaModel->findAllByMajorId($majorId);
        $data = [
            'title' => "Iduka",
            'subtitle' => "Data Iduka",
            'role' => $this->session->get('role'),
            'users' => $this->session->get('email'),
            'iduka' => $iduka,
            'jurusan' => $jurusan
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
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
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
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

    public function nomor()
    {
        $id = $this->request->getVar('id');
        $tp = $this->request->getVar('tp');
        $category = $this->request->getVar('category');
        $nomor = $this->request->getVar('nomor');
        $tgl = $this->request->getVar('tgl');
        if ($tp && $category && $nomor && $tgl) {
            $request = [
                'nomor' => $nomor,
                'tanggal' => $tgl,
                'tp_id' => $tp,
                'kategori_surat_id' => $category
            ];
            if ($id) {
                try {
                    $result = $this->nomorModel->update($id, $request);
                    $response = $this->ResponseBuilder->ok($result);
                    return $this->respond($response);
                } catch (ReflectionException $e) {
                    $this->session->setFlashdata('error', $e);
                }
            } else {
                try {
                    $this->nomorModel->insert($request);
                    $this->session->setFlashdata('success', 'tambah nomor surat berhasil');
                    return redirect()->to('admin/nomor');
                } catch (ReflectionException $e) {
                    $this->session->setFlashdata('error', $e);
                }
            }

        } elseif ($id) {
            $result = $this->nomorModel->findAllById($id);
            $response = $this->ResponseBuilder->ok($result);
            return $this->respond($response);
        }
        $data = [
            'title' => "Nomor Surat",
            'subtitle' => "Data Nomor Surat",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tp' => $this->tp->findAll(),
            'category' => $this->kategoriSurat->findAll(),
            'data' => $this->nomorModel->findAllBy()
        ];

        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/nomor-surat',
            $data
        );
    }

    public function deleteNomor(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $result = $this->nomorModel->delete($id);
        $response = $this->ResponseBuilder->ok($result);
        return $this->respond($response);
    }

    public function tp()
    {
        $data = [
            'title' => "Tahun Pelajaran",
            'subtitle' => "Data Tahun Pelajaran",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tp' => $this->tp->findAll()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/tp', $data);
    }

    public function teacher()
    {
        $data = [
            'title' => "Guru",
            'subtitle' => "Data Guru",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findAllTeacher()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/data-teacher', $data);
    }

    public function student()
    {
        $data = [
            'title' => "Siswa",
            'subtitle' => "Data Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findAllStudent()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/data-student', $data);
    }

    public function users()
    {
        $data = [
            'title' => "Users",
            'subtitle' => "Data Users",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findAllByDetail()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/data-users', $data);
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
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
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
        $masterData = $this->masterData->findByIdukaAndTp($iduka, $tp);
        $kajur = $this->kajur->findByMajor($major)->getRow();
        if ($surat === null) {
            $this->session->setFlashdata(
                'info',
                'Anda belum melengkapi data surat, silahkan lengkapi terlebih dahulu!!!'
            );
            return redirect()->to('/admin/print');
        }
        $data = [
            'iduka' => $this->idukaModel->findById($iduka),
            'instansi' => $instansi,
            'surat' => $surat ?: '',
            'master_data' => $masterData,
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
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $iduka = $this->idukaModel->find($iduka);
        $mpdf->Output('Surat Permohonan ' . $iduka["name"] . '.pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function printAssignmentLetter()
    {
        $tp = $this->request->getVar('tp-tugas');
        $teacherId = $this->request->getVar('teacher');
        $result = $this->teacher->findByUserPublicId($teacherId);
        $iduka = $this->tutor->findByTeacherIdAndTp($teacherId, $tp);
        $data = [
            'result' => $result,
            'surat' => $this->surat->findByTp($tp)->getRow(),
            'data' => $this->masterData->findByIdukaAndTp($iduka->id, $tp)
        ];
        view('pages/general/cetak-surat-tugas', $data);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-surat-tugas', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Tugas ' . $result->name . '. pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function printCoveringLetter()
    {
        $tp = $this->request->getVar('tp2');
        $major = $this->request->getVar('major_id2');
        $result = $this->major->find($major);
        $data = [
            'instansi' => $this->request->getVar('instansi'),
            'result' => $result,
            'surat' => $this->surat->findByTp($tp)->getRow(),
//            'data' => $this->masterData->findByIdukaAndTp($iduka->id, $tp)
        ];
        view('pages/general/cetak-surat-pengantar', $data);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-surat-pengantar', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Pengantar.pdf', 'I');
    }
}