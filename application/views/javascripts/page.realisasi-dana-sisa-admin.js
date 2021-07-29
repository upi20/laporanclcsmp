$(() => {
    let base_url = '<?php echo base_url();?>'
    // initialize responsive datatable
    dynamic()
    function dynamic(npsn = null) {
        $('#dt_basic').DataTable({
            "ajax": {
                "url": "<?= base_url()?>realisasi/ajax_data_dana_sisa/",
                "data": {
                    'npsn': npsn
                },
                "type": 'POST'
            },
            "scrollX": true,
            "processing": true,
            "columns": [
                { "data": "kode", className: "width100" },
                { "data": "nama" },
                {
                    "data": "sisa_ringgit", render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(data, 6)
                    }, className: "width130"
                },
                {
                    "data": "sisa_rupiah", render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(data, 6)
                    }, className: "width130"
                },
                {
                    "data": "id_cabang", render(data, type, full, meta) {
                        return `						<a class="btn btn-success btn-xs" style="margin-right: 10px" href="${base_url}realisasi/admindanasisa/${data}">
                        <i class="fa fa-edit"></i> Detail
                    </a>`
                    }, className: "width70"
                }
            ],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': ["no-sort"] }
            ]
        })
    }

})
