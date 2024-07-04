<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    protected $db;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        $positionId = $this->db->table('jabatan')
            ->select('jabatan.id_jabatan')
            ->join('users', 'users.id_jabatan = jabatan.id_jabatan')
            ->where('users.id', user_id())
            ->get()
            ->getResultArray();

        $attendances = $this->db->table('jadwal_absen')
            ->join('detail_jadwal_absen', 'detail_jadwal_absen.id_jadwal_absen = jadwal_absen.id_jadwal_absen')
            ->join('jabatan', 'jabatan.id_jabatan = detail_jadwal_absen.id_jabatan')
            ->join('users', 'users.id_jabatan = jabatan.id_jabatan')
            ->where('users.id_jabatan', $positionId[0])
            ->get()
            ->getResultArray();

        return view('home/index', [
            'attendances' => $attendances
        ]);
    }
}
