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
        return $this->respond($this->model->findAll());
    }

    public function get($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Toy not found');
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
        // Cek apakah ID mainan yang diberikan ada di database
        $toy = $this->model->find($id);
        
        if ($toy) {
            // Jika mainan ditemukan, hapus mainan tersebut
            if ($this->model->delete($id)) {
                // Mengembalikan respon sukses dengan detail mainan yang dihapus
                return $this->respondDeleted([
                    'id' => $id,
                    'message' => 'Toy deleted successfully',
                    'deleted_toy' => $toy
                ]);
            } else {
                return $this->fail('Failed to delete toy');
            }
        } else {
            // Jika mainan tidak ditemukan, kembalikan respon not found
            return $this->failNotFound('Toy not found');
        }
    }
}