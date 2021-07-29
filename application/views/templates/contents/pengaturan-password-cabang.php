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
                                            <label for="current_password"> Password Sebelumnya</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Sebelumnya" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="new_password"> Password Baru</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password Baru" required minlength="6" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="new_password_verify"> Ulangi Password Baru</label>
                                            <input type="password" class="form-control" id="new_password_verify" name="new_password_verify" placeholder="Ulangi Password Baru" required minlength="6" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5" style="margin-bottom: 20px;">
                                        <input type="checkbox" id="password_visibility" />
                                        <label for="password_visibility"> Perlihatkan Password</label>
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