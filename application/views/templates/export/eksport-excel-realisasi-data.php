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
    header("Content-type: application/vnd-ms-excel");

    header("Content-Disposition: attachment; filename=Realisasi Data $cabang ($npsn).xls");
    // 
    ?>
    <div class="container">
        <div class="page-header text-center">
            <h4>DATA REALISASI <?= $npsn; ?>(<?= $cabang; ?>)<br>TOTAL RINGGIT: <?= $total; ?></h4>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th> Kode</th>
                    <th> Nama</th>
                    <th> Total Ringgit</th>
                    <th> Total Rupiah</th>
                    <th> Realisasi Ringgit</th>
                    <th> Realisasi Rupiah</th>
                    <th> Sisa Ringgit</th>
                    <th> Sisa Rupiah</th>
                    <th> Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d) :
                ?>
                    <tr>
                        <td class="str"><?= $d['kodes']; ?></td>
                        <td class="str"><?= $d['nama_aktifitas']; ?></td>
                        <td class="str"><?= number_format($d['total_harga_ringgit'], 0, ',', ','); ?></td>
                        <td class="str"><?= number_format($d['total_harga_rupiah'], 0, '.', '.'); ?></td>
                        <td class="str"><?= number_format($d['harga_ringgit'], 0, ',', ','); ?></td>
                        <td class="str"><?= number_format($d['harga_rupiah'], 0, '.', '.'); ?></td>
                        <td class="str"><?= number_format($d['total_harga_ringgit'] - $d['harga_ringgit'], 0, ',', ','); ?></td>
                        <td class="str"><?= number_format($d['total_harga_rupiah'] - $d['harga_rupiah'], 0, '.', '.'); ?></td>
                        <td class="str"><?= $d['id_realisasi'] ? "Sudah Dibelanjakan" : "Belum Dibelanjakan" ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>