<?php

namespace App\Models;

use CodeIgniter\Model;

class ElectronicToysModel extends Model
{
    protected $table      = 'ElectronicToys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['toy_id', 'battery_type', 'voltage', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}