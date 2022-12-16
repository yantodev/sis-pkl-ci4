<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teacher';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'nbm', 'hp', 'position', 'user_public_id'];

    public function findByUserPublicId($teacherId)
    {
        return $this->db->table('teacher')
            ->select('*')
            ->where('user_public_id', $teacherId)
            ->get()->getRow();
    }
}