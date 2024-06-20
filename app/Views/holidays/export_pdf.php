<!DOCTYPE html>
<html>

<head>
    <title>Data Hari Libur</title>
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
            <th>Nama Hari Libur</th>
            <th>Keterangan</th>
            <th>Tanggal Hari Libur</th>
        </tr>
        <?php
        $no = 1;
        foreach ($holidays as $holiday) :
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $holiday['nama_hari_libur'] ?></td>
                <td><?= $holiday['keterangan'] ?></td>
                <td><?= $holiday['tgl_hari_libur'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>

</body>

</html>