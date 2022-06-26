<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model {

    protected $table = 'tbl_jurusan';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['jurusan', 'singkatan_jurusan', 'kelompok'];
}