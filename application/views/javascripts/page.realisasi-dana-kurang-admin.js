$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()
	function dynamic(npsn = null) {
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>realisasi/ajax_data_dana_kurang/",
				"data": {
					'npsn': npsn
				},
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"columns": [
				{ "data": "kode" },
				{ "data": "nama" },
				{
					"data": "sisa_ringgit", render(data, type, full, meta) {
						return window.apiClient.format.format_ringgit(data, 6)
					},
				},
				{
					"data": "sisa_rupiah", render(data, type, full, meta) {
						return window.apiClient.format.format_ringgit(data, 6)
					},
				},
				{
					"data": "id_cabang", render(data, type, full, meta) {
						return `						<a class="btn btn-success btn-xs" style="margin-right: 10px" href="${base_url}realisasi/admindanakurang/${data}">
                        <i class="fa fa-edit"></i> Detail
                    </a>`
					}
				}
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}

})
