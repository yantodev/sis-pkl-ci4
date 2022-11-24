<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['email', 'image', 'password', 'role_pkl', 'is_active'];

    public function findUserDetailByEmail($email)
    {
        return $this->db->table('users as u')
            ->select('u.id as id, u.email, u.password, u.role_pkl, u.is_active, ud.id as ids, ud.name, ud.user_id as nis, ud.major_id, ud.tp')
            ->join('user_details as ud', 'u.id = ud.user_public_id')
            ->where('u.email', $email)
            ->get();
    }

    public function findAllSiswa()
    {
        return $this->db->query('
                    select u.id,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp
                    from users u
                             inner join user_details ud on u.id = ud.user_public_id
                             inner join class c on ud.class_id = c.id
                             inner join major m on ud.major_id = m.id
                             inner join master_data md on md.nis = ud.user_id
                             inner join iduka i on i.id = md.iduka_id
                             inner join tp t on t.id = md.tp_id
                    where u.role_pkl = 3;
        ')->getResult();
    }

    public function findAllSiswaByMajor($major)
    {
        return $this->db->query('
                    select u.id,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp
                    from users u
                             inner join user_details ud on u.id = ud.user_public_id
                             inner join class c on ud.class_id = c.id
                             inner join major m on ud.major_id = m.id
                             inner join master_data md on md.nis = ud.user_id
                             inner join iduka i on i.id = md.iduka_id
                             inner join tp t on t.id = md.tp_id
                    where u.role_pkl = 3 and ud.major_id =' . $major
        )->getResult();
    }
}