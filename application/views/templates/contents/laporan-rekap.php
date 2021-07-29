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
                <div class="col-md-5">
                    <select class="form-control" name="cabang" id="cabang">
                        <?php foreach ($listCabang as $q) : ?>
                            <?php if (isset($cabang)) : ?>
                                <?php if ($cabang == $q['kode']) : ?>
                                    <option selected value="<?= $q['id'] ?>"><?= $q['kode'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $q['id'] ?>"><?= $q['kode'] ?></option>
                                <?php endif; ?>
                            <?php else : ?>
                                <option value="<?= $q['id'] ?>"><?= $q['kode'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <div id="datepicker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" id="filter-cari" class="btn btn-primary mr-2" style="width: 100%;"> <i class="fa fa-search"></i> Cari</button>
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
                                    <i class="fa fa-download"></i> Cetak
                                </button>
                            </div>

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th data-class="expand" style="width: 5%;" rowspan="2"> No. Urut</th>
                                        <th data-class="expand" style="width: 25%;" rowspan="2"> Program Keahlian</th>

                                        <th data-class="expand" style="width: 70%;" colspan="11"> Penggunaan Dana Bantuan Operasional</th>
                                    </tr>
                                    <tr>
                                        <th data-class="expand" style="width: 7%;"> Pengembangan Perpustakaan</th>
                                        <th data-class="expand" style="width: 7%;"> PPDB</th>
                                        <th data-class="expand" style="width: 7%;"> Kegiatan Pembelajaran dan Eskul Siswa</th>
                                        <th data-class="expand" style="width: 7%;"> Kegiatal Ulangan dan Ujiian</th>
                                        <th data-class="expand" style="width: 7%;"> Pembeliaan Bahan Habis Pakai</th>
                                        <th data-class="expand" style="width: 7%;"> Langganan Daya dan Jasa</th>
                                        <th data-class="expand" style="width: 7%;"> Bantuan Peserta Didik</th>
                                        <th data-class="expand" style="width: 7%;"> Pembiayaan Pengelolaan Bantuan</th>
                                        <th data-class="expand" style="width: 7%;"> Perbaikan / Pengadaan Sarana dan Prasarana Sekolah</th>
                                        <th data-class="expand" style="width: 7%;"> Peningkatan dan Kompetensi Guru dan Tenaga Kependidikan</th>
                                        <th data-class="expand" style="width: 7%;"> Jumlah</th>
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

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->
<!-- Modal -->