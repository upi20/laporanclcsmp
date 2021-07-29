<!-- MAIN CONTENT -->
<div id="content">


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
				<div class="row" style="margin-top: -30px;">
					<div class="col-lg-8">
						<div class="row">
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="product-content product-wrap clearfix" style="height: 137px;">
									<div class="row">
										<div class="col-md-4 col-sm-12 col-xs-12">
											<div class="product-image" style="height: 109px;min-height: auto;">
												<i class="fa fa-file-text-o" style="font-size: 50px; margin: auto; width: 50%;padding: 30px;"></i>
											</div>
										</div>
										<div class="col-md-8 col-sm-12 col-xs-12">
											<div class="product-deatil" style="border-bottom: none;">
												<h5 class="name" style="margin-top: 10px; font-weight:bold; font-size:17px">
													<a href="#">
														Jumlah RAB <span></span>
													</a>
												</h5>
												<p class="price-container">
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-ringgit"><?= $rab['total_harga_ringgit'] ?></span><br>
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-rupiah"><?= $rab['total_harga_rupiah'] ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="product-content product-wrap clearfix" style="height: 137px;">
									<div class="row">
										<div class="col-md-4 col-sm-12 col-xs-12">
											<div class="product-image" style="height: 109px;min-height: auto;">
												<i class="fa fa-usd" style="font-size: 50px; margin: auto; width: 50%;padding: 30px;"></i>
											</div>
										</div>
										<div class="col-md-8 col-sm-12 col-xs-12">
											<div class="product-deatil" style="border-bottom: none;">
												<h5 class="name" style="margin-top: 10px; font-weight:bold; font-size:17px">
													<a href="#">
														Jumlah Saldo <span></span>
													</a>
												</h5>
												<p class="price-container">
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-ringgit"><?= $saldo['total_ringgit'] ?></span><br>
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-rupiah"><?= $saldo['total_rupiah'] ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="product-content product-wrap clearfix" style="height: 137px;">
									<div class="row">
										<div class="col-md-4 col-sm-12 col-xs-12">
											<div class="product-image" style="height: 109px;min-height: auto;">
												<i class="fa fa-check" style="font-size: 50px; margin: auto; width: 50%;padding: 30px;"></i>
											</div>
										</div>
										<div class="col-md-8 col-sm-12 col-xs-12">
											<div class="product-deatil" style="border-bottom: none;">
												<h5 class="name" style="margin-top: 10px; font-weight:bold; font-size:17px">
													<a href="#">
														Total Realisasi Anggaran <span></span>
													</a>
												</h5>
												<p class="price-container">
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-ringgit"><?= $realisasi['harga_ringgit'] ?></span><br>
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-rupiah"><?= $realisasi['harga_rupiah'] ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="product-content product-wrap clearfix" style="height: 137px;">
									<div class="row">
										<div class="col-md-4 col-sm-12 col-xs-12">
											<div class="product-image" style="height: 109px;min-height: auto;">
												<i class="fa fa-bars" style="font-size: 50px; margin: auto; width: 50%;padding: 30px;"></i>
											</div>
										</div>
										<div class="col-md-8 col-sm-12 col-xs-12">
											<div class="product-deatil" style="border-bottom: none;">
												<h5 class="name" style="margin-top: 10px; font-weight:bold; font-size:17px">
													<a href="#">
														Sisa Realisasi <span></span>
													</a>
												</h5>
												<p class="price-container">
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-ringgit"><?= $rab['total_harga_ringgit'] - $realisasi['harga_ringgit'] ?></span><br>
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-rupiah"><?= $rab['total_harga_rupiah'] - $realisasi['harga_rupiah'] ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="product-content product-wrap clearfix" style="height: 137px;">
									<div class="row">
										<div class="col-md-4 col-sm-12 col-xs-12">
											<div class="product-image" style="height: 109px;min-height: auto;">
												<i class="fa fa-exchange" style="font-size: 50px; margin: auto; width: 50%;padding: 30px;"></i>
											</div>
										</div>
										<div class="col-md-8 col-sm-12 col-xs-12">
											<div class="product-deatil" style="border-bottom: none;">
												<h5 class="name" style="margin-top: 10px; font-weight:bold; font-size:17px">
													<a href="#">
														Jumlah Dana Dialihkan <span></span>
													</a>
												</h5>
												<p class="price-container">
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-ringgit"><?= $dialihkan['jumlah_ringgit'] ?></span><br>
													<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-rupiah"><?= $dialihkan['jumlah_rupiah'] ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="product-content product-wrap clearfix" style="height: 137px;">
									<div class="row">
										<div class="col-md-4 col-sm-12 col-xs-12">
											<div class="product-image" style="height: 109px;min-height: auto;">
												<i class="fa fa-calendar" style="font-size: 50px; margin: auto; width: 50%;padding: 30px;"></i>
											</div>
										</div>
										<div class="col-md-8 col-sm-12 col-xs-12">
											<div class="product-deatil" style="border-bottom: none;">
												<a href="<?= base_url('hutang') ?>">
													<h5 class="name" style="margin-top: 10px; font-weight:bold; font-size:17px; color:black">
														Jumlah Hutang <span></span>
													</h5>
													<p class="price-container">
														<span style="font-family: sans-serif; font-size: 16px; line-height: 20px; color:black" class="text-ringgit"><?= $hutang['jumlah'] ?></span><br>
													</p>
												</a>
											</div>
											<a href="<?= base_url('hutang') ?>" class="btn btn-warning btn-xs" style="float:right; margin-right:10px">Bayar Hutang</a>
											<div style="clear:both"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="product-content product-wrap clearfix">
							<div class="row">
								<div class="col-md-1 col-sm-12 col-xs-12">
								</div>
								<div class="col-md-11 col-sm-12 col-xs-12">
									<form action="<?php echo base_url(); ?>dashboard/simpanProfil" method="POST" id="form">
										<div class="product-deatil" style="border-bottom: none;">
											<div class="row">
												<div class="col-md-6">
													<h4><b>Profil Sekolah</b></h4>
												</div>
												<div class="col-md-6">
													<button type="submit" class="btn btn-xs btn-primary" style="float: right;"><i class="fa fa-edit"></i> <b>Simpan</b></button>
												</div>
											</div>
											<hr>
											<table style="width: 100%;">
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">NPSN</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<h5 class="name" style="font-size: 14px;"><b><?= $profil['kode'] ?></b></h5>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Nama CLC</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="text" class="form-control" name="nama" value="<?= $profil['nama'] ?>" required>
														<input type="hidden" name="id" value="<?= $profil['id'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">No. Telpon Pengelola</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="text" class="form-control" name="no_telpon" value="<?= $profil['no_telpon'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Alamat CLC</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<textarea class="form-control" name="alamat"><?= $profil['alamat'] ?></textarea>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Siswa Kelas 7</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="jumlah_kelas_7" value="<?= $profil['jumlah_kelas_7'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Siswa Kelas 8</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="jumlah_kelas_8" value="<?= $profil['jumlah_kelas_8'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Siswa Kelas 9</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="jumlah_kelas_9" value="<?= $profil['jumlah_kelas_9'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="number" style="font-size: 12px;">Jumlah Siswa Keseluruhan</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="total_jumlah_siswa" value="<?= $profil['total_jumlah_siswa'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Jumlah Guru Bina</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="jumlah_guru_bina" value="<?= $profil['jumlah_guru_bina'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Jumlah Guru Pamong</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="jumlah_guru_pamong" value="<?= $profil['jumlah_guru_pamong'] ?>" required>
													</td>
												</tr>
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Jumlah Guru Keseluruhan</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<input type="number" class="form-control" name="total_jumlah_guru" value="<?= $profil['total_jumlah_guru'] ?>" required>
													</td>
												</tr>
											</table>
											<hr>
											<h5 style="text-align: center;">"Memanusiakan Manusia Membangun Peradaban"</h5>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
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