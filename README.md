# Project Absensi Karyawan

## Deskripsi

Project absensi karyawan adalah hasil riset pada salah satu perusahaan di bogor yang beroperasi di bidang manufaktur. Tujuan pembuatan project ini adalah sebagai saran untuk perusahaan tersebut untuk metode absensi karyawan yang lebih baik dan efisien menggunakan website.

## Fitur Utama Berdasarkan Role (Admin, Karyawan)
1. **Admin**
    - Manajemen data karyawan
    - Manajemen hari libur
    - Manajemen jabatan
    - Manajemen kehadiran
    - Membuat laporan kehadiran
2. **Karyawan**
    - Melakukan kehadiran

## 🛠️ Techstack
![Code-Igniter](https://img.shields.io/badge/CodeIgniter-%23EF4223.svg?style=for-the-badge&logo=codeIgniter&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white) 	![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)

## 🛠️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal:

1. **Clone repository**
```bash
git clone https://github.com/Karungg/absensi-karyawan.git
cd absensi-karyawan
```
2. **Install dependensi menggunakan composer**
```
composer install
```
3. **Copy .env**
```
cp env .env
```
4. **Ubah konfigurasi pada file .env sesuai kebutuhan**
```
database.default.hostname = 
database.default.database = 
database.default.username = 
database.default.password = 
database.default.DBDriver = 
database.default.DBPrefix =
database.default.port = 
```
5. **Jalankan migrasi dan seeder**
```
php spark migrate --all
php spark db:seed DatabaseSeeder
```
6. **Jalankan aplikasi**
```
php spark serve
```
Buka aplikasi di browser <a href="http://localhost:8080/">http://localhost:8080</a>

👨‍💻 Developer
Created with ❤️ by <a href="https://github.com/Karungg">Karungg</a>

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](<a href="https://github.com/Karungg/absensi-karyawan?tab=MIT-1-ov-file">LICENSE</a>).
