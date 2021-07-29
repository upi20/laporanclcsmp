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
        <div class="col-xs-12 col-sm-5">
            <a href="#" id="bayar-hutang" class="btn btn-default" style="float: right; margin-top: 10px;"> <i class="fa fa-download"></i> Bayar Hutang</a>
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
                                        <th>Nama</th>
                                        <th>No Handphone</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah (RM)</th>
                                        <!-- <th>Dibayar</th> -->
                                        <!-- <th>Sisa</th> -->
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th style="width: 24%;"><i class="fa fa-fw fa-thumb-tack text-muted hidden-md hidden-sm hidden-xs"></i>Edit
                                            Data</th>
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
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="modal-title" id="myModalLabel"></h4>
                        </div>
                        <div class="col-md-6">
                            <h4 style="margin-top: -14px; text-align: right; margin-right: 20px;" class="modal-title" id="totalSaldo"></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> Nama</label>
                                <input type="text" class="form-control" id="nama" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> No Handphone</label>
                                <input type="text" class="form-control" id="no_hp" placeholder="" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> Keterangan</label>
                                <textarea class="form-control" id="keterangan"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> Jumlah (RM)</label>
                                <input type="text" class="form-control" id="jumlah" placeholder="Masukan jumlah sesuai minus saldo / pinjaman" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" placeholder="" required />
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

<div class="modal fade" id="myModalHutang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-bayar-hutang">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="modal-title" id="myModalHutangLabel"></h4>
                        </div>
                        <div class="col-md-6">
                            <h4 style="margin-top: -14px; text-align: right; margin-right: 20px;" class="modal-title" id="totalHutang"></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> Jumlah Saldo</label>
                                <input type="text" class="form-control" id="jumlah-saldo" required readonly />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama"> Dibayar</label>
                                <input type="text" class="form-control" id="dibayar" placeholder="" required readonly />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tanggal-administrasi"> Tanggal Administrasi</label>
                                <input type="date" class="form-control" id="tanggal-administrasi" placeholder="" value="<?= date("Y-m-d") ?>" required />
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