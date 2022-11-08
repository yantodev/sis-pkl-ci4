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
}