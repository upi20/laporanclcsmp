<div id="content">

	<!-- row -->
	<div class="row">

		<!-- col -->
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<h1 class="page-title txt-color-blueDark" style="font-weight:bold; text-transform: unset;">
				<!-- PAGE HEADER -->
				<i class="fa-fw fa fa-table"></i>

				<?= $title ?>
			</h1>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<div class="row">
				<div class="col-md-5">
					<select class="form-control" name="cabang" id="cabang">
						<option value="">Pilih Cabang</option>
						<?php foreach ($listCabang as $q) : ?>
							<option value="<?= $q['id'] ?>"><?= $q['kode'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-5">
					<select class="form-control" name="status" id="status">
						<option value="">Pilih Status</option>
						<option value="0">Diproses</option>
						<option value="1">Diajukan</option>
						<option value="2">Diterima</option>
						<option value="3">Ditolak</option>
						<option value="4">Dicairkan</option>
					</select>
				</div>
				<div class="col-md-2">
					<button type="submit" id="filter-cari" class="btn btn-primary mr-2" style="width: 100%;"> <i class="fa fa-search"></i> Cari</button>
				</div>
			</div>
		</div>

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
								<button class="btn btn-success btn-sm" id="tambah">
									<i class="fa fa-plus"></i> Tambah
								</button>
							</div> -->

							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>NPSN</th>
										<th>Cabang</th>
										<th>Judul</th>
										<th>Keterangan</th>
										<th>Jumlah (RM)</th>
										<th>Jumlah (Rp)</th>
										<th>Status</th>
										<th>Aksi</th>
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
<!-- Modal tambah -->
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
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Judul</label>
								<input type="text" class="form-control" id="judul" placeholder="" required />
							</div>
							<div class="form-group">
								<label for="nama"> Keterangan</label>
								<textarea type="text" class="form-control" id="keterangan" placeholder="" required></textarea>
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
</div><!-- /.modal-->

<!-- Modal detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="modalDetailLabel">Detail Proposal</h4>
					</div>
					<div class="col-md-6">
						<h4 style="margin-top: -14px; text-align: right; margin-right: 20px;" class="modal-title" id="detail-total-saldo"></h4>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="nama"> Judul</label>
							<input type="text" class="form-control" id="detail-judul" placeholder="" required />
							<input type="hidden" class="form-control" id="detail-id" placeholder="" required />
						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label for="detail-tgl-dari"> Periode dari</label>
									<input type="date" class="form-control" id="detail-tgl-dari" placeholder="" required disabled />
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label for="detail-tgl-sampai"> Periode sampai</label>
									<input type="date" class="form-control" id="detail-tgl-sampai" placeholder="" required disabled />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="termin"> Termin</label>
									<input type="number" class="form-control" id="detail-termin" placeholder="" required disabled />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="nama"> Keterangan</label>
							<textarea type="text" class="form-control" id="detail-keterangan" placeholder="" required></textarea>
						</div>
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead id="detail-table-head">

							</thead>
							<tbody id="detail-table">

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-ubah">
					Submit
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					Cancel
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal-->

<!-- Modal detail -->
<div class="modal fade" id="modalAjukan" tabindex="-1" role="dialog" aria-labelledby="modalAjukanLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<div class="row">
					<div class="col-md-6">
						<h4 class="modal-title" id="modalAjukanLabel">Ajukan Proposal</h4>
					</div>
					<div class="col-md-6">
						<h4 style="margin-top: -14px; text-align: right; margin-right: 20px;" class="modal-title" id="detail-total-saldo"></h4>
						<input type="hidden" id="ajukan-id">
					</div>
				</div>
			</div>
			<div class="modal-body">
				<h4>Yakin akan mengajukan proposal ?</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-ajukan">
					Yes
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					Cancel
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal-->