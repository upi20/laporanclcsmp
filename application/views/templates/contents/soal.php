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

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							<input class="form-control" type="text">
						</div>
						<!-- end widget edit box -->

						<!-- widget content -->
						<div class="widget-body">

							<div class="pull-right">
								<a href="<?= base_url() ?>hapusBackup/truncate?table=soal" onclick="return confirm('Anday yakin ?')" class="btn btn-danger btn-sm">
									<i class="fa fa-times"></i> Delete All
								</a>
								<a href="<?= base_url() ?>hapusBackup?table=soal" class="btn btn-primary btn-sm">
									<i class="fa fa-upload"></i> Backup
								</a>
								<button class="btn btn-success btn-sm" id="tambah">
									<i class="fa fa-plus"></i> Tambah
								</button>
							</div>
							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> ID</th>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Jenis Soal</th>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Mata Pelajaran</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Token</th>
										<!-- <th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Model</th> -->
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Pengaturan</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Jumlah</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Status</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Tanggal</th>
										<th style="width: 8%;"><i class="fa fa-fw fa-thumb-tack text-muted hidden-md hidden-sm hidden-xs"></i>Aksi</th>
									</tr>
								</thead>
								<tbody>
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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="id">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Jenis Soal</label>
								<input type="text" class="form-control" id="jenis_soal" placeholder="Jenis Soal" required />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Mata Pelajaran</label>
								<select class="form-control" id="id_mata_pelajaran">
									<option value="">--Pilih Mata Pelajaran--</option>
								</select>
							</div>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Model</label>
								<select class="form-control" id="model">
									<option value="" selected="">--Pilih Model--</option>
									<option value="Pilihan Ganda">Pilihan Ganda</option>
									<option value="Benar Salah">Benar Salah</option>
									<option value="Menjodohkan">Menjodohkan</option>
								</select>
							</div>
						</div>
					</div> -->

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Pengaturan</label>
								<select class="form-control" id="pengaturan">
									<option value="" selected="">--Pilih Pengaturan--</option>
									<option value="Acak">Acak</option>
									<option value="Tidak Acak">Tidak Acak</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Status</label>
								<select class="form-control" name="status" id="status">
									<option value="1" selected="">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
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