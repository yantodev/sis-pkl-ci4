<?php

namespace App\Models;

use CodeIgniter\Model;

class IdukaModel extends Model
{
    protected $table = 'iduka';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'major'];

    public function findAllByMajorId($majorId): array
    {
        if (is_null($majorId)) {
            return $this->db->table('iduka i')
                ->select('i.id, i.name, i.major as majorId, di.address, major.name as major')
                ->join('detail_iduka di', 'di.id_iduka = i.id', 'left')
                ->join('major', 'major.id = i.major')
                ->where('i.deleted_at', null)
                ->get()->getResult();
        }
        return $this->db->table('iduka i')
            ->select('i.id, i.name, i.major as majorId, di.address, major.name as major')
            ->join('detail_iduka di', 'di.id_iduka = i.id', 'left')
            ->join('major', 'major.id = i.major')
            ->where('i.major', $majorId)
            ->where('i.deleted_at', null)
            ->get()->getResult();
    }

    public function findAllIdukaByIdAndTp($data): array
    {
        return $this->db->table('master_data md')
            ->distinct('md.iduka_id')
            ->select('i.id, i.name')
            ->join('iduka i', 'md.iduka_id = i.id ')
            ->where('i.major', $data['major'])
            ->where('md.tp_id', $data['tp'])
            ->where('i.deleted_at', null)
            ->orderBy('i.name', 'ASC')
            ->get()->getResult();
    }

    public function findAllIdukaByTp($tp): array
    {
        return $this->db->table('master_data md')
            ->distinct('md.iduka_id')
            ->select('i.id, i.name')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->where('md.tp_id', $tp)
            ->where('i.deleted_at', null)
            ->orderBy('i.name', 'ASC')
            ->get()->getResult();
    }

    public function findAllIdukaByMajor($major): array
    {
        return $this->db->table('iduka')
            ->select('*')
            ->where('major', $major)
            ->where('deleted_at', null)
            ->orderBy('name', 'ASC')
            ->get()->getResult();
    }

    public function findById($id)
    {
        return $this->db->table('iduka i')
            ->select('i.id, i.name, di.address')
            ->join('detail_iduka di', 'di.id_iduka = i.id', 'left')
            ->where('i.id', $id)
            ->where('i.deleted_at', null)
            ->get()->getRow();
    }
}