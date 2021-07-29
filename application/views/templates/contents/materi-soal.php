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
							<?php
							$no = 1;
							$no1 = 1;
							$no2 = 1;
							$no3 = 1;
							$no4 = 1;
							$no5 = 1;
							foreach ($records as $soal) : ?>
								<div class="row">
									<div class="col-md-12">
										<p>
											<b><?= $page + 1 ?></b>. <?= $soal['keterangan'] ?>
										</p>
										<?php if (isset($soal['file_audio'])) : ?>
											<audio controls src="<?= base_url() ?>uploads/audio/<?= $soal['file_audio'] ?>">
												Your browser does not support the audio element.
											</audio>
										<?php endif; ?>
										<?php if (isset($soal['gambar'])) : ?>
											<img src="<?= base_url() ?>uploads/gambar/<?= $soal['gambar'] ?>" width="300px" height="300px">
										<?php endif; ?>
										<div class="row">
											<div class="col-md-12">
												<?php
												$data = $pilihan(['id_soal_detail' => $soal['id']]);
												$last_answer = isset($this->session->userdata('answer')[$soal['id']]);
												$answer = null;

												if ($last_answer) {
													$answer = $this->session->userdata('answer')[$soal['id']];
												}
												?>
												<b>a</b>. <input type="radio" name="jawab<?= $no1++ ?>" <?= ($answer == 'a') ? 'checked' : '' ?> onclick="pick('a', <?= $soal['id'] ?>)"> <?= $data[0]['keterangan'] ?>
												<br>
												<b>b</b>. <input type="radio" name="jawab<?= $no2++ ?>" <?= ($answer == 'b') ? 'checked' : '' ?> onclick="pick('b', <?= $soal['id'] ?>)"> <?= $data[1]['keterangan'] ?>
												<br>
												<?php if ($soal['kategori'] == 'Pilihan Ganda') : ?>
													<b>c</b>. <input type="radio" name="jawab<?= $no3++ ?>" <?= ($answer == 'c') ? 'checked' : '' ?> onclick="pick('c', <?= $soal['id'] ?>)"> <?= $data[2]['keterangan'] ?>
													<br>
													<b>d</b>. <input type="radio" name="jawab<?= $no4++ ?>" <?= ($answer == 'd') ? 'checked' : '' ?> onclick="pick('d', <?= $soal['id'] ?>)"> <?= $data[3]['keterangan'] ?>
													<br>
													<b>e</b>. <input type="radio" name="jawab<?= $no5++ ?>" <?= ($answer == 'e') ? 'checked' : '' ?> onclick="pick('e', <?= $soal['id'] ?>)"> <?= $data[4]['keterangan'] ?>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
								<br>
							<?php endforeach; ?>
							<?= $pagination ?>

							<button class="btn btn-sm btn-primary">Save Answer</button>
							<a href="<?= base_url() ?>materiSoal/saveJawaban/<?= $id ?>" class="btn btn-sm btn-success" onclick="return confirm('Anda yakin ?')">Submit and Finish</a>
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