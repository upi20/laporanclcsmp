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

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							<input class="form-control" type="text">
						</div>
						<!-- end widget edit box -->

						<!-- widget content -->
						<div class="widget-body">

							<div class="pull-right">
								<?php if ($rab_status == 0) : ?>
									<button class="btn btn-primary btn-sm" id="tambah">
										<i class="fa fa-plus"></i> Tambah
									</button>
								<?php endif; ?>
								<a href="<?= base_url(); ?>rab/cabang/cetakexcel" class="btn btn-success btn-sm">
									<i class="fa fa-download"></i> Cetak Excel
								</a>
							</div>

							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th> Cabang</th>
										<th> Aktifitas</th>
										<th> Kode Sub Standar</th>
										<th> Nama Sub Standar</th>
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
										<th> Edit Data</th>
									</tr>
								</thead>

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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="form">
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
								<select id="id_cabang" class="form-control">
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="id">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama"> Kode Standar</label>
										<select id="id_aktifitas" class="form-control">
											<option value="">Pilih Aktifitas</option>
										</select>
									</div>
								</div>
								<div class="col-md-1">
								</div>
								<div class="col-md-11">
									<div class="form-group">
										<label for="nama"> Sub Standar</label>
										<select class="form-control" id="id_aktifitas_sub">

										</select>
									</div>
								</div>
								<div class="col-md-2">
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="nama"> Sub Standar</label>
										<select class="form-control" id="id_aktifitas_cabang">
										</select>
									</div>
								</div>
								<div class="col-md-3">
								</div>
								<div class="col-md-9">
									<div class="form-group">
										<label for="nama"> Sub Standar</label>
										<select class="form-control" id="kode_isi_1">

										</select>
									</div>
								</div>
								<div class="col-md-4">
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label for="nama"> Sub Standar</label>
										<select class="form-control" id="kode_isi_2">

										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama"> Kode</label>
										<input type="text" class="form-control" id="kode" placeholder="" required readonly />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama"> Uraian</label>
										<input type="text" class="form-control" id="nama" placeholder="" required />
									</div>
								</div>
							</div>

						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Harga (RM)</label>
										<input type="number" class="form-control" id="harga_ringgit" placeholder="" required />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Harga (Rp)</label>
										<input type="number" class="form-control" id="harga_rupiah" placeholder="" required readonly="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Jumlah</label>
										<input type="number" class="form-control" id="jumlah_1" placeholder="" value="0" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Satuan</label>
										<input type="text" class="form-control" id="satuan_1" placeholder="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Jumlah</label>
										<input type="number" class="form-control" id="jumlah_2" placeholder="" value="0" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Satuan</label>
										<input type="text" class="form-control" id="satuan_2" placeholder="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Jumlah</label>
										<input type="number" class="form-control" id="jumlah_3" placeholder="" value="0" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Satuan</label>
										<input type="text" class="form-control" id="satuan_3" placeholder="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Jumlah</label>
										<input type="number" class="form-control" id="jumlah_4" placeholder="" value="0" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Satuan</label>
										<input type="text" class="form-control" id="satuan_4" placeholder="" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Jumlah (RM)</label>
										<input type="number" class="form-control" id="total_harga_ringgit" placeholder="" required readonly="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama"> Jumlah (Rp)</label>
										<input type="number" class="form-control" id="total_harga_rupiah" placeholder="" required readonly="" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="nama"> Prioritas</label>
										<input type="number" class="form-control" id="prioritas" placeholder="" required />
									</div>
								</div>
							</div>
						</div>
					</div>





				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">
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

<!--
status :
Proses : 0
Di ajukan : 1
Diterima : 2
Ditolak : 3 -->