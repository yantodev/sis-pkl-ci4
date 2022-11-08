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
}