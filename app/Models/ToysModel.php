<?php

namespace App\Models;

use CodeIgniter\Model;

class ToysModel extends Model
{
    protected $table      = 'Toys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type', 'price', 'stock', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}