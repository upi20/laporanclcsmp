<div id="content">

    <div class="row">

        <!-- col -->
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <h1 class="page-title txt-color-blueDark" style="font-weight:bold; text-transform: unset;">
                <!-- PAGE HEADER -->
                <i class="fa-fw fa fa-table"></i>

                <?= $title ?>
            </h1>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <h1 class="page-title txt-color-blueDark" style="text-align: right;">
                Total Ringgit: <b id="format_ringgit_total"></b>
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
                                <?php if ($status != 2 || $fungsi == 0) : ?>
                                    <button class="btn btn-primary btn-sm" id="tambah">
                                        <i class="fa fa-plus"></i> Tambah
                                    </button>
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-import">
                                        <i class="fa fa-upload"></i> Import Excel
                                    </button>
                                <?php endif; ?>
                                <!-- <a href="<?= base_url(); ?>rab/cabang/cetakexcel" class="btn btn-success btn-sm">
									<i class="fa fa-download"></i> Cetak Excel
								</a> -->
                                <a href="<?= base_url(); ?>rab/cabang/exportFormExcel?cabang=<?= $id_cabang ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-download"></i> Export Excel
                                </a>
                                <?php if ($status != 2 || $fungsi == 0) : ?>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-reset">
                                        <i class="fa fa-reload"></i> Reset RAB
                                    </button>
                                <?php endif; ?>
                            </div>

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th> Kode Standar</th>
                                        <th> Uraian</th>
                                        <th> Jumlah</th>
                                        <th> Satuan</th>
                                        <th> Jumlah</th>
                                        <th> Satuan</th>
                                        <th> Jumlah</th>
                                        <th> Satuan</th>
                                        <th> Jumlah</th>
                                        <th> Satuan</th>
                                        <th> Harga (RM)</th>
                                        <th> Harga (Rp)</th>
                                        <th> Jumlah (RM)</th>
                                        <th> Jumlah (Rp)</th>
                                        <th> Keterangan</th>
                                        <th> Edit Data</th>
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
    <div class="modal-dialog modal-lg">
        <form id="form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <h4 style="font-weight: bold;" class="modal-title" id="myModalLabel"></h4>
                        </div>
                        <div class="col-md-6" id="title-cabang">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" id="id_cabang" value="<?= $id_cabang ?>" class="form-control">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama"> Kode Standar</label>
                                        <select id="id_aktifitas" class="form-control">
                                            <option value="">Pilih Aktifitas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="nama"> Sub Standar</label>
                                        <select class="form-control" id="id_aktifitas_sub">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="nama"> Sub Standar</label>
                                        <select class="form-control" id="id_aktifitas_cabang">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="nama"> Sub Standar</label>
                                        <select class="form-control" id="kode_isi_1">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nama"> Sub Standar</label>
                                        <select class="form-control" id="kode_isi_2">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama"> Kode</label>
                                        <input type="text" class="form-control" id="kode" placeholder="" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama"> Uraian</label>
                                        <input type="text" class="form-control" id="nama" placeholder="" required />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Harga (RM)</label>
                                        <input type="number" class="form-control" id="harga_ringgit" placeholder="" value="0" step="any" required />
                                        <input type="hidden" class="form-control" id="val_harga_ringgit" placeholder="" value="0" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Harga (Rp)</label>
                                        <input type="text" class="form-control" id="harga_rupiah" placeholder="" value="0" required readonly="" />
                                        <input type="hidden" class="form-control" id="val_harga_rupiah" placeholder="" value="0" required readonly="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah_1" placeholder="" value="1" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Satuan</label>
                                        <input type="text" class="form-control" id="satuan_1" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah_2" placeholder="" value="1" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Satuan</label>
                                        <input type="text" class="form-control" id="satuan_2" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah_3" placeholder="" value="1" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Satuan</label>
                                        <input type="text" class="form-control" id="satuan_3" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah_4" placeholder="" value="1" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Satuan</label>
                                        <input type="text" class="form-control" id="satuan_4" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Jumlah (RM)</label>
                                        <input type="text" class="form-control" id="total_harga_ringgit" placeholder="" required readonly="" />
                                        <input type="hidden" class="form-control" id="val_total_harga_ringgit" placeholder="" required readonly="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama"> Jumlah (Rp)</label>
                                        <input type="text" class="form-control" id="total_harga_rupiah" placeholder="" required readonly="" />
                                        <input type="hidden" class="form-control" id="val_total_harga_rupiah" placeholder="" required readonly="" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="display:none">
                                    <div class="form-group">
                                        <label for="nama"> Prioritas</label>
                                        <input type="number" class="form-control" id="prioritas" placeholder="" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="keterangan"> Keterangan</label>
                                        <input type="text" class="form-control" id="keterangan" placeholder="" />
                                    </div>
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
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="ubah-form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <h4 style="font-weight: bold;" class="modal-title" id="modalUbahLabel">Ubah Data</h4>
                        </div>
                        <div class="col-md-6" id="title-cabang"><br>
                            <h4 style="font-weight: bold;" class="modal-title"><?= $cabang_nama ?></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah-id" id="ubah-id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ubah-kode"> Kode</label>
                                        <input type="text" class="form-control" id="ubah-kode" placeholder="" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ubah-nama"> Uraian</label>
                                        <input type="text" class="form-control" id="ubah-nama" placeholder="" required="">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-harga_ringgit"> Harga (RM)</label>
                                        <input type="number" class="form-control" id="ubah-harga_ringgit" placeholder="" value="" step="any" required="">
                                        <input type="hidden" class="form-control" id="ubah-val_harga_ringgit" placeholder="" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-ubah-harga_rupiah"> Harga (Rp)</label>
                                        <input type="text" class="form-control" id="ubah-harga_rupiah" placeholder="" value="0" required="" readonly="">
                                        <input type="hidden" class="form-control" id="ubah-val_harga_rupiah" placeholder="" value="" required="" readonly="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-jumlah_1"> Jumlah</label>
                                        <input type="number" class="form-control" id="ubah-jumlah_1" placeholder="" value="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-satuan_1"> Satuan</label>
                                        <input type="text" class="form-control" id="ubah-satuan_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-jumlah_2"> Jumlah</label>
                                        <input type="number" class="form-control" id="ubah-jumlah_2" placeholder="" value="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-satuan_2"> Satuan</label>
                                        <input type="text" class="form-control" id="ubah-satuan_2" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-jumlah_3"> Jumlah</label>
                                        <input type="number" class="form-control" id="ubah-jumlah_3" placeholder="" value="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-satuan_3"> Satuan</label>
                                        <input type="text" class="form-control" id="ubah-satuan_3" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-jumlah_4"> Jumlah</label>
                                        <input type="number" class="form-control" id="ubah-jumlah_4" placeholder="" value="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-satuan_4"> Satuan</label>
                                        <input type="text" class="form-control" id="ubah-satuan_4" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-total_harga_ringgit"> Jumlah (RM)</label>
                                        <input type="text" class="form-control" id="ubah-total_harga_ringgit" placeholder="" required="" readonly="">
                                        <input type="hidden" class="form-control" id="ubah-val_total_harga_ringgit" placeholder="" required="" readonly="" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ubah-total_harga_rupiah"> Jumlah (Rp)</label>
                                        <input type="text" class="form-control" id="ubah-total_harga_rupiah" placeholder="" required="" readonly="">
                                        <input type="hidden" class="form-control" id="ubah-val_total_harga_rupiah" placeholder="" required="" readonly="" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="display:none">
                                    <div class="form-group">
                                        <label for="ubah-prioritas"> Prioritas</label>
                                        <input type="number" class="form-control" id="ubah-prioritas" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ubah-keterangan"> Keterangan</label>
                                        <input type="text" class="form-control" id="ubah-keterangan" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="ubah-submit">
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
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form-import" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <h4 style="font-weight: bold;" class="modal-title" id="modal-import-label">Import RAB Dari
                                Excel</h4>
                        </div>
                        <div class="col-md-6" id="title-cabang">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="file">File: xlsx atau xls</label>
                                <input type="hidden" id="id_cabang1" name="id_cabang1" value="<?= $id_cabang ?>" class="form-control">
                                <input type="file" class="form-control" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" placeholder="" required />
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

<div class="modal fade" id="modal-reset" tabindex="-1" role="dialog" aria-labelledby="modal-import" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-reset" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reset RAB</h4>
                </div>
                <div class="modal-body">
                    <h1 class="h5">Apakah anda yakin akan me-reset seluruh RAB cabang sekolah ini. ?</h1>
                    <p>Reset RAB ini akan mengubah seluruh nilai volume dan jumlah satuan dan total harga menjadi nol.!</p>
                    <p>Sebelum me-reset RAB ini harap download/export excel terlebih dahulu.!</p>
                    <input type="hidden" name="reset-rab" id="reset-rab" value="<?= $id_cabang ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        Submit
                    </button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    const npsn = '<?= $npsn ?>';
    const global_id_user = '<?= $id_user ?>';
    const global_id_cabang = '<?= $id_cabang ?>';
    const global_cabang_nama = '<?= $cabang_nama ?>';
</script>
<!--
status :
Proses : 0
Di ajukan : 1
Diterima : 2
Ditolak : 3 -->