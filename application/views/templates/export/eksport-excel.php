<!DOCTYPE html>

<html>

<head>

	<title>Export Data</title>

</head>

<style>
	.str {
		mso-number-format: \@;
	}

	body {

		font-family: sans-serif;

	}

	table {
		font-family: Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}
</style>



<body>

	<?php
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

	$date = $today_d . " " . $bulan_array[$today_m] . " " . $today_y;

	header("Content-type: application/vnd-ms-excel");

	header("Content-Disposition: attachment; filename=RAB " . $nama_cabang . ".xls");

	?>

	<center>
		<!-- <div class="container"> -->
		<h2>Rencana Anggaran Biaya (RAB) <br>
			Bantuan Operasional CLC Jenjang Sekolah Menengah Pertama (SMP)<br>
			Tahun <?= $today_y; ?></h2>
		<!-- </div> -->
	</center>
	<pre>
    Nama Sekolah    : <?= $cabang['nama']; ?><br>
    Kota            : Kota <?= $laporan['kota']; ?><br>
    Negara          : Malaysia</pre>

	</table>
	<br>
	<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%" border="1">
		<thead>
			<tr>
				<th style="width: 6%;"> Kode Standar</th>
				<th> Uraian</th>
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
				<th> Jumlah (RM)</th>
				<th> Jumlah (Rp)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($isi as $key) : ?>
				<tr>
					<td style="text-align: right;">&nbsp;<?= strval($key['kodes']) ?>&nbsp;</td>
					<td><?= $key['nama_aktifitas'] ?></td>
					<td style="text-align: right;"><?= $key['jumlah_1'] ?></td>
					<td style="text-align: center;"><?= $key['satuan_1'] ?></td>
					<td style="text-align: right;"><?= $key['jumlah_2'] ?></td>
					<td style="text-align: center;"><?= $key['satuan_2'] ?></td>
					<td style="text-align: right;"><?= $key['jumlah_3'] ?></td>
					<td style="text-align: center;"><?= $key['satuan_3'] ?></td>
					<td style="text-align: right;"><?= $key['jumlah_4'] ?></td>
					<td><?= $key['satuan_4'] ?></td>
					<td style="text-align: right;"><?= number_format($key['harga_ringgit'], 0, ',', ',') ?></td>
					<td style="text-align: right;"><?= number_format($key['harga_rupiah'], 0, '.', '.') ?></td>
					<td style="text-align: right;"><?= number_format($key['total_harga_ringgit'], 0, ',', ',') ?></td>
					<td style="text-align: right;"><?= number_format($key['total_harga_rupiah'], 0, '.', '.') ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<table width="100%">
		<tr>
			<td width="30%">
				<pre style="line-height:1em;">
Mengetahui,
Kepala Sekolah
                    </pre>
			</td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="30%">
				<pre style="line-height:1em;">
Kota <?= $laporan['kota']; ?>, <?= $date; ?>

Pemegang Kas
                    </pre>
			</td>
		</tr>
		<tr height="70em"></tr>
		<tr>
			<td width="30%">
				<pre style="line-height:1em;">
<?= $laporan['kepala_nama']; ?>

NIP  <?= $laporan['kepala_nip']; ?>
                    </pre>
			</td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="10%"></td>
			<td width="30%">
				<pre style="line-height:1em;">
<?= $laporan['kas_nama']; ?>

NIP  <?= $laporan['kas_nip']; ?>
                    </pre>
			</td>
		</tr>
	</table>
</body>

</html>