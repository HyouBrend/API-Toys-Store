<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ToyDetailController extends ResourceController
{
    protected $modelName = 'App\Models\ToyDetailModel';
    protected $format    = 'json';
    public function getToyById($id = null)
    {
        if ($id === null) {
            return $this->fail('ID is required', 400);
        }

        $toyDetails = $this->model->getToyDetailsById($id);

        if ($toyDetails) {
            $type = $toyDetails['type'];
            $responseData = [
                'id' => $toyDetails['id'],
                'name' => $toyDetails['name'],
                'type' => $toyDetails['type'],
                'price' => $toyDetails['price'],
                'stock' => $toyDetails['stock'],
                'updated_at' => $toyDetails['updated_at'],
            ];

            switch ($type) {
                case 'Doll':
                    $responseData['material'] = $toyDetails['material'];
                    $responseData['size'] = $toyDetails['size'];
                    break;
                case 'Electronic Toy':
                    $responseData['battery_type'] = $toyDetails['battery_type'];
                    $responseData['voltage'] = $toyDetails['voltage'];
                    break;
                case 'Plastic Toy':
                    $responseData['plastic_type'] = $toyDetails['plastic_type'];
                    $responseData['is_bpa_free'] = $toyDetails['is_bpa_free'];
                    break;
            }

            return $this->respond([
                'message' => 'Toy details retrieved successfully',
                'data' => $responseData
            ]);
        } else {
            return $this->failNotFound('Toy not found');
        }
    }


    public function filter()
    {
        $input = $this->request->getJSON();
        $order = $input->order ?? null;
        $type = $input->type ?? null;
        $query = $this->model;

        if ($type) {
            $query = $query->where('type', $type);
        }

        if ($order === 'highest') {
            $query = $query->orderBy('price', 'DESC');
        } elseif ($order === 'lowest') {
            $query = $query->orderBy('price', 'ASC');
        }

        $toys = $query->findAll();

        return $this->respond([
            'message' => 'Filtered toys retrieved successfully',
            'data' => $toys
        ]);
    }

    public function createToy()
    {
        $input = $this->request->getJSON();

        if (!$input->name || !$input->type || !$input->price || !$input->stock) {
            return $this->fail('All fields are required', 400);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $toyData = [
            'name' => $input->name,
            'type' => $input->type,
            'price' => $input->price,
            'stock' => $input->stock,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $toyId = $this->model->insert($toyData);

        if (!$toyId) {
            $db->transRollback();
            return $this->fail('Failed to create toy', 500);
        }

        switch ($input->type) {
            case 'Doll':
                $dollData = [
                    'toy_id' => $toyId,
                    'material' => $input->material,
                    'size' => $input->size
                ];
                $db->table('Dolls')->insert($dollData);
                break;
            case 'Electronic Toy':
                $electronicToyData = [
                    'toy_id' => $toyId,
                    'battery_type' => $input->battery_type,
                    'voltage' => $input->voltage
                ];
                $db->table('ElectronicToys')->insert($electronicToyData);
                break;
            case 'Plastic Toy':
                $plasticToyData = [
                    'toy_id' => $toyId,
                    'plastic_type' => $input->plastic_type,
                    'is_bpa_free' => $input->is_bpa_free
                ];
                $db->table('PlasticToys')->insert($plasticToyData);
                break;
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return $this->fail('Failed to create toy and its specifications', 500);
        } else {
            $db->transCommit();
            return $this->respondCreated([
                'message' => 'Toy and its specifications created successfully'
            ]);
        }
    }


    public function deleteToy($id = null)
    {
        if ($id === null) {
            return $this->fail('ID is required', 400);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $this->deleteSpecifications($id);

        if (!$this->model->delete($id)) {
            $db->transRollback();
            return $this->fail('Failed to delete toy', 500);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return $this->fail('Failed to delete toy and its specifications', 500);
        } else {
            $db->transCommit();
            return $this->respondDeleted([
                'message' => 'Toy and its specifications deleted successfully'
            ]);
        }
    }

    private function deleteSpecifications($toyId)
    {
        $db = \Config\Database::connect();

        $db->table('Dolls')->where('toy_id', $toyId)->delete();

        $db->table('ElectronicToys')->where('toy_id', $toyId)->delete();

        $db->table('PlasticToys')->where('toy_id', $toyId)->delete();
    }

    public function options()
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->setStatusCode(200);
    }
}
