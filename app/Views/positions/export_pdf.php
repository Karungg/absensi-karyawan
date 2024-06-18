<!DOCTYPE html>
<html>

<head>
    <title>Data Jabatan</title>
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
            <th>Nama Jabatan</th>
        </tr>
        <?php
        $no = 1;
        foreach ($positions as $position) :
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $position['nama_jabatan'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>

</body>

</html>