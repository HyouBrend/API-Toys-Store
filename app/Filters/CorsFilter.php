<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CorsFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');

        // Set header CORS
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Jika permintaan adalah OPTIONS, kirim respons langsung
        if ($request->getMethod() === 'options') {
            $response->setStatusCode(200);
            $response->send(); // Kirim respons segera
            exit; // Hentikan eksekusi script lebih lanjut
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}