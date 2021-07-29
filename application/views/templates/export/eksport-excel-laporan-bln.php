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
                <td colspan="13"><span class="heading">KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</span></td>
            </tr>
            <tr>
                <td colspan="13"><span class="heading"><b>SEKOLAH INDONESIA KOTA KINABALU</b></span></td>
            </tr>
            <tr>
                <td colspan="13">Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park</td>
            </tr>
            <tr>
                <td colspan="13">Kota Kinabalu, Sabah Malaysia</td>
            </tr>
        </tbody>
    </table>
    <br>
    <hr noshade>
    <center>
        <h4>REKAP REALISASI PENGGUNAAN BANTUAN OPERASIONAL CLC JENJANG SMP <br>
            PERIODE <?= $periode; ?>
        </h4>
    </center>
    <pre>
Nama Sekolah     : <?= $head['nama']; ?> <br>
Kota                   : Kota <?= $laporan['kota']; ?>
Negara                : Malaysia
    </pre>
    <table border="1">
        <thead>
            <tr style="background:#93C5FD;">
                <th rowspan="2">No</th>
                <th rowspan="2">No Urut</th>
                <th rowspan="2">PROGRAM KEAHLIAN</th>
                <th colspan="10">Penggunaan Dana Bantuan Operasional</th>
                <th rowspan="2">Jumlah</th>
            </tr>
            <tr style="background:#93C5FD;">
                <th>Pengembangan Perpustakaan</th>
                <th>PPDB</th>
                <th>Kegiatan pembelajaran dan eskul siswa</th>
                <th>Kegiatan ulangan dan ujian</th>
                <th>Pembelian bahan habis pakai</th>
                <th>Langganan daya dan jasa</th>
                <th>Bantuan Peserta Didik</th>
                <th>Pembiayaan Pengelolaan Bantuan</th>
                <th> Perbaikan/Pengadaan Sarana dan Prasarana Sekolah </th>
                <th>Peningkatan Kompetensi Guru dan Tenaga Kependidikan</th>
            </tr>
            <tr style="background:#E5E7EB;">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>13</td>
                <td>14</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $number = 1;
            foreach ($datas as $data) : ?>
                <tr>
                    <td class="number"><?= $number ?></td>
                    <td><?= $data['no_urut'] ?></td>
                    <td><?= $data['program_keahlian'] ?></td>
                    <td class="rm"><?= $data['penggunaan'][0] ?></td>
                    <td class="rm"><?= $data['penggunaan'][1] ?></td>
                    <td class="rm"><?= $data['penggunaan'][2] ?></td>
                    <td class="rm"><?= $data['penggunaan'][3] ?></td>
                    <td class="rm"><?= $data['penggunaan'][4] ?></td>
                    <td class="rm"><?= $data['penggunaan'][5] ?></td>
                    <td class="rm"><?= $data['penggunaan'][6] ?></td>
                    <td class="rm"><?= $data['penggunaan'][7] ?></td>
                    <td class="rm"><?= $data['penggunaan'][8] ?></td>
                    <td class="rm"><?= $data['penggunaan'][9] ?></td>
                    <td class="rm"><?= $data['jumlah'] ?></td>
                </tr>
            <?php
                $number++;
            endforeach; ?>
        </tbody>
    </table>
    <!-- footer -->
    <br><br>
    <table>
        <tbody>
            <tr>
                <td colspan="3">Mengetahui</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">Kota <?= $laporan['kota']; ?>, <?= $date; ?></td>
            </tr>
            <tr>
                <td colspan="3">Kepala Sekolah</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">Pemegang Kas</td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"><?= $laporan['kepala_nama']; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"><?= $laporan['kas_nama']; ?></td>
            </tr>
            <tr>
                <td colspan="3">NIP. <?= $laporan['kepala_nip']; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">NIP. <?= $laporan['kas_nip']; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>