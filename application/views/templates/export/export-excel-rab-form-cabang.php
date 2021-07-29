<!DOCTYPE html>

<html>

<head>
    <title>Export Data</title>
    <style>
        .str {
            mso-number-format: \@;
        }

        .number {
            /* mso-number-format: \#; */
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    header("Content-type: application/vnd-ms-excel");

    header("Content-Disposition: attachment; filename=RAB " . $ket['nama'] . " (" . $ket['kode'] . ").xls");
    ?>
    <div class="container">
        <div class="page-header text-center">
            <h4>FORM LAPORAN RENCANA ANGGARAN <?= $ket['nama']; ?> (<?= $ket['kode']; ?>)<br></h4>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th> No</th>
                    <th> Aktifitas</th>
                    <th> Kode Sub Aktifitas</th>
                    <th> Nama Sub Aktifitas</th>
                    <th> Jumlah</th>
                    <th> Satuan</th>
                    <th> Jumlah</th>
                    <th> Satuan</th>
                    <th> Jumlah</th>
                    <th> Satuan</th>
                    <th> Jumlah</th>
                    <th> Satuan</th>
                    <th> Ringgit</th>
                    <th> Rupiah</th>
                    <th> Total Ringgit</th>
                    <th> Total Rupiah</th>
                    <th> Prioritas</th>
                    <th> Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td class="str">no</td>
                        <td class="str"><?= $d['uraian']; ?></td>
                        <td class="str"><?= $d['kodes']; ?></td>
                        <td class="str"><?= $d['nama_aktifitas']; ?></td>
                        <td><?= $d['jumlah_1']; ?></td>
                        <td class="str"><?= $d['satuan_1']; ?></td>
                        <td><?= $d['jumlah_2']; ?></td>
                        <td class="str"><?= $d['satuan_2']; ?></td>
                        <td><?= $d['jumlah_3']; ?></td>
                        <td class="str"><?= $d['satuan_3']; ?></td>
                        <td><?= $d['jumlah_4']; ?></td>
                        <td class="str"><?= $d['satuan_4']; ?></td>
                        <td><?= $d['harga_ringgit']; ?></td>
                        <td><?= $d['harga_rupiah']; ?></td>
                        <td><?= $d['total_harga_ringgit']; ?></td>
                        <td><?= $d['total_harga_rupiah']; ?></td>
                        <td><?= $d['prioritas']; ?></td>
                        <td><?= $d['statuss']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>