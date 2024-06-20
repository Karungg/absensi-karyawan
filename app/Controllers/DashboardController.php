<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        return view('dashboard/index', [
            'title' => 'Dashboard',
            'employees' => $this->db->table('users')->countAll(),
            'positions' => $this->db->table('jabatan')->countAll()
        ]);
    }
}
