<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'class';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'tp', 'is_active', 'major_id'];

    public function findAllByMajor($major): array
    {
        return $this->db->table('class')
            ->select('*')
            ->where('major_id', $major)
            ->get()->getResult();
    }

    public function findAllBy($getVar): array
    {
        return $this->db->table('class')
            ->select('*')
            ->where('is_active', 1)
            ->get()->getResult();
    }
}