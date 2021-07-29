$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>pengaturan/kurs/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "ringgit" },
				{ "data": "rupiah" },
				{ "data": "status" },
				{
					"data": "id", render(data, type, full, meta)
					{
						return `<div class="pull-right">
									<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
										<i class="fa fa-edit"></i> Ubah
									</button>
									<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
										<i class="fa fa-trash"></i> Hapus
									</button>
								</div>`
					}
				}
			],
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
			]
		})
	}


	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let ringgit = $('#ringgit').val()
		let rupiah = $('#rupiah').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/kurs/insert',
					data: {
						ringgit: ringgit,
						rupiah: rupiah,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'Kurs')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'kurs')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/kurs/update',
					data: {
						id: id,
						ringgit: ringgit,
						rupiah: rupiah,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'Kurs')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Kurs')
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
				url: '<?= base_url() ?>pengaturan/kurs/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Kurs')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Kurs')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Kurs')
		$('#id').val('')
		$('#nama').val('')
		$('#status').val()
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
		url: '<?= base_url() ?>pengaturan/kurs/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Kurs')
		$('#id').val(data.id)
		$('#ringgit').val(data.ringgit)
		$('#rupiah').val(data.rupiah)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Kurs')
	})
}
