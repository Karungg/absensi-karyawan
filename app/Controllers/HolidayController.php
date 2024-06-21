<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class HolidayController extends BaseController
{
    protected $db;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('holidays/index', [
            'holidays' => $this->db->query('SELECT * FROM hari_libur')->getResultArray()
        ]);
    }

    public function create()
    {
        return view('holidays/create');
    }

    public function store()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(site_url('holidays/create'));
        }

        if (!$this->validate([
            'nama_hari_libur' => [
                'rules' => 'required|is_unique[hari_libur.nama_hari_libur]',
                'errors' => [
                    'required' => 'Kolom Nama Hari Libur harus diisi.',
                    'is_unique' => 'Nama Hari Libur sudah ada.'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Keterangan harus diisi.',
                ]
            ],
            'tgl_hari_libur' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Tanggal Hari Libur harus diisi.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('hari_libur')->insert([
            'nama_hari_libur' => $this->request->getPost('nama_hari_libur'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tgl_hari_libur' => $this->request->getPost('tgl_hari_libur'),
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ]);

        return redirect()->to(site_url('holidays'))->with('success', 'Tambah data hari libur berhasil.');
    }

    public function edit($id)
    {
        $holiday = $this->db->table('hari_libur')
            ->where('id_hari_libur', $id)
            ->get()
            ->getResultArray();

        return view('holidays/edit', [
            'holiday' => $holiday
        ]);
    }

    public function update()
    {
        if (!$this->request->is('put')) {
            return redirect()->to(site_url('holidays'));
        }

        if (!$this->validate([
            'nama_hari_libur' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Nama Hari Libur harus diisi.',
                    'is_unique' => 'Nama Hari Libur sudah ada.'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Keterangan harus diisi.',
                ]
            ],
            'tgl_hari_libur' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Tanggal Hari Libur harus diisi.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('hari_libur')
            ->where('id_hari_libur', $this->request->getPost('id_hari_libur'))
            ->update([
                'nama_hari_libur' => $this->request->getPost('nama_hari_libur'),
                'keterangan' => $this->request->getPost('keterangan'),
                'tgl_hari_libur' => $this->request->getPost('tgl_hari_libur'),
                'updated_at' => Time::now()
            ]);

        return redirect()->to(site_url('holidays'))->with('success', 'Ubah data hari libur berhasil.');
    }

    public function destroy($id)
    {
        $this->db->table('hari_libur')->where('id_hari_libur', $id)->delete();

        session()->setFlashdata('success', 'Data hari libur berhasil dihapus.');

        return redirect()->to(base_url('holidays'));
    }

    public function exportPdf()
    {
        $holidays = $this->db->table('hari_libur')->countAll();
        if ($holidays <= 0) {
            return redirect()->to(site_url('holidays'))->with('error', 'Tidak ada data yang dapat diexport.');
        }

        $filename = date('y-m-d') . '-data-hari-libur';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('holidays/export_pdf', [
            'holidays' => $this->db->query('SELECT * FROM hari_libur')
                ->getResultArray()
        ]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function exportExcel()
    {
        $holidays = $this->db->table('hari_libur')->countAll();
        if ($holidays <= 0) {
            return redirect()->to(site_url('holidays'))->with('error', 'Tidak ada data yang dapat diexport.');
        }

        $holidays = $this->db
            ->query('SELECT * FROM hari_libur')
            ->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama Hari Libur')
            ->setCellValue('B1', 'Keterangan')
            ->setCellValue('C1', 'Tanggal Hari Libur');

        $column = 2;
        foreach ($holidays as $data) {
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
