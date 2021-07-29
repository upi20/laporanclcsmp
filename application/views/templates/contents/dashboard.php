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
													<h4><b>Profil Pusat</b></h4>
												</div>
												<div class="col-md-6">
													<button type="submit" class="btn btn-xs btn-primary" style="float: right;"><i class="fa fa-edit"></i> <b>Simpan</b></button>
												</div>
											</div>
											<hr>
											<table style="width: 100%;">
												<tr>
													<td style="width: 25%;">
														<h5 class="name" style="font-size: 12px;">Nama Pusat</h5>
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
														<h5 class="name" style="font-size: 12px;">Alamat Pusat</h5>
													</td>
													<td style="width: 5%;">:</td>
													<td>
														<textarea class="form-control" name="alamat"><?= $profil['alamat'] ?></textarea>
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

</div>
<!-- END MAIN CONTENT -->