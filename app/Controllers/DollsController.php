<?php

namespace App\Controllers;

use App\Models\DollsModel;
use CodeIgniter\RESTful\ResourceController;

class DollsController extends ResourceController
{
    protected $modelName = 'App\Models\DollsModel';
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
            return $this->failNotFound('Doll not found');
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
        $doll = $this->model->find($id);
        
        if ($doll) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted([
                    'id' => $id,
                    'message' => 'Doll deleted successfully',
                    'deleted_doll' => $doll
                ]);
            } else {
                return $this->fail('Failed to delete doll');
            }
        } else {
            return $this->failNotFound('Doll not found');
        }
    }
}