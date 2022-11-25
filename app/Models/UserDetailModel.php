<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table = 'user_details';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_id', 'nisn', 'name', 'tp', 'jk', 'class_id', 'major_id', 'user_public_id'];

    public function findById($id)
    {
        return $this->db->table('users u')
            ->select(
                'ud.name, ud.user_id as nis, ud.nisn, ud.tp as tpId,
                 m.id as majorId, m.name as major,
                c.id as classId, c.name as kelas,
                i.id as idukaId, i.name as iduka,
                tp.name as tp
                ')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('major m', 'm.id = ud.major_id')
            ->join('class c', 'c.id = ud.class_id')
            ->join('master_data md', 'md.nis = ud.user_id')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->join('tp', 'tp.id = md.tp_id')
            ->where('ud.id', $id)
            ->get()->getRow();
    }
}