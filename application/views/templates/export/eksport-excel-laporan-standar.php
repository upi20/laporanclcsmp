<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .str {
            mso-number-format: \@;
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
    header("Content-type: application/vnd-ms-excel");

    header("Content-Disposition: attachment; filename=Laporan Standar.xls");
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
                    <p class="text-center"><img class="valign-center" style="margin-left:1rem;" src="<?= FCPATH . 'assets/img/kinabalu.jpg' ?>" width="100"></p>
                </td>
                <td colspan="3"><span class="heading">KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</span></td>
            </tr>
            <tr>
                <td colspan="3"><span class="heading"><b>SEKOLAH INDONESIA KOTA KINABALU</b></span></td>
            </tr>
            <tr>
                <td colspan="3">Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park</td>
            </tr>
            <tr>
                <td colspan="3">Kota Kinabalu, Sabah Malaysia</td>
            </tr>
        </tbody>
    </table>
    <hr noshade>
    <center>
        <p class="heading-2">
            REKAPITULASI PENGGUNAAN BANTUAN OPERASIONAL CLC JENJANG SMP <br>
            PENGEMBANGAN STANDAR SARANA PRASARANA <br>
            TAHUN <?= $tahun; ?> <br>
        </p>
    </center>
    <pre>
Nama Sekolah    : <?= $cabang['nama']; ?><br>
Kota            : Kota <?= $laporan['kota']; ?> <br>
Negara          : Malaysia<br>
Periode         : <?= $periode; ?>
    </pre>
    <table border="1">
        <thead>
            <tr height="35" style="background:#93C5FD;">
                <th></i> No</th>
                <th></i> Tanggal</th>
                <th></i> Kode</th>
                <th></i> Uraian</th>
                <th> RM</th>
            </tr>
            <tr style="background:#E5E7EB; text-align:center;">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1;
            $total_jumlah = (float)0;
            foreach ($standar as $s) : ?>
                <tr>
                    <td><?= $nomor ?></td>
                    <td><?= $s['tanggal'] ?></td>
                    <td class="str"><?= $s['kode'] ?></td>
                    <td><?= $s['uraian'] ?></td>
                    <td class="rm"><?= $s['harga_ringgit'] ?></td>
                </tr>
            <?php
                $total_jumlah += $s['harga_ringgit'];
                $nomor++;
            endforeach; ?>
            <tr>
                <td colspan="4" style="text-align: center">Jumlah</td>
                <td class="rm"><?= $total_jumlah ?></td>
            </tr>
        </tbody>
    </table>
    <br><br>
    <table>
        <tbody>
            <tr>
                <td colspan="2">Mengetahui</td>
                <td></td>
                <td></td>
                <td>Kota <?= $laporan['kota']; ?>, <?= $date; ?></td>
            </tr>
            <tr>
                <td colspan="2">Kepala Sekolah</td>
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
            </tr>
            <tr>
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
                <td><?= $laporan['kas_nama']; ?></td>
            </tr>
            <tr>
                <td colspan="2">NIP. <?= $laporan['kepala_nip']; ?></td>
                <td></td>
                <td></td>
                <td>NIP. <?= $laporan['kas_nip']; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>