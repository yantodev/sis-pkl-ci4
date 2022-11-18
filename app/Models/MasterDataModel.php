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

    public function findByIdukaAndTp($iduka, $tp, $major)
    {
        return $this->db->query('
                select ud.name    as name,
                       ud.user_id as nis,
                       i.name     as iduka,
                       ud.jk,
                       m.name     as jurusan,
                       c.name     as kelas
                from master_data as md
                         inner join user_details as ud on md.nis = ud.user_id
                         inner join iduka i on md.iduka_id = i.id
                         inner join major m on i.major = m.id
                         left join class c on ud.class_id = c.id
                where md.iduka_id = ' . $iduka . ' 
                    and md.tp_id = ' . $tp . '
                    and md.iduka_id = ' . $major
        );
    }
}