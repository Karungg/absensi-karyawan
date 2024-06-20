<!DOCTYPE html>
<html>

<head>
    <title>Data Karyawan</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Username</th>
            <th>Nomor Telepon</th>
            <th>Jabatan</th>
        </tr>
        <?php
        $no = 1;
        foreach ($employees as $employee) :
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $employee['nip'] ?></td>
                <td><?= $employee['nama_lengkap'] ?></td>
                <td><?= $employee['email'] ?></td>
                <td><?= $employee['username'] ?></td>
                <td><?= $employee['no_telp'] ?></td>
                <td><?= $employee['nama_jabatan'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>

</body>

</html>