<?php

namespace App\Controllers;

use App\Models\PlasticToysModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ToyDetailModel;

class PlasticToysController extends ResourceController
{
    protected $modelName = 'App\Models\PlasticToysModel';
    protected $format    = 'json';

    public function index()
    {
        $plasticToys = $this->model->findAll();
        return $this->respond([
            'message' => 'All plastic toys retrieved successfully',
            'data' => $plasticToys
        ]);
    }

    public function get($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond([
                'message' => 'Plastic toy retrieved successfully',
                'data' => $data
            ]);
        } else {
            return $this->failNotFound('Plastic toy not found');
        }
    }

    public function post()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'message' => 'Plastic toy created successfully',
                'data' => $data
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function patch($id = null)
    {
        $data = $this->request->getRawInput();

        if (!isset($data['battery_type']) || !isset($data['voltage'])) {
            return $this->failValidationErrors('Required fields missing');
        }

        if ($this->model->update($id, $data)) {
            $electronicToy = $this->model->find($id);
            if ($electronicToy) {
                $toyModel = new ToyDetailModel();
                $toyUpdateData = [
                    'name' => $electronicToy['name'],
                ];
                if ($toyModel->update($electronicToy['toy_id'], (object) $toyUpdateData)) {
                    return $this->respond([
                        'message' => 'Electronic toy and related toy updated successfully',
                        'data' => $data
                    ]);
                } else {
                    return $this->fail('Failed to update related toy');
                }
            }
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        $plasticToy = $this->model->find($id);

        if ($plasticToy) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted([
                    'message' => 'Plastic toy deleted successfully',
                    'data' => $plasticToy
                ]);
            } else {
                return $this->fail('Failed to delete plastic toy');
            }
        } else {
            return $this->failNotFound('Plastic toy not found');
        }
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
