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

    public function findAllIdukaById($id, $tp)
    {
        return $this->db->query('
            select distinct i.id, i.name
            from master_data as md
            inner join iduka i on md.iduka_id = i.id
            where i.major = ' . $id . '
            and md . tp_id = ' . $tp . '
            order by i . name ASC
        ');
    }

    public function findAllIdukaByTp($tp)
    {
        return $this->db->query('
            select distinct i.id, i.name
            from master_data as md
            inner join iduka i on md.iduka_id = i.id
            and md . tp_id = ' . $tp . '
            order by i . name ASC
        ');
    }
}