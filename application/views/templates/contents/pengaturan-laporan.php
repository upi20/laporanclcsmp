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
                        <form id="input_pengaturan">
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="kepala_sekolah"> Kepala Sekolah</label>
                                            <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah" placeholder="Kepala Sekolah" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="nip_kepala_sekolah"> NIP Kepala Sekolah</label>
                                            <input type="text" class="form-control" id="nip_kepala_sekolah" id="nip_kepala_sekolah" placeholder="NIP Kepala Sekolah" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="pemegang_kas"> Pemegang Kas</label>
                                            <input type="text" class="form-control" id="pemegang_kas" id="pemegang_kas" placeholder="Pemegang Kas" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="nip_pemegang_kas"> NIP Pemegang Kas</label>
                                            <input type="text" class="form-control" id="nip_pemegang_kas" id="nip_pemegang_kas" placeholder="NIP Pemegang Kas" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="kota" id="kota"> Kota</label>
                                            <input type="text" class="form-control" id="kota" id="kota" placeholder="Kota" required />
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="submit" id="btn-submit" disabled>Simpan</button>
                            </div>
                        </form>
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