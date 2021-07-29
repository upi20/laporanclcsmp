let global_date_start = "";
let global_date_end = "";
let filter_data_tanggal = { start: global_date_start, end: global_date_end };
let initial = false;
$(() => {
	{
		var start = moment().startOf('month');
		var end = moment().endOf('month');

		function cb(start, end) {
			$('#datepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			global_date_start = start.format('YYYY-MM-DD');
			global_date_end = end.format('YYYY-MM-DD');
			filter_data_tanggal = { start: global_date_start, end: global_date_end };
			initial || dynamic(filter_data_tanggal, $("#cabang").val());
			initial = true;
		}

		$('#datepicker').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
				// 'Hari ini': [moment(), moment()],
				// 'Hari Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
				// 'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				// 'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
				// 'Tahun Kemarin': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
				// 'Semester 1': [moment().startOf('year'), moment().month("June").endOf('month')],
				// 'Semester 2': [moment().month("July").startOf('month'), moment().endOf('year')],
			}
		}, cb);

		cb(start, end);

		$('#datepicker').on('apply.daterangepicker', function (ev, picker) {
			global_date_start = picker.startDate.format('YYYY-MM-DD');
			global_date_end = picker.endDate.format('YYYY-MM-DD');
		});
	}

	let base_url = '<?php echo base_url();?>'

	function dynamic(tanggal = null, cabang = null) {
		$("#dt_basic").dataTable().fnDestroy()
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>laporan/bku/ajax_data/",
				"data": {
					tanggal: JSON.stringify(tanggal),
					cabang: cabang
				},
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			// "serverSide": true,
			"pageLength": 10,
			"columns": [
				{ "data": "kode_cabang" },
				{ "data": "nama_cabang" },
				{ "data": "tanggal" },
				{ "data": "kode" },
				{ "data": "nama_uraian" },
				{
					"data": "harga_ringgit", render(data, type, full, meta) {
						return '<p style="text-align: right;">' + window.apiClient.format.format_ringgit(full.harga_ringgit, 6) + '</p>'
					}
				},
				{
					"data": "harga_rupiah", render(data, type, full, meta) {
						return '<p style="text-align: right;">' + window.apiClient.format.format_rupiah(full.harga_rupiah, 6) + '</p>'
					}
				},
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}

	$('#filter-cari').click(function () {
		filter_data_tanggal = { start: global_date_start, end: global_date_end }
		let cabang = $("#cabang").val()
		$("#dt_basic").dataTable().fnDestroy()
		dynamic(filter_data_tanggal, cabang)
	});

	$('#cetak').click(function () {
		let tanggal = $("#tanggal").val()
		let cabang = $("#cabang").val()
		window.location = "<?=base_url()?>laporan/bku/cetak?cabang=" + cabang + "&tanggal-start=" + global_date_start + "&tanggal-end=" + global_date_end;
	});

})

