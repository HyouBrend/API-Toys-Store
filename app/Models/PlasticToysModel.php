<?php

namespace App\Models;

use CodeIgniter\Model;

class PlasticToysModel extends Model
{
    protected $table      = 'PlasticToys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['toy_id', 'plastic_type', 'is_bpa_free', 'created_at', 'updated_at'];
    protected $useTtimestamps = true;
}