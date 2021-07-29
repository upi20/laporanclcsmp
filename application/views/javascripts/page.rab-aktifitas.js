$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()
	getKode()


	function dynamic() {
		$("#dt_basic").dataTable().fnDestroy()
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>rab/aktifitas/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			"pageLength": 10,
			"paging": true,
			"columns": [
				{ "data": "pengkodean", className: "width100" },
				{ "data": "kode", className: "width70" },
				{ "data": "uraian", className: "nowrap", },
				{ "data": "status", className: "nowrap width70", },
				{
					"data": "id", render(data, type, full, meta) {
						return `<div class="pull-right">
									<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
										<i class="fa fa-edit"></i> Ubah
									</button>
									<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
										<i class="fa fa-trash"></i> Hapus
									</button>
								</div>`
					}, className: "nowrap width130",
				}
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}

	function getKode() {
		// body...
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/aktifitas/getidpengkodeans',
			data: null,
		}).done((data) => {

			if (data.id == null) {
				$('#id_pengkodeans').html('');
				$('#kode').val('1');
			} else {
				$('#kode').val(data.id);
				$("#id_pengkodeans").html('<option value="" disable>Pilih pengkodean</option>');
				$.ajax({
					method: 'post',
					url: '<?= base_url() ?>rab/aktifitas/getDataPengkodeans',
					data: null,
				}).done((data2) => {
					console.log(data2)
					for (var i = 0; i < data2.length; i++) {
						$("#id_pengkodeans").append('<option value="' + data2[i].id + '">' + data2[i].kode + ' ' + data2[i].uraian + '</option>');
					}
				})
			}
		}).fail(($xhr) => {
			console.log($xhr)
		})
	}

	$('#id_pengkodeans').on('change', function () {
		if (this.value == '') {
			getKode()
		} else {
			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/aktifitas/getDetailPengkodeans',
				data: {
					id: this.value,
				},
			}).done((data) => {
				if (data.kode == '') {
					$("#id_pengkodeans").val(0);
				}
				var tamp = Number(data.kode) + 0.1;
				$("#kode").val(tamp.toFixed(1));

			}).fail(($xhr) => {
				// console.log($xhr)
			})
		}
	})


	// Fungsi simpan
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let id_pengkodeans = $('#id_pengkodeans').val()
		let kode = $('#kode').val()
		let uraian = $('#uraian').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert
			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/aktifitas/insert',
				data: {
					id_pengkodeans: id_pengkodeans,
					kode: kode,
					uraian: uraian,
					status: status
				}
			}).done((data) => {
				$.doneMessage('Berhasil ditambahkan.', 'Aktifitas')
				$('#id').val('')
				$('#id_pengkodeans').val('')
				$('#kode').val('')
				$('#uraian').val('')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()
			})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Aktifitas')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/aktifitas/update',
				data: {
					id: id,
					id_pengkodeans: id_pengkodeans,
					kode: kode,
					uraian: uraian,
					status: status
				}
			}).done((data) => {
				$.doneMessage('Berhasil diubah.', 'Aktifitas')
				$('#id').val('')
				$('#id_pengkodeans').val('')
				$('#kode').val('')
				$('#uraian').val('')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Aktifitas')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		}
	})

	// Fungsi Delete
	$('#OkCheck').click(() => {

		let id = $("#idCheck").val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/aktifitas/delete',
			data: {
				id: id
			}
		}).done((data) => {
			$.doneMessage('Berhasil dihapus.', 'Aktifitas')
			$("#dt_basic").dataTable().fnDestroy()
			dynamic()

		})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Aktifitas')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Aktifitas')
		$('#id').val('')
		$('#id_pengkodeans').val('')
		$('#kode').val('')
		$('#uraian').val('')
		$('#status').val('')
		getKode()
		$('#myModal').modal('toggle')
	})

})


// Click Hapus
const Hapus = (id) => {
	$("#idCheck").val(id)
	$("#LabelCheck").text('Form Hapus')
	$("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
	$('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (id) => {
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>rab/aktifitas/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Aktifitas')
		console.log(data)
		$('#id').val(data.id)
		$('#id_pengkodeans').val(data.id_pengkodeans)
		$('#kode').val(data.kode)
		$('#uraian').val(data.uraian)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
		.fail(($xhr) => {
			$.failMessage('Gagal mendapatkan data.', ' Aktifitas')
		})
}
