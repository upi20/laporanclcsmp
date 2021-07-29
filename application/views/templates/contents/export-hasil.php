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

							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Paket Soal</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Kota Kabupaten</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Waktu Mulai</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Waktu Selesai</th>
										<th data-hide="phone"><i class="fa fa-fw fa-check text-muted hidden-md hidden-sm hidden-xs"></i> Lama</th>
										<th><i class="fa fa-fw fa-thumb-tack text-muted hidden-md hidden-sm hidden-xs"></i>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($jadwal as $j) : ?>
										<tr>
											<?php
											$date_now = new DateTime(date("Y-m-d H:i:s"));
											$date1 = new DateTime($j['waktu_selesai']);
											$date2 = new DateTime($j['waktu_mulai']);
											$diff = $date1->diff($date2);

											$cobain = ($date_now > $date2 && $date_now < $date1);
											?>
											<td><?= $j['mapel'] ?> # <?= $j['token'] ?></td>
											<td><?= $j['kota'] ?></td>
											<td><?= $j['waktu_mulai'] ?></td>
											<!-- <td><?= ($j['mode_timer'] == 2 ? '' : $j['waktu_mulai']) ?></td> -->
											<!-- <td><?= ($j['mode_timer'] == 2 ? '' : $j['waktu_selesai']) ?></td> -->
											<td><?= $j['waktu_selesai'] ?></td>
											<td><?= #$diff->y . ' Tahun ' .
												#$diff->m . ' Bulan ' .
												#$diff->d . ' Hari ' .
												$diff->h . ' Jam ' . $diff->i . ' Menit ' . $diff->s . ' Detik' ?></td>
											<td>
												<?php if ($date1 < $date_now) : ?>
													<a href="<?= base_url() ?>exportHasil/excel/<?= $j['id'] ?>" target="_blank" class="btn btn-xs btn-success">Eksport Excel</a>
												<?php endif; ?>
											</td>
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