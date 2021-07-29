<div id="content">

	<!-- row -->
	<div class="row">

		<!-- col -->
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<h1 class="page-title txt-color-blueDark" style="font-weight:bold; text-transform: unset;">
				<!-- PAGE HEADER -->
				<i class="fa-fw fa fa-table"></i>

				<?= $title ?> - <b><?= $npsn ?> (<?= $cabang ?>)</b>
			</h1>
		</div>

		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<h1 class="page-title txt-color-blueDark" style="text-align: right;">
				Total Ringgit: <b id="format_ringgit_total"><?= $total['total_harga_ringgit']; ?></b>
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

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							<input class="form-control" type="text">
						</div>
						<!-- end widget edit box -->

						<!-- widget content -->
						<div class="widget-body">
							<!-- <div class="pull-right">
								<a href="<?= base_url(); ?>realisasi/exceldanakurang" class="btn btn-success btn-sm">
									<i class="fa fa-download"></i> Cetak Excel
								</a>
							</div> -->
							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th> <input type="checkbox" onchange="handleSetAllCheckbox(this)" id="check-all"> Semua</th>
										<th> Kode Standar</th>
										<th> Nama</th>
										<th> Anggaran RAB (RM)</th>
										<th> Anggaran RAB (Rp)</th>
										<th> Harga Real (RM)</th>
										<th> Harga Real (Rp)</th>
										<th> Selisih (RM)</th>
										<th> Selisih (Rp)</th>
										<!-- <th> Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($danas as $dana) : ?>
										<tr>
											<td><input name="id_realisasi[]" value="<?= $dana['id_realisasi'] ?>" type="checkbox" class="check" data-ringgit="<?= $dana['sisa_ringgit'] ?>" data-rupiah="<?= $dana['sisa_rupiah'] ?>" data-id="<?= $dana['id'] ?>"></td>
											<td><?= $dana['kodes']; ?></td>
											<td><?= $dana['nama_aktifitas']; ?></td>
											<td class="text-ringgit"><?= $dana['total_harga_ringgit'] ?></td>
											<td class="text-rupiah"><?= $dana['total_harga_rupiah'] ?></td>
											<td class="text-ringgit"><?= $dana['harga_ringgit'] ?></td>
											<td class="text-rupiah"><?= $dana['harga_rupiah'] ?></td>
											<td class="text-ringgit"><?= $dana['sisa_ringgit'] ?></td>
											<td class="text-rupiah"><?= $dana['sisa_rupiah'] ?></td>
											<!-- <td><?= ($dana['id_realisasi']) ?  'Sudah Dibelanjakan' : 'Belum Dibelanjakan'; ?></td> -->
										</tr>
									<?php endforeach; ?>
								</tbody>

							</table>
							<div class="row">
								<div class="col-md-12">
									<a href="#" onclick="ubah(this)" class="btn btn-default" id="btn-ubah" disabled> Subsidi Dana</a>
								</div>
							</div>
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

	</section>
	<!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" id="id">
			<input type="hidden" name="id_cabang" id="id_cabang">
			<input type="hidden" name="val_npsn" id="val-npsn">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<div class="row">
						<div class="col-md-6">
							<br>
							<h4 style="font-weight: bold;" class="modal-title" id="myModalLabel"></h4>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<h6 id="npsn"></h6>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12" id="kode-label">
									<div class="form-group">
										<label for="nama"> Aktifitas</label>
										<select name="kode" class="form-control" id="val-kode">
											<option value="">Pilih Aktifitas</option>
											<?php foreach ($kodeNPSN as $key) : ?>
												<option value="<?= $key['kode'] ?>"><?= $key['kode'] ?> <?= $key['nama'] ?></option>
											<?php endforeach ?>
										</select>
										<input type="hidden" name="id_rab" id="id_rab">
									</div>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6" id="text-total-ringgit">
											<div class="form-group">
												<label for="nama"> Total Ringgit</label>
												<input type="hidden" name="total_ringgit" id="total-ringgit">
												<input type="text" class="form-control" id="jumlah-total-ringgit" readonly="" />
											</div>
											<div class="form-group">
												<label for="nama"> Total Rupiah</label>
												<input type="hidden" name="total_rupiah" id="total-rupiah">
												<input type="text" class="form-control" id="jumlah-total-rupiah" readonly="" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="nama"> Jumlah Dana Sisa Ringgit Kurang</label>
												<input type="hidden" name="sisa_ringgit" id="sisa-ringgit">
												<input type="text" class="form-control" id="jumlah-sisa-ringgit" name="jumlah_sisa_ringgit" readonly>
											</div>
											<div class="form-group">
												<label for="nama"> Jumlah Dana Sisa Rupiah Kurang</label>
												<input type="hidden" name="sisa_rupiah" id="sisa-rupiah">
												<input type="text" class="form-control" id="jumlah-sisa-rupiah" name="jumlah_sisa_rupiah" readonly="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="nama"> Jumlah Dana Sisa Total Ringgit Ditambahkan</label>
												<input type="hidden" name="sisa_total_ringgit" id="sisa-total-ringgit">
												<input type="text" class="form-control" id="jumlah-sisa-total-ringgit" name="jumlah-sisa-total-ringgit" readonly="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="nama"> Jumlah Dana Sisa Total Rupiah Ditambahkan</label>
												<input type="hidden" name="sisa_total_rupiah" id="sisa-total-rupiah">
												<input type="text" class="form-control" id="jumlah-sisa-total-rupiah" name="jumlah-sisa-total-rupiah" readonly="">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12" id="keterangan">
									<div class="form-group">
										<label for="nama"> Keterangan</label>
										<textarea class="form-control" id="keterangan" name="keterangan"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="submit-modal" disabled>
						Submit
					</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						Cancel
					</button>
				</div>
			</div><!-- /.modal-content -->
		</form>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	let npsn = '<?= $npsn ?>'
	let isUbah = false;
	const id_cabang = '<?= $id_cabang ?>';

	function handleSetAllCheckbox(data) {
		$(".check").prop("checked", data.checked);
		setBtnUbah();
	}
</script>