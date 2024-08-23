<?php

namespace App\Models;

use CodeIgniter\Model;

class DollsModel extends Model
{
    protected $table      = 'Dolls';
    protected $primaryKey = 'id';
    protected $allowedFields = ['toy_id', 'material', 'size', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}