<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table = 'user_details';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_id', 'nisn', 'name', 'tp', 'jk', 'class_id', 'major_id', 'user_public_id'];
}