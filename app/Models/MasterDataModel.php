<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterDataModel extends Model
{
    protected $table = 'master_data';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_public_id', 'nis', 'iduka_id', 'tp_id', 'status', 'image'];

    public function findByNis($nis)
    {
        return $this->db->table('master_data')
            ->select('*')
            ->where('nis', $nis)
            ->get();
    }

    public function findByIdukaAndTp($iduka, $tp): array
    {
        return $this->db->query('
                select ud.name    as name,
                       ud.user_id as nis,
                       i.name     as iduka,
                       ud.jk,
                       m.name     as jurusan,
                       c.name     as kelas,
                       di.address as alamat
                from master_data md
                        inner join user_details as ud on md.nis = ud.user_id
                        inner join iduka i on md.iduka_id = i.id
                        inner join major m on i.major = m.id
                        inner join class c on ud.class_id = c.id
                        left join detail_iduka di on di.id_iduka = i.id
                where md.deleted_at is null 
                    and md.user_public_id is not null
                    and md.iduka_id = ' . $iduka . ' 
                    and md.tp_id = ' . $tp
        )->getResult();
    }

    public function updateByNis($nis, $id): bool
    {
        return $this->db->query('
                update master_data
                set iduka_id = ' . $id . ',
                    status   = null
                where nis = ' . $nis
        )->getRow();
    }

    public function updateByDataNis($nis, array $data): bool
    {
        return $this->db->table('master_data')
            ->set('user_public_id', $data['id'])
            ->set('tp_id', $data['tpId'])
            ->where('nis', $nis)
            ->update();
    }

    public function findByTpAndMajor($tp, $major): array
    {
        if ($tp && $major) {
            $response = $this->db->table('master_data md')
                ->select('
                            md.id, md.status, ud.name, i.id as idukaId, i.name as idukaName,
                            ud.user_id as nis, ud.jk, class.name as kelas, m.name as majorName,
                            di.address, tp.name as tpName, teacher.name as teacherName, teacher.hp, surat.detail_tgl')
                ->join('tp', 'tp.id = md.tp_id')
                ->join('iduka i', 'i.id = md.iduka_id')
                ->join('detail_iduka di', 'di.id_iduka = i.id', 'left')
                ->join('major m', 'm.id = i.major')
                ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
                ->join('class', 'class.id = ud.class_id', 'left')
                ->join('tutor', 'tutor.iduka_id = i.id', 'left')
                ->join('teacher', 'teacher.user_public_id = tutor.teacher_id', 'left')
                ->join('tbl_surat surat', 'surat.id_tp = md.tp_id', 'left')
                ->where('tutor.deleted_at', null)
                ->where('md.tp_id', $tp)
                ->where('m.id', $major)
                ->orderBy('ud.user_id', 'ASC')
                ->orderBy('i.name', 'ASC')
                ->get()->getResult();
        } else {
            $response = $this->db->query('
                    select md.id,
                           md.status,
                           ud.name,
                           i.id       as idukaId,
                           i.name     as idukaName,
                           ud.user_id as nis,
                           c.name as kelas,
                           m.name     as majorName,
                           di.address,
                           t.name    as tpName
                    from master_data md
                             inner join tp t on md.tp_id = t.id
                             inner join iduka i on md.iduka_id = i.id
                             left join detail_iduka di on md.iduka_id = di.id_iduka
                             inner join major m on i.major = m.id
                             inner join user_details ud on md.user_public_id = ud.user_public_id
                             left join class c on ud.class_id = c.id
                    order by i.name ASC
            ')->getResult();
        }
        return $response;
    }

    public function findById($id)
    {
        return $this->db->table('master_data md')
            ->select('md . id, md . image,
                            ud . name, ud . user_id as nis,
                            i . name as iduka,
                            di . address')
            ->join('user_details ud', 'ud . user_public_id = md . user_public_id')
            ->join('iduka i', 'i . id = md . iduka_id')
            ->join('detail_iduka di', 'di . id_iduka = md . iduka_id')
            ->where('md . id', $id)
            ->get()->getRow();
    }

    public function findByUserPublicId($id)
    {
        return $this->db->table('master_data md')
            ->select('md . id, md . image, md . status,
                            ud . name, ud . user_id as nis,
                            i . name as iduka,
                            di . address,
                            teacher . name as teacher, teacher . hp')
            ->join('user_details ud', 'ud . user_public_id = md . user_public_id')
            ->join('iduka i', 'i . id = md . iduka_id')
            ->join('detail_iduka di', 'di . id_iduka = md . iduka_id')
            ->join('tutor', 'tutor . iduka_id = i . id', 'left')
            ->join('teacher', 'teacher . user_public_id = tutor . teacher_id', 'left')
            ->where('md . user_public_id', $id)
            ->where('tutor . deleted_at', null)
            ->get()->getRow();
    }

    public function findByTp($tp): array
    {
        return $this->db->query('
                select distinct md.iduka_id,
                                md.iduka_id as id,
                                i.name,
                                i.major,
                                di.address
                from master_data md
                        inner join iduka i on md.iduka_id = i.id
                        inner join detail_iduka di on i.id = di.id_iduka
                where md.deleted_at is null
                  and md.user_public_id is not null
                  and md.tp_id = ' . $tp . '
                order by i.major ASC
        ')->getResult();
    }
}