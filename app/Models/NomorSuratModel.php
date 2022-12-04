<?php

namespace App\Models;

use CodeIgniter\Model;

class NomorSuratModel extends Model
{
    protected $table = 'tbl_nomor_surat';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['jenis', 'nomor', 'tgl_surat'];
}