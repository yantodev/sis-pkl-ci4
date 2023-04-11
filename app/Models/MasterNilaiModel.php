<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterNilaiModel extends Model
{
    protected $table = 'master_nilai';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_public_id', 'nilai_1', 'nilai_2', 'nilai_3', 'nilai_4', 'nilai_5', 'nilai_6', 'nilai_7', 'nilai_8', 'nilai_9', 'nilai_10', 'nilai_11'];

    public function findByMajorId(mixed $majorId): array
    {
        if ($majorId) {
            return $this->db->table("master_category_nilai")
                ->select("*")
                ->where("major", $majorId)
                ->get()->getResult();
        }
        return [];
    }

    public function findAllByUserPublicId($userPublicId): array
    {
        if ($userPublicId) {
            return $this->db->table('master_nilai')
                ->select('*')
                ->where('user_public_id', $userPublicId)
                ->get()->getResult();
        }
        return [];
    }

    public function findByUserPublicId(mixed $id)
    {
        if ($id) {
            return $this->db->table('master_nilai')
                ->select('*')
                ->where('user_public_id', $id)
                ->get()->getRow();
        }
        return [];
    }
}