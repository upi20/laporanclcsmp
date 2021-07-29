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
								<button class="btn btn-success btn-sm" id="tambah">
									<i class="fa fa-plus"></i> Tambah
								</button>
							</div>
							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-class="expand">NPSN</th>
										<th data-class="expand">Nama</th>
										<th data-class="expand">Email</th>
										<th data-class="expand">Password</th>
										<th data-class="expand">No Telepon</th>
										<th data-class="expand">Alamat</th>
										<th data-class="expand">Kelas 7</th>
										<th data-class="expand">Kelas 8</th>
										<th data-class="expand">Kelas 9</th>
										<th data-class="expand">Total Siswa</th>
										<th data-class="expand">Guru Bina</th>
										<th data-class="expand">Guru Pamong</th>
										<th data-class="expand">Total Guru</th>
										<th data-hide="phone">Status</th>
										<th>Edit Data</th>
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
					<input type="hidden" name="id_user" id="id_user">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>NPSN</label>
								<input type="text" id="kode" class="form-control" name="kode" placeholder="Kode" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tanggal">Nama</label>
								<input type="text" id="nama" class="form-control" name="nama" placeholder="Nama" required />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tanggal">Email</label>
								<input type="text" id="email" class="form-control" name="email" placeholder="Email" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tanggal">No Telepon</label>
								<input type="text" id="no_telpon" class="form-control" name="no_telpon" placeholder="No Telepon" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tanggal">Alamat</label>
								<input type="text" id="alamat" class="form-control" name="alamat" placeholder="alamat" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="tanggal">Kelas 7</label>
								<input type="text" class="form-control" id="jumlah_kelas_7" placeholder="Jumlah siswa kelas 7" required />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="tanggal">Kelas 8</label>
								<input type="text" class="form-control" id="jumlah_kelas_8" placeholder="Jumlah siswa kelas 8" required />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="tanggal">Kelas 9</label>
								<input type="text" class="form-control" id="jumlah_kelas_9" placeholder="Jumlah siswa kelas 9" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="tanggal">Guru Bina</label>
								<input type="text" class="form-control" id="jumlah_guru_bina" placeholder="Jumlah Guru Bina" required />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="tanggal">Guru Pamong</label>
								<input type="text" class="form-control" id="jumlah_guru_pamong" placeholder="Jumlah Guru Pamong" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nama"> Status</label>
								<select class="form-control" required id="status">
									<option value="">--Pilih Status--</option>
									<option selected="" value="Aktif">Aktif</option>
									<option value="Tidak Aktif">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="submit">
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

<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPasswordLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="form-password">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="modalPasswordLabel">Ganti Password Cabang</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="new_password">Password Baru</label>
								<input type="text" class="form-control" id="new_password" placeholder="Password baru" required minlength="6" />
								<input type="hidden" class="form-control" id="id_cabang" required />
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
</div><!-- /.modal