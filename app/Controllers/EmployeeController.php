<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Password;

class EmployeeController extends BaseController
{
    protected $db;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $employees = $this->db
            ->query('SELECT users.id, users.nama_lengkap, users.email, users.no_telp, users.nip, jabatan.nama_jabatan FROM users JOIN jabatan ON users.id_jabatan=jabatan.id_jabatan')
            ->getResultArray();

        return view('employees/index', [
            'employees' => $employees
        ]);
    }

    public function create()
    {
        return view('employees/create', [
            'positions' => $this->db
                ->query('SELECT * FROM jabatan')
                ->getResultArray()
        ]);
    }

    public function store()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(site_url('employees/create'));
        }

        if (!$this->validate([
            'nip' => [
                'rules' => 'required|min_length[18]|is_unique[users.nip]|numeric',
                'errors' => [
                    'required' => 'Kolom NIP harus diisi.',
                    'min_length' => 'Kolom NIP harus berisi minimal 18 digit.',
                    'is_unique' => 'NIP sudah tersedia.',
                    'numeric' => 'Kolom NIP harus berisi angka.',
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Nama Lengkap harus diisi.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Kolom Email harus diisi.',
                    'valid_email' => 'Kolom Email harus berisi format email.',
                    'is_unique' => 'Email sudah tersedia.',
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Kolom Username harus diisi.',
                    'is_unique' => 'Username sudah tersedia.',
                ]
            ],
            'no_telp' => [
                'rules' => 'required|is_unique[users.no_telp]|numeric|min_length[10]',
                'errors' => [
                    'required' => 'Kolom Nomor Telepon harus diisi.',
                    'is_unique' => 'Nomor Telepon sudah tersedia.',
                    'numeric' => 'Nomor Telepon harus berisi angka.',
                    'min_length' => 'Nomor Telepon harus berisi minimal 10 angka.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        // Get latest id
        $last_id = $this->db->table('users')
            ->select('id')->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->getResultArray();

        $password = $this->request->getPost('password') ?? '12345678';
        $password_hash = Password::hash($password);

        $this->db->table('users')->insert([
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'no_telp' => $this->request->getPost('no_telp'),
            'id_jabatan' => $this->request->getPost('positions'),
            'id_jabatan' => $this->request->getPost('positions'),
            'nip' => $this->request->getPost('nip'),
            'password_hash' => $password_hash,
            'active' => '1',
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ]);

        // Insert groups user
        $this->db->table('auth_groups_users')->insert([
            'group_id' => 2,
            'user_id' => $last_id[0]['id'] + 1
        ]);

        return redirect()->to(site_url('employees'))->with('success', 'Tambah data karyawan berhasil.');
    }

    public function edit($id)
    {
        $position = $this->db->table('jabatan')
            ->where('id_jabatan', $id)
            ->get()
            ->getResultArray();

        return view('employees/edit', [
            'position' => $position
        ]);
    }

    public function update()
    {
        if (!$this->request->is('put')) {
            return redirect()->to(site_url('employees'));
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

        return redirect()->to(site_url('employees'))->with('success', 'Ubah data jabatan berhasil.');
    }

    public function destroy($id)
    {
        $this->db->table('jabatan')->where('id_jabatan', $id)->delete();

        session()->setFlashdata('success', 'Data jabatan berhasil dihapus.');

        return redirect()->to(base_url('employees'));
    }

    public function exportPdf()
    {
        $filename = date('y-m-d') . '-data-jabatan';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('employees/export_pdf', [
            'employees' => $this->db->query('SELECT * FROM jabatan')
                ->getResultArray()
        ]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function exportExcel()
    {
        $employees = $this->db
            ->query('SELECT * FROM jabatan')
            ->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama Jabatan');

        $column = 2;
        foreach ($employees as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nama_jabatan']);
            $column++;
        }
        $writer = new Xls($spreadsheet);
        $fileName = date('d-m-y') . '-data-jabatan';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
