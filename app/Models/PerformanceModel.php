<?php

namespace App\Models;

use CodeIgniter\Model;

class PerformanceModel extends Model
{
    protected $table = 'performance';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employee_id', 'employee_name', 'period', 'score', 'rating', 'notes'];
    protected $useTimestamps = true;
}

