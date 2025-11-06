<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseRequisitionModel extends Model
{
    protected $table = 'purchase_requisitions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pr_number', 'description', 'requester', 'department', 'total_price', 'status'];
    protected $useTimestamps = true;
}

