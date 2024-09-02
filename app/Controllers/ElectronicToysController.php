<?php

namespace App\Controllers;

use App\Models\ElectronicToysModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ToyDetailModel;

class ElectronicToysController extends ResourceController
{
    protected $modelName = 'App\Models\ElectronicToysModel';
    protected $format    = 'json';

    public function index()
    {
        $electronicToys = $this->model->findAll();
        return $this->respond([
            'message' => 'All electronic toys retrieved successfully',
            'data' => $electronicToys
        ]);
    }

    public function get($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond([
                'message' => 'Electronic toy retrieved successfully',
                'data' => $data
            ]);
        } else {
            return $this->failNotFound('Electronic toy not found');
        }
    }

    public function post()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'message' => 'Electronic toy created successfully',
                'data' => $data
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function patch($id = null)
    {
        $data = $this->request->getRawInput();

        if (!isset($data['plastic_type']) || !isset($data['is_bpa_free'])) {
            return $this->failValidationErrors('Required fields missing');
        }

        if ($this->model->update($id, $data)) {
            $plasticToy = $this->model->find($id);
            if ($plasticToy) {
                $toyModel = new ToyDetailModel();
                $toyUpdateData = [
                    'name' => $plasticToy['name'],
                ];

                if ($toyModel->update($plasticToy['toy_id'], (object) $toyUpdateData)) {
                    return $this->respond([
                        'message' => 'Plastic toy and related toy updated successfully',
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
        $electronicToy = $this->model->find($id);

        if ($electronicToy) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted([
                    'message' => 'Electronic toy deleted successfully',
                    'data' => $electronicToy
                ]);
            } else {
                return $this->fail('Failed to delete electronic toy');
            }
        } else {
            return $this->failNotFound('Electronic toy not found');
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