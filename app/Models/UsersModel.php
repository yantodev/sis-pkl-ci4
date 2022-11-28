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

    public function findAllSiswa(): array
    {
        return $this->db->query('
                    select ud.id,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp,
                           md.id as masterDataId
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

    public function findAllSiswaByMajor($major): array
    {
        return $this->db->query('
                    select ud.id,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp,
                           md.id as masterDataId
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

    public function findAllTeacher(): array
    {
        return $this->db->table('users u')
            ->select('u.id,
                       u.email,
                       u.image,
                       ud.id as userDetailId,
                       ud.name,
                       t.nbm, t.hp, t.position')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('teacher t', 'u.id = t.user_public_id')
            ->where('u.role_pkl', 2)
            ->orderBy('t.name', 'ASC')
            ->get()->getResult();
    }

    public function findAllStudent(): array
    {
        return $this->db->table('users u')
            ->select('u.id,
                            u.email, 
                            ud.id as userDetailId, ud.name, ud.user_id as nis, ud.nisn,
                            c.id as classId, c.name as kelas,
                            m.id as majorId, m.name as jurusan')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('class c', 'c.id = ud.class_id')
            ->join('major m', 'm.id = ud.major_id')
            ->where('u.role_pkl', 3)
            ->get()->getResult();
    }

    public function findTeacherById($id): array
    {
        return $this->db->table('users u')
            ->select('u.email,
                       u.image,
                       ud.id,
                       ud.name,
                       t.nbm, t.hp, t.position')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('teacher t', 'u.id = t.user_public_id')
            ->where('u.role_pkl', 2)
            ->where('ud.id', $id)
            ->orderBy('t.name', 'ASC')
            ->get()->getResult();
    }

}