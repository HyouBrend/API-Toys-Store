<?php

namespace App\Controllers;

use App\Models\PlasticToysModel;
use CodeIgniter\RESTful\ResourceController;

class PlasticToysController extends ResourceController
{
    protected $modelName = 'App\Models\PlasticToysModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function get($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Plastic Toy not found');
        }
    }

    public function post()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function patch($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond($data);
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
                    'id' => $id,
                    'message' => 'Plastic Toy deleted successfully',
                    'deleted_plastic_toy' => $plasticToy
                ]);
            } else {
                return $this->fail('Failed to delete plastic toy');
            }
        } else {
            return $this->failNotFound('Plastic Toy not found');
        }
    }
}