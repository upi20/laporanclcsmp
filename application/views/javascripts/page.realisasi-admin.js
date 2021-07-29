$(() => {
    let base_url = '<?php echo base_url();?>'
    // initialize responsive datatable
    dynamic()
    function dynamic(npsn = null) {
        $('#dt_basic').DataTable({
            "ajax": {
                "url": "<?= base_url()?>realisasi/ajax_data/",
                "data": {
                    'npsn': npsn
                },
                "type": 'POST'
            },
            "scrollX": true,
            "processing": true,
            "columns": [
                { "data": "kode", className: "width100" },
                { "data": "nama", className: "nowrap" },
                {
                    "data": "total_ringgit", render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(data, 6)
                    }, className: "width130"
                },
                {
                    "data": "total_rupiah", "data": "total_ringgit", render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(data, 6)
                    }, className: "width130"
                },
                {
                    "data": "id_cabang", render(data, type, full, meta) {
                        return `						<a class="btn btn-success btn-xs" style="margin-right: 10px" href="${base_url}realisasi/admindetail/${data}">
                        <i class="fa fa-edit"></i> Detail
                    </a>`
                    }, className: "width65"
                }
            ],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': ["no-sort"] }
            ]
        })
    }

})
