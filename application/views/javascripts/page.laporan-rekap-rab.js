let global_date_start = "";
let global_date_end = "";
let filter_data_tanggal = { start: global_date_start, end: global_date_end };
let initial = false;
$(() => {
    let base_url = '<?php echo base_url();?>'

    // // initialize responsive datatable
    dynamic()

    function dynamic(tahun = null) {
        const range_selected = $("#date-range");

        // header tabel
        const semester1 = '<th>Januari</th><th>Februari</th><th>Maret</th><th>April</th><th>Mei</th><th>Juni</th>';
        const semester2 = '<th>Juli</th><th>Agustus</th><th>September</th><th>Oktober</th><th>Nopember</th><th>Desember</th>';

        // custom month
        let jml_bulan = 12;
        let month_column = '';
        let month_start = 1;
        let month_end = 12;

        // data of month
        const data_table = [];

        // date selected comparaison
        if (range_selected.val() == "1") {
            jml_bulan = 6;
            month_column = semester1;
            month_end = 6;
        } else if (range_selected.val() == "2") {
            jml_bulan = 6;
            month_column = semester2;
            month_start = 7;
            month_end = 12;
        } else {
            jml_bulan = 12;
            month_column = semester1 + semester2;
        }

        for (let i = month_start; i <= month_end; i++) {
            data_table.push({
                "data": "realisasi", render(data, type, full, meta) {
                    return window.apiClient.format.format_ringgit(data[i], 6);
                }
            });
        }

        $("#dt_basic").empty();
        $("#dt_basic").append(`<thead><tr><th rowspan="2">Kode</th><th rowspan="2">Nama CLC</th><th rowspan="2">Total Anggaran</th><th colspan="${jml_bulan}">Pengeluaran Bulan (RM)</th><th rowspan="2">Jumlah Pengeluaran</th></tr><tr>${month_column}</tr></tbody></thead>`);
        $("#dt_basic").dataTable().fnDestroy()
        $('#dt_basic').DataTable({
            "ajax": {
                "url": "<?= base_url()?>laporan/rekapRAB/ajax_data",
                "data": {
                    tahun: tahun,
                    start: month_start,
                    end: month_end
                },
                "type": 'POST'
            },
            "scrollX": true,
            "processing": true,
            // "serverSide": true,
            "pageLength": 10,
            "columns": [
                { "data": "kode" },
                { "data": "nama" },
                {
                    "data": "anggaran", render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(data, 6);
                    }
                },
                ...data_table
                ,
                {
                    "data": "pengeluaran", render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(data, 6);
                    }
                },
                // {
                //     "data": "saldo", render(data, type, full, meta) {
                //         return window.apiClient.format.format_ringgit(data,6);
                //     }
                // },
            ],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': ["no-sort"] }
            ]
        })
        // $.ajax({
        //     method: 'post',
        //     url: '<?= base_url() ?>laporan/rekapRAB/ajax_data',
        //     data: {
        //         tahun: tahun,
        //         start: month_start,
        //         end: month_end
        //     }
        // }).done((data) => {
        //     console.log(data);

        // })
    }

    $('#filter-cari').click(function () {
        $("#dt_basic").dataTable().fnDestroy()
        dynamic($("#tahun").val());
    });

    $('#tahun').change(function () {
        $("#dt_basic").dataTable().fnDestroy()
        dynamic($("#tahun").val());
    });

    $('#cetak').click(function () {

        window.location = "<?=base_url()?>/laporan/rekapRAB/cetak?tahun=" + $("#tahun").val() + "&semester=" + $("#date-range").val();
    });

})

