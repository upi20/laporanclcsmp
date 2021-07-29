<div id="content">

    <!-- row -->
    <div class="row">

        <!-- col -->
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <h1 class="page-title txt-color-blueDark" style="font-weight:bold; text-transform: unset;">
                <!-- PAGE HEADER -->
                <i class="fa-fw fa fa-table"></i>

                <?= $title ?> - <b><?= $npsn ?> (<?= $cabang ?>)</b>
            </h1>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <h1 class="page-title txt-color-blueDark" style="text-align: right;">
                Total Ringgit: <b id="format_ringgit_total"><?= $total['total_harga_ringgit']; ?></b>
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
                                <!-- <a class="btn btn-success btn-sm" href="<?= base_url() ?>realisasi/cetakexcel">
									<i class="fa fa-download"></i> Excel
								</a> -->
                                <!-- <button class="btn btn-danger btn-sm" id="pdf">
									<i class="fa fa-download"></i> PDF
								</button> -->
                            </div>
                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th> <input type="checkbox" onchange="handleSetAllCheckbox(this)" id="check-all"> Semua</th>
                                        <th> Kode Standar</th>
                                        <th> Nama</th>
                                        <th> Anggaran RAB (RM)</th>
                                        <th> Anggaran RAB (Rp)</th>
                                        <th> Harga Real (RM)</th>
                                        <th> Harga Real (Rp)</th>
                                        <th> Selisih (RM)</th>
                                        <th> Selisih (Rp)</th>
                                        <th> Volume</th>
                                        <th> Volume Realisasi</th>
                                        <th> Volume Sisa</th>
                                        <th> Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rabs as $q) :

                                    ?>
                                        <tr>
                                            <?php
                                            $is_proposal = isset($q['proposal_jumlah_ringgit']);
                                            $volume = 0;
                                            $ringgit = 0;
                                            $rupiah = 0;
                                            // jik ada proposal
                                            if ($is_proposal) {
                                                $ringgit = $q['proposal_jumlah_ringgit'];
                                                $rupiah =  $q['proposal_jumlah_rupiah'];
                                                $volume = $q['proposal_volume'];
                                            }
                                            // jika proposal tidak ada
                                            else {
                                                // jika sudah rabs pernah direalisasi
                                                if ($q['vol_realisasi'] > 0) {
                                                    $volume = $q['vol_realisasi_sisa'];
                                                    $ringgit = $volume * $q['harga_ringgit'];
                                                    $rupiah = $volume * $q['harga_rupiah'];
                                                }
                                                // jika rabs belum direalisasi
                                                else {
                                                    $volume = $q['volume'];
                                                    $ringgit = $q['total_harga_ringgit'];
                                                    $rupiah = $q['total_harga_rupiah'];
                                                }
                                            }
                                            if (!($q['id_realisasi']) || $q['vol_realisasi_sisa'] > 0) :
                                            ?>
                                                <td>
                                                    <input name="id_rab" value="" type="checkbox" class="check" data-id_rab="<?= $q['id'] ?>" data-kode="<?= $q['kodes'] ?>" data-volume="<?= $volume ?>" data-uraian="<?= $q['nama_aktifitas'] ?>" data-satuan_ringgit="<?= $q['harga_ringgit'] ?>" data-satuan_rupiah="<?= $q['harga_rupiah'] ?>" data-ringgit="<?= $ringgit ?>" data-rupiah="<?= $rupiah ?>">
                                                    <?php if ($q['vol_realisasi'] > 0) : ?>
                                                        <button style="width: 100%;" class="btn btn-success btn-xs" onclick="Detail(<?= $q['id'] ?>)">
                                                            <i class="fa fa-edit"></i> Detail
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            <?php else : ?>
                                                <td>
                                                    <button style="width: 100%;" class="btn btn-success btn-xs" onclick="Detail(<?= $q['id'] ?>)">
                                                        <i class="fa fa-edit"></i> Detail
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                            <td><?= $q['kodes'] ?></td>
                                            <td><?= $q['nama_aktifitas'] ?></td>
                                            <td class="text-ringgit">
                                                <?= $ringgit; ?>
                                            </td>
                                            <td class="text-rupiah">
                                                <?= $rupiah; ?>
                                            </td>
                                            <td class="text-ringgit"><?= $q['real_ringgit']; ?></td>
                                            <td class="text-rupiah"><?= $q['real_rupiah']; ?></td>
                                            <td class="text-ringgit"><?= $q['sisa_ringgit']; ?></td>
                                            <td class="text-rupiah"><?= $q['sisa_rupiah']; ?></td>
                                            <td><?= $q['volume']; ?></td>
                                            <td><?= $q['vol_realisasi']; ?></td>
                                            <td><?= $q['vol_realisasi_sisa']; ?></td>
                                            <td><?= $q['id_realisasi'] ? 'Sudah Direalisasikan' : 'Belum Direalisasikan' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="#" onclick="ubah(this)" class="btn btn-default" id="btn-ubah" disabled>
                                        Belanja</a>
                                </div>
                            </div>
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

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col">
                            <br>
                            <h4 style="font-weight: bold; text-align:center" class="modal-title" id="myModalLabel">
                                Realisasi Bealnja</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Anggaran</th>
                                        <th>Realisasi</th>
                                        <th>Selisih</th>
                                    </tr>
                                </thead>
                                <tbody id="body-realisasi">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row p-0 m-0">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input style="margin-left: 10px;" type="text" id="belanja-nama-0" class="form-control" name="belanja-nama" value="Dibayarkan kepada " readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="belanja-nama-1" name="belanja-nama" value="" required />
                                    </div>
                                    <div class="col-md-6">
                                        <input style="margin-left: 10px;" type="text" id="belanja-nama-2" class="form-control" name="belanja-nama" value=" untuk " readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="belanja-nama-3" name="belanja-nama" value="" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="belanja-text-total-ringgit"> Anggaran RAB (RM)</label>
                                        <input type="text" class="form-control" id="belanja-text-total-ringgit" readonly="" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="belanja-text-total-rupiah"> Anggaran RAB (Rp)</label>
                                        <input type="text" class="form-control" id="belanja-text-total-rupiah" readonly="" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="belanja-keterangan"> Keterangan</label>
                                    <textarea class="form-control" id="belanja-keterangan" name="belanja-keterangan"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="belanja-harga-ringgit"> Harga Real (RM)</label>
                                    <input type="hidden" class="form-control" id="belanja-harga-ringgit" name="harga_ringgit">
                                    <input type="text" class="form-control" readonly id="belanja-text-harga-ringgit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="belanja-harga-rupiah"> Harga Real (Rp)</label>
                                    <input type="hidden" class="form-control" id="belanja-harga-rupiah" name="harga_rupiah">
                                    <input type="text" class="form-control" readonly id="belanja-text-harga-rupiah">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="belanja-file"> Photo Resit / Nota / Kwitansi</label>
                                    <input type="file" class="form-control" accept="image/png, image/gif, image/jpg, image/jpeg" id="belanja-file" name="file" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="belanja-tanggal"> Tanggal</label>
                                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="belanja-tanggal" name="tanggal" required />
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
            </div>
        </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<!-- modal detail -->
<div class="modal fade" id="myModalRealisasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form2" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="font-weight: bold;" class="modal-title" id="myModalLabelRealisasi"></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Anggaran Total</th>
                                <th>Anggaran Realisasi</th>
                                <th>Realisasi</th>
                                <th>Realisasi Selisih</th>
                            </tr>
                        </thead>
                        <tbody id="detail-realisasi-modal">

                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    let npsn = '<?= $npsn ?>'
    const id_cabang = '<?= $id_cabang ?>'
    let kurs = parseFloat('<?= $kurs ?>')
    let isUbah = false;

    function handleSetAllCheckbox(data) {
        $(".check").prop("checked", data.checked);
        setBtnUbah();
    }
</script>