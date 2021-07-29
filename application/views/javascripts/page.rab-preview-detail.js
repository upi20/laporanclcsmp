$(() => {
	// replace total_ringgit
	{
		const element = $("#format_ringgit_total");
		element.text(window.apiClient.format.format_ringgit(element.text(), false));
	}

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic(npsn)

	function dynamic(npsn) {
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>rab/preview/ajax_data_detail/",
				"data": {
					npsn: npsn,
				},
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			"columns": [
				// { "data": "uraian" },
				{ "data": "kodes" },
				{ "data": "nama_aktifitas" },
				{ "data": "jumlah_1" },
				{ "data": "satuan_1" },
				{ "data": "jumlah_2" },
				{ "data": "satuan_2" },
				{ "data": "jumlah_3" },
				{ "data": "satuan_3" },
				{ "data": "jumlah_4" },
				{ "data": "satuan_4" },
				{
					"data": "harga_ringgit", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_ringgit(data, 6) + '<p>';
					}
				},
				{
					"data": "harga_rupiah", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_rupiah(data, 6) + '<p>';
					}
				},
				{
					"data": "total_harga_ringgit", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_ringgit(data, 6) + '<p>';
					}
				},
				{
					"data": "total_harga_rupiah", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_rupiah(data, 6) + '<p>';
					}
				},
				{ "data": "keterangan" }
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}



})

