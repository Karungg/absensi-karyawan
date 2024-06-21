<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class PositionController extends BaseController
{
    protected $db;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('positions/index', [
            'positions' => $this->db->query('SELECT * FROM jabatan')->getResultArray()
        ]);
    }

    public function create()
    {
        return view('positions/create');
    }

    public function store()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(site_url('positions/create'));
        }

        if (!$this->validate([
            'nama_jabatan' => [
                'rules' => 'required|is_unique[jabatan.nama_jabatan]',
                'errors' => [
                    'required' => 'Kolom Nama Jabatan harus diisi.',
                    'is_unique' => 'Nama Jabatan sudah ada.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('jabatan')->insert([
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ]);

        return redirect()->to(site_url('positions'))->with('success', 'Tambah data jabatan berhasil.');
    }

    public function edit($id)
    {
        $position = $this->db->table('jabatan')
            ->where('id_jabatan', $id)
            ->get()
            ->getResultArray();

        return view('positions/edit', [
            'position' => $position
        ]);
    }

    public function update()
    {
        if (!$this->request->is('put')) {
            return redirect()->to(site_url('positions'));
        }

        if (!$this->validate([
            'nama_jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Nama Jabatan harus diisi.',
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('jabatan')
            ->where('id_jabatan', $this->request->getPost('id_jabatan'))
            ->update([
                'nama_jabatan' => $this->request->getPost('nama_jabatan'),
                'updated_at' => Time::now()
            ]);

        return redirect()->to(site_url('positions'))->with('success', 'Ubah data jabatan berhasil.');
    }

    public function destroy($id)
    {
        $this->db->table('jabatan')->where('id_jabatan', $id)->delete();

        session()->setFlashdata('success', 'Data jabatan berhasil dihapus.');

        return redirect()->to(base_url('positions'));
    }

    public function exportPdf()
    {
        $positions = $this->db->table('jabatan')->countAll();
        if ($positions <= 0) {
            return redirect()->to(site_url('positions'))->with('error', 'Tidak ada data yang dapat diexport.');
        }

        $filename = date('y-m-d') . '-data-jabatan';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('positions/export_pdf', [
            'positions' => $this->db->query('SELECT * FROM jabatan')
                ->getResultArray()
        ]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function exportExcel()
    {
        $positions = $this->db->table('jabatan')->countAll();
        if ($positions <= 0) {
            return redirect()->to(site_url('positions'))->with('error', 'Tidak ada data yang dapat diexport.');
        }

        $positions = $this->db
            ->query('SELECT * FROM jabatan')
            ->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama Jabatan');

        $column = 2;
        foreach ($positions as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nama_jabatan']);
            $column++;
        }
        $writer = new Xls($spreadsheet);
        $filename = date('y-m-d') . '-data-jabatan';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
