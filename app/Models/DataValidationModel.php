<?php

namespace App\Models;

use CodeIgniter\Model;

class DataValidationModel extends Model
{
    protected $table = 'data_validation';
    protected $primaryKey = 'id';
    protected $allowedFields = ['check_item', 'description', 'total', 'status', 'last_check'];
    protected $useTimestamps = true;
}

