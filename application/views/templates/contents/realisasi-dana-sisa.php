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
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false"
                    data-widget-deletebutton="false">
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
                            <form action="realisasi/simpanDanaSisa" method="POST">

                                <table id="dt_basic" class="table table-striped table-bordered table-hover"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th> <input type="checkbox" onchange="handleSetAllCheckbox(this)"
                                                    id="check-all"> Semua</th>
                                            <th> Kode Standar</th>
                                            <th> Nama</th>
                                            <th> Anggaran RAB (RM)</th>
                                            <th> Anggaran RAB (Rp)</th>
                                            <th> Harga Real (RM)</th>
                                            <th> Harga Real (Rp)</th>
                                            <th> Selisih (RM)</th>
                                            <th> Selisih (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dana_sisa as $q) : ?>
                                        <tr>
                                            <td><input name="id_realisasi[]" value="<?= $q['id_realisasi'] ?>"
                                                    type="checkbox" class="check"
                                                    data-ringgit="<?= $q['sisa_ringgit'] ?>"
                                                    data-id_rab="<?= $q['id'] ?>"
                                                    data-rupiah="<?= $q['sisa_rupiah'] ?>"></td>
                                            <td><?= $q['kodes'] ?></td>
                                            <td><?= $q['nama_aktifitas'] ?></td>
                                            <td class="text-ringgit"><?= $q['total_harga_ringgit'] ?></td>
                                            <td class="text-rupiah"><?= $q['total_harga_rupiah'] ?></td>
                                            <td class="text-ringgit"><?= $q['harga_ringgit'] ?></td>
                                            <td class="text-rupiah"><?= $q['harga_rupiah'] ?></td>
                                            <td class="text-ringgit"><?= $q['sisa_ringgit'] ?></td>
                                            <td class="text-rupiah"><?= $q['sisa_rupiah'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#" onclick="ubah(this)" class="btn btn-default" id="btn-ubah" disabled>
                                            Alihkan</a>
                                    </div>
                                </div>
                            </form>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" id="id">
            <input type="hidden" name="id_cabang" id="id_cabang" value="<?= $id_cabang ?>">
            <input type="hidden" name="val_npsn" id="val-npsn">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col">
                            <br>
                            <h4 style="font-weight: bold; text-align:center" class="modal-title" id="myModalLabel">Label
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12" style="display: none;">
                                    <div class="form-group">
                                        <label for="nama"> Kategori Pengalihan</label>
                                        <select name="pilihan-tambahan" class="form-control" id="pilihan-tambahan">
                                            <option value="rab"> RAB</option>
                                            <option value="non-rab"> Non-RAB</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="form-rab">
                                    <div class="col-md-12" id="kode-label">
                                        <div class="form-group">
                                            <label for="val-kode"> Kode Standar</label>
                                            <select id="val-kode" style="width:100%" class="form-control" name="kode">
                                                <option value="">Pilih Kode</option>
                                                <?php foreach ($kodeNPSN as $key) : ?>
                                                <option value="<?= $key['kode'] ?>"><?= $key['kode'] ?>
                                                    <?= $key['nama'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <!-- <input list="kode" id="val-kode" name="kode" class="form-control" placeholder="Kode Standar"> -->
                                            <!-- <datalist id="kode" style="display: none;">
										</datalist> -->
                                            <!-- <select name="kode" class="choices form-control" id="kode">
											<option value="">Pilih Aktifitas</option>
										</select> -->
                                            <input type="hidden" name="id_rab" id="id_rab">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6" id="text-total-ringgit">
                                                <div class="form-group">
                                                    <label for="nama"> Total Ringgit</label>
                                                    <input type="hidden" name="total_ringgit" id="total-ringgit">
                                                    <input type="text" class="form-control" id="jumlah-total-ringgit"
                                                        readonly="" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama"> Total Rupiah</label>
                                                    <input type="hidden" name="total_rupiah" id="total-rupiah">
                                                    <input type="text" class="form-control" id="jumlah-total-rupiah"
                                                        readonly="" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama"> Jumlah Dana Sisa Ringgit Ditambahkan</label>
                                                    <input type="hidden" name="sisa_ringgit" id="sisa-ringgit">
                                                    <input type="text" class="form-control" id="jumlah-sisa-ringgit"
                                                        name="jumlah_sisa_ringgit" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama"> Jumlah Dana Sisa Rupiah Ditambahkan</label>
                                                    <input type="hidden" name="sisa_rupiah" id="sisa-rupiah">
                                                    <input type="text" class="form-control" id="jumlah-sisa-rupiah"
                                                        name="jumlah_sisa_rupiah" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="jumlah-total-sisa">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama"> Jumlah Dana Sisa Total Ringgit
                                                        Ditambahkan</label>
                                                    <input type="hidden" name="sisa_total_ringgit"
                                                        id="sisa-total-ringgit">
                                                    <input type="text" class="form-control"
                                                        id="jumlah-sisa-total-ringgit" name="jumlah-sisa-total-ringgit"
                                                        readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama"> Jumlah Dana Sisa Total Rupiah Ditambahkan</label>
                                                    <input type="hidden" name="sisa_total_rupiah"
                                                        id="sisa-total-rupiah">
                                                    <input type="text" class="form-control"
                                                        id="jumlah-sisa-total-rupiah" name="jumlah-sisa-total-rupiah"
                                                        readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama"> Keterangan</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="form-non-rab" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                            <input type="text" class="form-control" id="kode"
                                                                placeholder="" readonly />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nama"> Uraian</label>
                                                            <input type="text" class="form-control" id="nama"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Harga (RM)</label>
                                                            <input type="text" class="form-control" id="harga_ringgit"
                                                                placeholder="" value="0" required readonly />
                                                            <input type="hidden" class="form-control"
                                                                id="val_harga_ringgit" placeholder="" value="0"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Harga (Rp)</label>
                                                            <input type="text" class="form-control" id="harga_rupiah"
                                                                placeholder="" value="0" required readonly="" />
                                                            <input type="hidden" class="form-control"
                                                                id="val_harga_rupiah" placeholder="" value="0" required
                                                                readonly="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Jumlah</label>
                                                            <input type="number" class="form-control" id="jumlah_1"
                                                                placeholder="" value="1" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Satuan</label>
                                                            <input type="text" class="form-control" id="satuan_1"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Jumlah</label>
                                                            <input type="number" class="form-control" id="jumlah_2"
                                                                placeholder="" value="1" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Satuan</label>
                                                            <input type="text" class="form-control" id="satuan_2"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Jumlah</label>
                                                            <input type="number" class="form-control" id="jumlah_3"
                                                                placeholder="" value="1" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Satuan</label>
                                                            <input type="text" class="form-control" id="satuan_3"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Jumlah</label>
                                                            <input type="number" class="form-control" id="jumlah_4"
                                                                placeholder="" value="1" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Satuan</label>
                                                            <input type="text" class="form-control" id="satuan_4"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Jumlah (RM)</label>
                                                            <input type="text" class="form-control"
                                                                id="total_harga_ringgit" placeholder="" required
                                                                readonly="" />
                                                            <input type="hidden" class="form-control"
                                                                id="val_total_harga_ringgit" placeholder="" required
                                                                readonly="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama"> Jumlah (Rp)</label>
                                                            <input type="text" class="form-control"
                                                                id="total_harga_rupiah" placeholder="" required
                                                                readonly="" />
                                                            <input type="hidden" class="form-control"
                                                                id="val_total_harga_rupiah" placeholder="" required
                                                                readonly="" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12" style="display:none">
                                                        <div class="form-group">
                                                            <label for="nama"> Prioritas</label>
                                                            <input type="number" class="form-control" id="prioritas"
                                                                placeholder="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="non-rab-keterangan"> Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                id="non-rab-keterangan" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submit-modal" disabled>
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
let npsn = '<?= $npsn ?>'
let id_cabang = '<?= $id_cabang ?>'
let global_id_cabang = '<?= $id_cabang ?>'
let isUbah = false;

function handleSetAllCheckbox(data) {
    $(".check").prop("checked", data.checked);
    setBtnUbah();
}
</script>