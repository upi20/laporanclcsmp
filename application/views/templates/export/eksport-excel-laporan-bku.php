<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cetak Laporan BLN</title>
    <style>
    pre {
        font-family: Arial, Helvetica, sans-serif;
    }

    .number {
        mso-number-format: \#;
    }

    .str {
        mso-number-format: \@;
    }

    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .rm {
        mso-number-format: "_-[$RM-ms-MY]* #,##0_-;-[$RM-ms-MY]* #,##0_-;_-[$RM-ms-MY]* \"0\"_-;_-@_-";
    }
    </style>
</head>

<body>
    <?php

    header("Content-type: application/vnd-ms-excel");

    header("Content-Disposition: attachment; filename=Laporan BLN.xls");

    function changeComa($str)
    {
        // config
        $coma_from = '.';
        $coma_to = ',';
        return str_replace($coma_from, $coma_to, $str);
    }
    $bulan_array = [
        1 => 'Januari',
        2 => 'February',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    $today_m = (int)Date("m");
    $today_d = (int)Date("d");
    $today_y = (int)Date("Y");

    $last_date_of_this_month = $tgl_terakhir = date('t', strtotime(date("Y-m-d")));

    $date = $last_date_of_this_month . " " . $bulan_array[$today_m] . " " . $today_y;
    ?>
    <table>
        <tbody>
            <tr>
                <td rowspan="4" colspan="2">
                    <p class="text-center"><img class="valign-center" style="margin-left:1rem;"
                            src="<?= FCPATH . 'assets/img/kinabalu.jpg' ?>" width="100"></p>
                </td>
                <td colspan="6"><span class="heading">KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</span></td>
            </tr>
            <tr>
                <td colspan="6"><span class="heading"><b>SEKOLAH INDONESIA KOTA KINABALU</b></span></td>
            </tr>
            <tr>
                <td colspan="6">Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park</td>
            </tr>
            <tr>
                <td colspan="6">Kota Kinabalu, Sabah Malaysia</td>
            </tr>
        </tbody>
    </table>
    <br>
    <hr noshade>
    <center>
        <!-- <div class="container"> -->
        <h2>BUKU KAS UMUM <br>
            BANTUAN OPERASIONAL CLC JENJANG SMP <br>
            BULAN JANUARI TAHUN <?= $tahun; ?></h2>
        <!-- </div> -->
    </center>
    <pre>
Nama Sekolah     : <?= $laporan['kota']; ?> <br>
Kota                   : Kota Kinabalu
Negara                : Malaysia<br>
Periode               : <?= $periode; ?>
    </pre>

    <table border="1">
        <thead>
            <tr style="background:#93C5FD;">
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>No. Bukti</th>
                <th>Uraian</th>
                <th>Penerimaan (Debit)</th>
                <th>Pengeluaran (Kredit)</th>
                <th>Saldo</th>
            </tr>
            <tr style="background:#E5E7EB; text-align:center;">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $q) : ?>
            <tr>
                <td><?= $q['no'] ?></td>
                <td class="date"><?= $q['tanggal'] ?></td>
                <td class="str"><?= $q['kode'] ?></td>
                <td><?= $q['no_bukti'] ?></td>
                <td class="str"><?= $q['uraian'] ?></td>
                <?php
                    $debit_class = $q['debit'] == '' ? '' : 'class="rm"';
                    $kredit_class = $q['kredit'] == '' ? '' : 'class="rm"';
                    ?>
                <td <?= $debit_class ?>><?= changeComa($q['debit']) ?></td>
                <td <?= $kredit_class ?>><?= changeComa($q['kredit']) ?></td>
                <td class="rm"><?= changeComa($q['saldo']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- footer -->
    <br><br>
    <table>
        <tbody>
            <tr>
                <td colspan="2">Mengetahui</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Kota <?= $laporan['kota']; ?>, <?= $date; ?></td>
            </tr>
            <tr>
                <td colspan="2">Kepala Sekolah</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Pemegang Kas</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><?= $laporan['kepala_nama']; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $laporan['kas_nama']; ?></td>
            </tr>
            <tr>
                <td colspan="2">NIP. <?= $laporan['kepala_nip']; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>NIP. <?= $laporan['kas_nip']; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>