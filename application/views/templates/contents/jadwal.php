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
								<?php $lev_id = $this->session->userdata('data')['level_id'] ?>
								<?php if ($lev_id == 2) : ?>
									<a href="<?= base_url() ?>hapusBackup/truncate?table=jadwal" onclick="return confirm('Anday yakin ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i> Delete All
									</a>
									<a href="<?= base_url() ?>hapusBackup?table=jadwal" class="btn btn-primary btn-sm">
										<i class="fa fa-upload"></i> Backup
									</a>
									<button class="btn btn-success btn-sm" id="tambah">
										<i class="fa fa-plus"></i> Tambah
									</button>
								<?php endif; ?>
							</div>

							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Paket Soal</th>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Mode Jadwal</th>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Mode Timer</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Kota Kabupaten</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Waktu Mulai</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Waktu Selesai</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Status</th>
										<th><i class="fa fa-fw fa-thumb-tack text-muted hidden-md hidden-sm hidden-xs"></i>Aksi</th>
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
						<div class="col-md-6">
							<div class="form-group">
								<label for="nama"> Mata Pelajaran</label>
								<select class="form-control" required id="mata-pelajaran" <?= ($lev_id == 4) ? 'disabled' : '' ?>>
									<option value="">--Pilih Mata Pelajaran--</option>
									<?php foreach ($mapel as $mapel) : ?>
										<option value="<?= $mapel['id'] ?>"><?= $mapel['nama'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nama"> Soal</label>
								<select class="form-control" required id="soal" <?= ($lev_id == 4) ? 'disabled' : '' ?>>
									<option value="">--Pilih Soal--</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Kota</label>
								<select class="form-control" required id="kota" <?= ($lev_id == 4) ? 'disabled' : '' ?>>
									<option value="">--Pilih Kota--</option>
									<?php foreach ($kota as $kota) : ?>
										<option value="<?= $kota['id'] ?>"><?= $kota['nama'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Mode Jadwal</label>
								<select class="form-control" required id="mode-jadwal" <?= ($lev_id == 4) ? 'disabled' : '' ?>>
									<option value="">--Pilih Mode Jadwal--</option>
									<option value="1">Mode 1</option>
									<option value="2">Mode 2</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Mode Timer</label>
								<select class="form-control" required id="mode-timer">
									<option value="">--Pilih Mode Timer--</option>
									<option value="1">Mode 1</option>
									<option value="2">Mode 2</option>
								</select>
							</div>
						</div>
					</div>


					<div class="row" id="waktu">
						<div class="col-md-6">
							<div class="form-group">
								<label for="nama"> Waktu Mulai</label>
								<input type="datetime-local" id="waktu-mulai" class="form-control" placeholder="Waktu Mulai">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nama"> Waktu Selesai</label>
								<input type="datetime-local" id="waktu-selesai" class="form-control" placeholder="Waktu Selesai">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Status</label>
								<select class="form-control" name="status" id="status" <?= ($lev_id == 4) ? 'disabled' : '' ?>>
									<option value="">--Pilih Status--</option>
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

<script type="text/javascript">
	let lev_id = <?= $lev_id; ?>
</script>