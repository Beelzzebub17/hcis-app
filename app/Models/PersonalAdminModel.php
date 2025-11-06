<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalAdminModel extends Model
{
    protected $table = 'personal_admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nik', 'nama', 'divisi', 'jabatan', 'email', 'phone', 'status'];
    protected $useTimestamps = true;
}

