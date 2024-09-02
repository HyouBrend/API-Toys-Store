<?php

namespace App\Models;

use CodeIgniter\Model;

class ToyDetailModel extends Model
{
    protected $table = 'Toys'; // Nama tabel di database
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'type',
        'price',
        'stock',
        'updated_at'
    ];

    // Mendapatkan detail mainan berdasarkan ID
    public function getToyDetailsById($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Toys');

        $builder->select('Toys.*, Dolls.material, Dolls.size, ElectronicToys.battery_type, ElectronicToys.voltage, PlasticToys.plastic_type, PlasticToys.is_bpa_free');
        $builder->join('Dolls', 'Dolls.toy_id = Toys.id', 'left');
        $builder->join('ElectronicToys', 'ElectronicToys.toy_id = Toys.id', 'left');
        $builder->join('PlasticToys', 'PlasticToys.toy_id = Toys.id', 'left');
        $builder->where('Toys.id', $id);

        return $builder->get()->getRowArray();
    }
}