<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterDataModel extends Model
{
    protected $table = 'master_data';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nis', 'iduka_id', 'tp_id'];

    public function findByNis($nis)
    {
        return $this->db->table('master_data')
            ->select('*')
            ->where('nis', $nis)
            ->get();
    }
}