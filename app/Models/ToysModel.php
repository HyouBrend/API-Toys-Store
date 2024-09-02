<?php

namespace App\Models;

use CodeIgniter\Model;

class ToysModel extends Model
{
    protected $table      = 'Toys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type', 'price', 'stock', 'created_at', 'updated_at'];

    // Menggunakan timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}