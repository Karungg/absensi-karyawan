<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class PresenceController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $date = Time::now()->toDateString();
        return view('presences/index', [
            'attendances' => $this->db->query("SELECT * FROM jadwal_absen")->getResultArray(),
            'holiday' => $this->db->query("SELECT * FROM hari_libur WHERE tgl_hari_libur = '$date'")->getResultArray()
        ]);
    }
}
