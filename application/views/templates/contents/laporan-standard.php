<div id="content">

  <!-- row -->
  <div class="row">

    <!-- col -->
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
      <h1 class="page-title txt-color-blueDark" style="font-weight:bold; text-transform: unset;">
        <!-- PAGE HEADER -->
        <i class="fa-fw fa fa-table"></i>

        <?= $title ?>
      </h1>
    </div>
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
      <div class="row">
        <div class="col-md-3">
          <select class="form-control" name="filter_data_cabang" id="filter_data_cabang">
            <option value="">--Pilih NPSN--</option>
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
        <div class="col-md-2">
          <input type="text" class="form-control" name='kode' placeholder="Search by Code" id="kode">
        </div>
        <div class="col-md-5">
          <div id="datepicker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
          </div>
        </div>
        <div class="col-md-2">
          <button type="submit" id="filter-cari" class="btn btn-primary">Cari</button>
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
              <input class="form-control" type="text">
            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body">

              <div class="pull-right">
                <button class="btn btn-success btn-sm" id="cetak">
                  <i class="fa fa-plus"></i> Cetak
                </button>
              </div>

              <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                  <tr>
                    <th data-class="expand" style="width: 7%;"></i> NPSN</th>
                    <th data-class="expand" style="width: 33%;"></i> Cabang</th>
                    <th data-class="expand" style="width: 12%;"></i> Tanggal</th>
                    <th data-class="expand" style="width: 12%;"></i> Kode</th>
                    <th data-class="expand" style="width: 20%;"></i> Uraian</th>
                    <th data-class="expand" style="width: 13%;"> RM</th>
                    <th data-class="expand" style="width: 13%;"> Rp</th>
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