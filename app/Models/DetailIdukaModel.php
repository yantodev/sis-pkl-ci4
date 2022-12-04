<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailIdukaModel extends Model
{
    protected $table = 'iduka';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_iduka', 'name', 'address','email', 'telp','mentor','nip','position','email_mentor','hp_mentor','tp'];
}