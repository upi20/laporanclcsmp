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


		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-3">
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-3">
			<select name="" class="form-control" id="id_cabang">
				<option value="">Pilih Cabang</option>
				<option value="">Cabang 1</option>
			</select>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-2">
			<button class="btn btn-success btn-sm" id="search" style="float: right; width: 100%;">
				<i class="fa fa-search"></i> Search
			</button>
		</div>

		<!-- end col -->

	</div>
	<!-- end row -->


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
								<button class="btn btn-success btn-sm" id="tambah">
									<i class="fa fa-plus"></i> Tambah
								</button>
							</div> -->

							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Nama Cabang</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> RAB</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Nama</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Total Ringgit</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Total Rupiah</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Keterangan</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Bukti 1</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Bukti 2</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Status</th>
										<!-- <th style="width: 24%;"><i class="fa fa-fw fa-thumb-tack text-muted hidden-md hidden-sm hidden-xs"></i>Aksi</th> -->
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
								<label for="nama"> Nama Pengguna</label>
								<select type="text" class="form-control" id="id_user"></select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Kode Cabang</label>
								<select type="text" class="form-control" id="cabang_kode"></select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label for="nama">Nama Cabang</label>
							<select type="text" class="form-control" id="cabang_nama"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama">RAB</label>
								<select type="text" class="form-control" id="id_rab"></select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Keterangan</label>
								<input type="text" class="form-control" id="keterangan" placeholder="keterangan" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Total Ringgit</label>
								<input type="text" class="form-control" id="total_ringgit" placeholder="total_ringgit" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Total Rupiah</label>
								<input type="text" class="form-control" id="total_rupiah" placeholder="total_rupiah" required />
							</div>
						</div>
					</div>

					<!-- 					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Status</label>
								<select class="form-control" name="status" id="status">
									<option value="1" selected="">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</div> -->

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