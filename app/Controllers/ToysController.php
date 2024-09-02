<?php

namespace App\Controllers;

use App\Models\ToysModel;
use CodeIgniter\RESTful\ResourceController;

class ToysController extends ResourceController
{
    protected $modelName = 'App\Models\ToysModel';
    protected $format    = 'json';

    public function index()
    {
        $toys = $this->model->findAll();
        return $this->respond([
            'message' => 'All toys retrieved successfully',
            'data' => $toys
        ]);
    }

    public function get($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond([
                'message' => 'Toy retrieved successfully',
                'data' => $data
            ]);
        } else {
            return $this->failNotFound('Toy not found');
        }
    }

    public function post()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'message' => 'Toy created successfully',
                'data' => $data
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function patch($id = null)
    {
        if ($id === null) {
            return $this->fail('ID is required', 400);
        }

        $data = $this->request->getRawInput();

        if (empty($data)) {
            return $this->failValidationErrors('No data provided to update');
        }

        $toy = $this->model->find($id);
        if (!$toy) {
            return $this->failNotFound('Toy not found');
        }

        $updatedData = array_merge($toy, $data);

        if ($this->model->update($id, $updatedData)) {
            $updatedToy = $this->model->find($id);
            return $this->respond([
                'message' => 'Toy updated successfully',
                'data' => $updatedToy
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }


    public function delete($id = null)
    {
        $toy = $this->model->find($id);

        if ($toy) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted([
                    'message' => 'Toy deleted successfully',
                    'data' => $toy
                ]);
            } else {
                return $this->fail('Failed to delete toy');
            }
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

    public function options()
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->setStatusCode(200);
    }
}