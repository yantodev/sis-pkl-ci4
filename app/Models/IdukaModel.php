<?php

namespace App\Models;

use CodeIgniter\Model;

class IdukaModel extends Model
{
    protected $table = 'iduka';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'address', 'major'];

    public function findAllByMajorId($major_id)
    {
        return $this->db->table('iduka')
            ->select('*')
            ->where('major', $major_id)
            ->get();
    }

    public function findAllIdukaByIdAndTp($major, $tp): array
    {
        return $this->db->table('master_data md')
            ->distinct('md.iduka_id')
            ->select('i.id, i.name')
            ->join('iduka i', 'md.iduka_id = i.id ')
            ->where('i.major', $major)
            ->where('md.tp_id', $tp)
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
            ->orderBy('i.name', 'ASC')
            ->get()->getResult();
    }

    public function findAllIdukaByMajor($major): array
    {
        return $this->db->table('iduka')
            ->select('*')
            ->where('major', $major)
            ->orderBy('name', 'ASC')
            ->get()->getResult();
    }
}