<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $helpers = ['form', 'url', 'auth', 'setting', 'vite'];

    protected $data = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Tüm view'larda kullanılabilir olacak ortak değişkenler
        // Shield User entity döner (obje), böylece $currentUser->username çalışır
        $this->data['currentUser'] = auth()->user();
    }
}
