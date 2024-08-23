<?php

namespace App\Controllers;

use App\Models\ElectronicToysModel;
use CodeIgniter\RESTful\ResourceController;

class ElectronicToysController extends ResourceController
{
    protected $modelName = 'App\Models\ElectronicToysModel';
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
            return $this->failNotFound('Electronic Toy not found');
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
        $electronicToy = $this->model->find($id);
        
        if ($electronicToy) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted([
                    'id' => $id,
                    'message' => 'Electronic Toy deleted successfully',
                    'deleted_electronic_toy' => $electronicToy
                ]);
            } else {
                return $this->fail('Failed to delete electronic toy');
            }
        } else {
            return $this->failNotFound('Electronic Toy not found');
        }
    }
}