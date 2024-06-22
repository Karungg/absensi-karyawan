<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class AttendanceController extends BaseController
{
    protected $db;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('attendances/index', [
            'attendances' => $this->db->query('SELECT * FROM jadwal_absen')->getResultArray()
        ]);
    }

    public function create()
    {
        return view('attendances/create', [
            'positions' => $this->db->query("SELECT * FROM jabatan")->getResultArray()
        ]);
    }

    public function store()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(site_url('attendances/create'));
        }

        if (!$this->validate([
            'nama_jadwal' => [
                'rules' => 'required|is_unique[jadwal_absen.nama_jadwal]',
                'errors' => [
                    'required' => 'Kolom Nama Absensi harus diisi.',
                    'is_unique' => 'Nama Absensi sudah ada.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Keterangan harus diisi.',
                ]
            ],
            'jam_masuk' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Absen Masuk harus diisi.',
                    'valid_date' => 'Kolom Absen Masuk harus diisi sesuai format.',
                ]
            ],
            'batas_jam_masuk' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Batas Absen Masuk harus diisi.',
                    'valid_date' => 'Kolom Batas Absen Masuk harus diisi sesuai format.',
                ]
            ],
            'jam_pulang' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Absen Pulang harus diisi.',
                    'valid_date' => 'Kolom Absen Pulang harus diisi sesuai format.',
                ]
            ],
            'batas_jam_pulang' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Batas Absen Pulang harus diisi.',
                    'valid_date' => 'Kolom Batas Absen Pulang harus diisi sesuai format.',
                ]
            ],
            'id_jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Jabatan harus diisi.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $attendance = new \App\Models\Attendance();
        $attendance->insert([
            'nama_jadwal' => $this->request->getPost('nama_jadwal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'batas_jam_masuk' => $this->request->getPost('batas_jam_masuk'),
            'jam_pulang' => $this->request->getPost('jam_pulang'),
            'batas_jam_pulang' => $this->request->getPost('batas_jam_pulang'),
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ]);

        $attendanceId = $attendance->getInsertID();
        $positionId = $this->request->getPost('id_jabatan');

        $this->db->table('detail_jadwal_absen')->insert([
            'id_jadwal_absen' => $attendanceId,
            'id_jabatan' => $positionId
        ]);

        return redirect()->to(site_url('attendances'))->with('success', 'Tambah data absensi berhasil.');
    }

    public function edit($id)
    {
        $attendance = $this->db->table('jadwal_absen')
            ->where('id_jadwal_absen', $id)
            ->get()
            ->getResultArray();

        $positions = $this->db->query("SELECT * FROM jabatan")->getResultArray();

        return view('attendances/edit', [
            'attendance' => $attendance,
            'positions' => $positions
        ]);
    }

    public function update()
    {
        if (!$this->request->is('put')) {
            return redirect()->to(site_url('attendances'));
        }

        if (!$this->validate([
            'nama_jadwal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Nama Absensi harus diisi.',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Keterangan harus diisi.',
                ]
            ],
            'jam_masuk' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Absen Masuk harus diisi.',
                    'valid_date' => 'Kolom Absen Masuk harus diisi sesuai format.',
                ]
            ],
            'batas_jam_masuk' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Batas Absen Masuk harus diisi.',
                    'valid_date' => 'Kolom Batas Absen Masuk harus diisi sesuai format.',
                ]
            ],
            'jam_pulang' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Absen Pulang harus diisi.',
                    'valid_date' => 'Kolom Absen Pulang harus diisi sesuai format.',
                ]
            ],
            'batas_jam_pulang' => [
                'rules' => 'required|valid_date[H:i]',
                'errors' => [
                    'required' => 'Kolom Batas Absen Pulang harus diisi.',
                    'valid_date' => 'Kolom Batas Absen Pulang harus diisi sesuai format.',
                ]
            ],
            'id_jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Jabatan harus diisi.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('jadwal_absen')
            ->where('id_jadwal_absen', $this->request->getPost('id_jadwal_absen'))
            ->update([
                'nama_jadwal' => $this->request->getPost('nama_jadwal'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
                'batas_jam_masuk' => $this->request->getPost('batas_jam_masuk'),
                'jam_pulang' => $this->request->getPost('jam_pulang'),
                'batas_jam_pulang' => $this->request->getPost('batas_jam_pulang'),
                'updated_at' => Time::now()
            ]);

        return redirect()->to(site_url('attendances'))->with('success', 'Ubah data absensi berhasil.');
    }

    public function destroy($id)
    {
        $this->db->table('jadwal_absen')->where('id_jadwal_absen', $id)->delete();

        session()->setFlashdata('success', 'Data absensi berhasil dihapus.');

        return redirect()->to(base_url('attendances'));
    }

    public function exportPdf()
    {
        $attendances = $this->db->table('jadwal_absen')->countAll();
        if ($attendances <= 0) {
            return redirect()->to(site_url('attendances'))->with('error', 'Tidak ada data yang dapat diexport.');
        }

        $filename = date('y-m-d') . '-data-hari-libur';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('attendances/export_pdf', [
            'attendances' => $this->db->query('SELECT * FROM jadwal_absen')
                ->getResultArray()
        ]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function exportExcel()
    {
        $attendances = $this->db->table('hari_libur')->countAll();
        if ($attendances <= 0) {
            return redirect()->to(site_url('attendances'))->with('error', 'Tidak ada data yang dapat diexport.');
        }

        $attendances = $this->db
            ->query('SELECT * FROM hari_libur')
            ->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama Hari Libur')
            ->setCellValue('B1', 'Keterangan')
            ->setCellValue('C1', 'Tanggal Hari Libur');

        $column = 2;
        foreach ($attendances as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nama_hari_libur'])
                ->setCellValue('B' . $column, $data['keterangan'])
                ->setCellValue('C' . $column, $data['tgl_hari_libur']);
            $column++;
        }
        $writer = new Xls($spreadsheet);
        $filename = date('y-m-d') . '-data-hari-libur';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
