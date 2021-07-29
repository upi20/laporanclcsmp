<style>
    th {
        text-align: center;
    }
</style>
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
                <div class="col-md-4">
                </div>
                <div class="col-md-3">
                    <select name="date-range" id="date-range" class="form-control">
                        <option value="tahun">Tahunan</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="tahun" id="tahun" value="<?= $tahun ?>" class="form-control" placeholder="Tahun">
                </div>
                <div class="col-md-2">
                    <button type="button" id="filter-cari" class="btn btn-primary mr-2" style="width: 100%;"> <i class="fa fa-search"></i> Cari</button>
                </div>
            </div>
        </div>

    </div>
    <!-- end col -->

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

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">

                            <div class="pull-right">
                                <button type="submit" class="btn btn-success btn-sm" id="cetak">
                                    <i class="fa fa-download"></i> Cetak Excel
                                </button>
                            </div>

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Kode</th>
                                        <th rowspan="2">Nama CLC</th>
                                        <th rowspan="2">Total Anggaran</th>
                                        <th colspan="12">Pengeluaran Bulan (RM)</th>
                                        <th rowspan="2">Jumlah Pengeluaran</th>
                                        <th rowspan="2">Saldo</th>
                                    </tr>
                                    <tr>
                                        <th>Januari</th>
                                        <th>Februari</th>
                                        <th>Maret</th>
                                        <th>April</th>
                                        <th>Mei</th>
                                        <th>Juni</th>
                                        <th>Juli</th>
                                        <th>Agustus</th>
                                        <th>September</th>
                                        <th>Oktober</th>
                                        <th>Nopember</th>
                                        <th>Desember</th>
                                    </tr>
                                    </tbody>
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

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->
<!-- Modal -->