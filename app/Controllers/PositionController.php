<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

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
        $filename = date('y-m-d') . '-paket';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('packages/export_pdf', [
            'packages' => $this->package->findAll()
        ]));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function exportExcel()
    {
        $packages = $this->package->findAll();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama Paket')
            ->setCellValue('B1', 'Deskripsi')
            ->setCellValue('C1', 'Durasi')
            ->setCellValue('D1', 'Harga');

        $column = 2;
        foreach ($packages as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nama_paket'])
                ->setCellValue('B' . $column, $data['deskripsi'])
                ->setCellValue('C' . $column, $data['durasi'])
                ->setCellValue('D' . $column, $data['harga']);
            $column++;
        }
        $writer = new Xls($spreadsheet);
        $fileName = date('d-m-y') . '-paket';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
