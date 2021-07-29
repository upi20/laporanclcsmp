<!-- MAIN CONTENT -->
<div id="content">

	<!-- row -->
	<div class="row">

		<!-- col -->
		<div class="col-xs-12 col-sm-7">
			<h1 class="page-title txt-color-blueDark" style="font-weight:bold; text-transform: unset;">
				<!-- PAGE HEADER -->
				<i class="fa-fw fa fa-table"></i>

				<?= $title ?>
			</h1>
		</div>
		<!-- end col -->

	</div>
	<!-- end row -->

	<!--
		The ID "widget-grid" will start to initialize all widgets below
		You do not need to use widgets if you dont want to. Simply remove
		the <section></section> and you can use wells or panels instead
		-->

	<!-- widget grid -->
	<section id="widget-grid" class="">

		<!-- row -->
		<div class="row">

			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					</header>

					<!-- widget div-->
					<div>
						<form action="<?= base_url() ?>monitoring" method="get">
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label for="tanggal">Paket Soal</label>
										<select class="form-control" name="paket_soal">
											<option value="">--Pilih Paket Soal--</option>
											<?php foreach ($soal as $ps) : ?>
												<option <?= isset($_GET['tanggal']) && $_GET['paket_soal'] == $ps['id'] ? 'selected' : '' ?> value="<?= $ps['id'] ?>"><?= $ps['nama'] . ' ' . $ps['token'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label for="tanggal">Tanggal</label>
										<input type="date" class="form-control" name="tanggal" placeholder="Tanggal" value="<?= isset($_GET['tanggal']) ? $_GET['tanggal'] : '' ?>" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button class="btn btn-primary">Filter</button>
									</div>
								</div>
							</div>
						</form>
						<hr>
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							<input class="form-control" type="text">
						</div>
						<!-- end widget edit box -->

						<!-- widget content -->
						<div class="widget-body">
							<?php
							$mengerjakan = $record_where(' a.status = 1 ')->num_rows();
							$selesai = $record_where(' a.status = 0 ')->num_rows();
							$belum = $record_where(' a.status IS NULL ')->num_rows();
							?>
							<?php if (isset($_GET['tanggal'])) : ?>
							<?php else : ?>
								<p>Mengerjakan <?= $mengerjakan ?></p>
								<p>Selesai <?= $selesai ?></p>
								<p>Belum Mengerjakan <?= $belum ?></p>
							<?php endif ?>
							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> User Id</th>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> nama</th>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Paket Soal</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Token</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Waktu Login</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Lama Waktu Mengerjakan</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Status</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Data Jawaban</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Jumlah Soal Terjawab</th>
										<!-- <th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Aksi</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($record->result_array() as $r) : ?>
										<tr>
											<td><?= $r['id'] ?></td>
											<td><?= $r['nama'] ?></td>
											<td><?= $r['mapel'] . ' ' . $r['token'] ?></td>
											<td><?= $r['token'] ?></td>
											<td><?= $r['mulai'] ?></td>
											<td><?= $r['lama_pengerjaan'] ?></td>
											<td><?php if ($r['status'] == '0') {
													echo 'Selesai';
												} elseif ($r['status'] == 1) {
													echo 'Mengerjakan';
												} else {
													echo 'Belum Mengerjakan';
												} ?></td>
											<?php
											$detail = $jawaban_detail($r['idjawaban']);

											$detail = $detail->result_array();
											?>
											<td>
												<?php
												if (count($detail) > 0) {
													$jawaban = [];
													foreach ($detail as $d) {
														array_push($jawaban, $d['jawaban_pilihan_ganda']);
													}

													echo implode($jawaban, ',');
												}
												?>
											</td>
											<td><?= count($detail) ?></td>
											<!-- <td>
												<button class="btn btn-warning">Reset</button>
											</td> -->
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<!-- end widget content -->

					</div>
					<!-- end widget div -->

				</div>
				<!-- end widget -->

			</article>
			<!-- WIDGET END -->

		</div>

		<!-- end row -->

		<!-- row -->

		<div class="row">

			<!-- a blank row to get started -->
			<div class="col-sm-12">
				<!-- your contents here -->
			</div>

		</div>

		<!-- end row -->

	</section>
	<!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->