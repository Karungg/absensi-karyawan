<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use Myth\Auth\Password;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class EmployeeController extends BaseController
{
    protected $db;

    protected $auth;

    protected $config;

    protected $helpers = ['form'];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->config = config('auth');
        $this->auth = service('authentication');
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

    public function show($id)
    {
        $employee = $this->db
            ->query("SELECT users.id, users.username, users.nama_lengkap, users.email, users.no_telp, users.nip, jabatan.nama_jabatan FROM users JOIN jabatan ON users.id_jabatan=jabatan.id_jabatan WHERE users.id = $id")
            ->getResultArray();

        return view('employees/show', [
            'employee' => $employee
        ]);
    }

    public function store()
    {
        $users = model(UserModel::class);

        $rules = [
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
            'username' => [
                'rules' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Kolom Username harus diisi.',
                    'is_unique' => 'Username sudah tersedia.',
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
            'no_telp' => [
                'rules' => 'required|is_unique[users.no_telp]|numeric|min_length[10]',
                'errors' => [
                    'required' => 'Kolom Nomor Telepon harus diisi.',
                    'is_unique' => 'Nomor Telepon sudah tersedia.',
                    'numeric' => 'Nomor Telepon harus berisi angka.',
                    'min_length' => 'Nomor Telepon harus berisi minimal 10 angka.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => 'Kolom Password harus diisi.',
                    'min_length' => 'Nomor Password berisi minimal 4 angka.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->to(site_url('employees'))->with('success', 'Tambah data karyawan berhasil.');
        }

        // Success!
        return redirect()->to(site_url('employees'))->with('success', 'Tambah data karyawan berhasil.');
    }

    public function edit($id)
    {
        $employee = $this->db->table('users')
            ->where('id', $id)
            ->get()
            ->getResultArray();

        return view('employees/edit', [
            'employee' => $employee,
            'positions' => $this->db
                ->query('SELECT * FROM jabatan')
                ->getResultArray()
        ]);
    }

    public function update()
    {
        if (!$this->request->is('put')) {
            return redirect()->to(site_url('employees'));
        }

        if (!$this->validate([
            'nip' => [
                'rules' => 'required|min_length[18]|numeric',
                'errors' => [
                    'required' => 'Kolom NIP harus diisi.',
                    'min_length' => 'Kolom NIP harus berisi minimal 18 digit.',
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
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Kolom Email harus diisi.',
                    'valid_email' => 'Kolom Email harus berisi format email.',
                ]
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom Username harus diisi.',
                ]
            ],
            'no_telp' => [
                'rules' => 'required|numeric|min_length[10]',
                'errors' => [
                    'required' => 'Kolom Nomor Telepon harus diisi.',
                    'numeric' => 'Nomor Telepon harus berisi angka.',
                    'min_length' => 'Nomor Telepon harus berisi minimal 10 angka.',
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $passwordBeforeHash = $this->request->getPost('password');
        if (strlen($passwordBeforeHash) == 0) {
            $passwordBeforeHash = "12345678";
        }
        $password_hash = Password::hash($passwordBeforeHash);

        $this->db->table('users')
            ->where('id', $this->request->getPost('id'))
            ->update([
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'no_telp' => $this->request->getPost('no_telp'),
                'id_jabatan' => $this->request->getPost('positions'),
                'nip' => $this->request->getPost('nip'),
                'password_hash' => $password_hash,
                'updated_at' => Time::now()
            ]);

        return redirect()->to(site_url('employees'))->with('success', 'Ubah data karyawan berhasil.');
    }

    public function destroy($id)
    {
        if ($id == user_id()) {
            return redirect()->to(site_url('employees'))->with('error', 'Anda tidak dapat menghapus data anda sendiri.');
        }

        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->db->table('users')->where('id', $id)->delete();

        session()->setFlashdata('success', 'Data karyawan berhasil dihapus.');

        return redirect()->to(base_url('employees'));
    }

    public function exportPdf()
    {
        $filename = date('y-m-d') . '-data-karyawan';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('employees/export_pdf', [
            'employees' => $this->db
                ->query('SELECT users.id, users.username, users.nama_lengkap, users.email, users.no_telp, users.nip, jabatan.nama_jabatan FROM users JOIN jabatan ON users.id_jabatan=jabatan.id_jabatan')
                ->getResultArray()
        ]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function exportExcel()
    {
        $employees = $this->db
            ->query('SELECT users.id, users.username, users.nama_lengkap, users.email, users.no_telp, users.nip, jabatan.nama_jabatan FROM users JOIN jabatan ON users.id_jabatan=jabatan.id_jabatan')
            ->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NIP')
            ->setCellValue('B1', 'Nama Lengkap')
            ->setCellValue('C1', 'Email')
            ->setCellValue('D1', 'Username')
            ->setCellValue('E1', 'Nomor Telepon')
            ->setCellValue('F1', 'Jabatan');

        $column = 2;
        foreach ($employees as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nip'])
                ->setCellValue('B' . $column, $data['nama_lengkap'])
                ->setCellValue('C' . $column, $data['email'])
                ->setCellValue('D' . $column, $data['username'])
                ->setCellValue('E' . $column, $data['no_telp'])
                ->setCellValue('F' . $column, $data['nama_jabatan']);
            $column++;
        }
        $writer = new Xls($spreadsheet);
        $filename = date('y-m-d') . '-data-karyawan';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
