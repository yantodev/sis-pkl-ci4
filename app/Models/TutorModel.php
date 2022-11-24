<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorModel extends Model
{
    protected $table = 'tutor';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['tp_id', 'teacher_id', 'iduka_id'];
}