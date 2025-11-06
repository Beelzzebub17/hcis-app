<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingDevModel extends Model
{
    protected $table = 'training_dev';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'duration', 'instructor', 'start_date', 'end_date', 'status'];
    protected $useTimestamps = true;
}

