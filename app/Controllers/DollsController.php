<?php

namespace App\Controllers;

use App\Models\DollsModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ToyDetailModel;


class DollsController extends ResourceController
{
    protected $modelName = 'App\Models\DollsModel';
    protected $format    = 'json';

    public function index()
    {
        $dolls = $this->model->findAll();
        return $this->respond([
            'message' => 'All dolls retrieved successfully',
            'data' => $dolls
        ]);
    }

    public function get($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond([
                'message' => 'Doll retrieved successfully',
                'data' => $data
            ]);
        } else {
            return $this->failNotFound('Doll not found');
        }
    }

    public function post()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'message' => 'Doll created successfully',
                'data' => $data
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function patch($id = null)
    {
        $data = $this->request->getRawInput();

        if (!isset($data['material']) || !isset($data['size'])) {
            return $this->failValidationErrors('Required fields missing');
        }
        if ($this->model->update($id, $data)) {
            $doll = $this->model->find($id);
            if ($doll) {
                $toyModel = new ToyDetailModel();
                $toyUpdateData = [
                    'name' => $doll['name'],
                ];
                if ($toyModel->update($doll['toy_id'], (object) $toyUpdateData)) {
                    return $this->respond([
                        'message' => 'Doll and related toy updated successfully',
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
        $doll = $this->model->find($id);

        if ($doll) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted([
                    'message' => 'Doll deleted successfully',
                    'data' => $doll
                ]);
            } else {
                return $this->fail('Failed to delete doll');
            }
        } else {
            return $this->failNotFound('Doll not found');
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