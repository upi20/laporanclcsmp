<!DOCTYPE html>

<html>

<head>
    <title>Export Data</title>
    <style>
        .str {
            mso-number-format: \@;
        }

        .number {
            mso-number-format: \#;
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
    // header("Content-type: application/vnd-ms-excel");

    // header("Content-Disposition: attachment; filename=RAB " . $ket['nama'] . " (" . $ket['kode'] . ").xls");
    ?>
    <div class="container">
        <div class="page-header text-center">
            <h4>LAPORAN RENCANA ANGGARAN <?= $ket['nama']; ?> (<?= $ket['kode']; ?>)<br></h4>
        </div>
        <table border="1">
            <thead>
                <tr>
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
                        <td class="str"><?= $d['uraian']; ?></td>
                        <td class="str"><?= $d['kodes']; ?></td>
                        <td class="str"><?= $d['nama_aktifitas']; ?></td>
                        <td class="number"><?= $d['jumlah_1']; ?></td>
                        <td class="str"><?= $d['satuan_1']; ?></td>
                        <td class="number"><?= $d['jumlah_2']; ?></td>
                        <td class="str"><?= $d['satuan_2']; ?></td>
                        <td class="number"><?= $d['jumlah_3']; ?></td>
                        <td class="str"><?= $d['satuan_3']; ?></td>
                        <td class="number"><?= $d['jumlah_4']; ?></td>
                        <td class="str"><?= $d['satuan_4']; ?></td>
                        <td class="str"><?= number_format($d['harga_ringgit'], 0, ',', ','); ?></td>
                        <td class="str"><?= number_format($d['harga_rupiah'], 0, '.', '.'); ?></td>
                        <td class="str"><?= number_format($d['total_harga_ringgit'], 0, ',', ','); ?></td>
                        <td class="str"><?= number_format($d['total_harga_rupiah'], 0, '.', '.'); ?></td>
                        <td class="str"><?= $d['prioritas']; ?></td>
                        <td class="str"><?= $d['statuss']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>