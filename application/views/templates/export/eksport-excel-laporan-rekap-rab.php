<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        table {
            /* font-family: Arial, Helvetica, sans-serif; */
            border-collapse: collapse;
            width: 100%;
        }

        .heading {
            font-size: 1.2em;
            font-weight: 100;
        }

        .heading-2 {
            font-size: 1.2em;
            font-weight: 600;
        }

        .font-bold {
            font-weight: bold !important;
        }

        .text-justify {
            text-align: justify !important;
        }

        .valign-center {
            vertical-align: center;
        }

        .text-center {
            text-align: center;
        }

        .rm {
            mso-number-format: "_-[$RM-ms-MY]* #,##0_-;-[$RM-ms-MY]* #,##0_-;_-[$RM-ms-MY]* \"0\"_-;_-@_-";
        }
    </style>
</head>

<body>
    <?php
    $file_title = 'REKAPITULASI REALISASI ANGGARAN BANTUAN OPERASIONAL CLC SMPTAHUN ' . $_GET['tahun'];
    header("Content-type: application/vnd-ms-excel");

    header("Content-Disposition: attachment; filename=$file_title.xls");

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
    $td_body = "";
    for ($i = 0; $i < $jml_bulan; $i++) {
        $td_body .= "<td></td>";
    }
    ?>
    <table>
        <tbody>
            <tr>
                <td rowspan="4" colspan="2">
                    <p class="text-center"><img class="valign-center" style="margin-left:1rem;" src="<?= FCPATH . 'assets/img/kinabalu.jpg' ?>" width="100"></p>
                </td>
                <td colspan="<?= $jml_bulan + 1 ?>"><span class="heading">KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</span></td>
            </tr>
            <tr>
                <td colspan="<?= $jml_bulan + 1 ?>"><span class="heading"><b>SEKOLAH INDONESIA KOTA KINABALU</b></span></td>
            </tr>
            <tr>
                <td colspan="<?= $jml_bulan + 1 ?>">Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park</td>
            </tr>
            <tr>
                <td colspan="<?= $jml_bulan + 1 ?>">Kota Kinabalu, Sabah Malaysia</td>
            </tr>
        </tbody>
    </table>
    <hr noshade>

    <center>
        <p class="heading-2">REKAPITULASI REALISASI ANGGARAN BANTUAN OPERASIONAL CLC SMP <br><?= $semester ?> TAHUN <?= $_GET['tahun'] ?> <br></p>
    </center>
    <table border="1">
        <thead>
            <tr style="background:#93C5FD;">
                <th rowspan="2">No</th>
                <th rowspan="2">Nama CLC</th>
                <th rowspan="2">Total Anggaran</th>
                <th colspan="<?= $jml_bulan ?>">Pengeluaran Bulan (RM)</th>
                <th rowspan="2">Jumlah Pengeluaran</th>
                <!-- <th rowspan="2">Saldo</th> -->
            </tr>
            <tr style="background:#93C5FD;">
                <?= $month_column; ?>
            </tr>
            <tr style="background:#E5E7EB; text-align:center;">
                <?php for ($i = 1; $i <= $jml_bulan + 5; $i++) echo "<th>$i</th>"; ?>
            </tr>
            </tbody>
        </thead>
        <tbody><?php
                $no = 1;
                foreach ($rekaps as $rekap) : ?><tr>
                    <td><?= $no; ?></td>
                    <td><?= $rekap['nama']; ?></td>
                    <td class="rm"><?= $rekap['anggaran']; ?></td>
                    <?php for ($i = $month_start; $i <= $month_end; $i++) echo '<td class="rm">' . $rekap['realisasi'][$i] . '</td>'; ?>
                    <td class="rm"><?= $rekap['pengeluaran']; ?></td>
                    <!-- <td class="rm"><?= $rekap['saldo']; ?></td> -->
                </tr><?php $no++;
                    endforeach; ?></tbody>
    </table><br><br>
    <table>
        <tbody>
            <tr>
                <td colspan="4">Mengetahui</td>
                <?= $td_body; ?>
                <td>Kota <?= $laporan['kota']; ?>, <?= $date; ?></td>
            </tr>
            <tr>
                <td colspan="4">Kepala Sekolah</td>
                <?= $td_body; ?>
                <td>Pemegang Kas</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <?= $td_body; ?>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <?= $td_body; ?>
            </tr>
            <tr>
                <td colspan="4"><?= $laporan['kepala_nama']; ?></td>
                <?= $td_body; ?>
                <td><?= $laporan['kas_nama']; ?></td>
            </tr>
            <tr>
                <td colspan="4">NIP. <?= $laporan['kepala_nip']; ?></td>
                <?= $td_body; ?>
                <td>NIP. <?= $laporan['kas_nip']; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>