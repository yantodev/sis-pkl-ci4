<?php

namespace App\Models;

use CodeIgniter\Model;

class DataLaporanSiswaModal extends Model
{
    protected $table = 'data_laporan_siswa';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_public_id', 'master_laporan_id', 'master_sub_laporan_id', 'master_sub_laporan_1_id', 'major_id', 'date'];

    public function findByUserPublicId($id): array
    {
        return $this->db->query("
                select dls.id,
                       dls.date,
                       ml.name   as bidang_pekerjaan,
                       msl.text  as uraian_1,
                       msl1.text as uraian_2
                from data_laporan_siswa dls
                         inner join master_laporan ml
                                    on dls.master_laporan_id = ml.id
                         inner join master_sub_laporan msl
                                    on dls.master_sub_laporan_id = msl.id
                         left join master_sub_laporan_1 msl1
                                   on dls.master_sub_laporan_1_id = msl1.id
                         inner join major m on dls.major_id = m.id
                where dls.user_public_id =  $id
                order by dls.date ASC
        ")->getResult();
    }
}