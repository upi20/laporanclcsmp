$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>pengaturan/rab/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "keterangan" },
				{ "data": "tanggal_mulai", },
				{ "data": "tanggal_akhir" },
				{ "data": "status", render:(data) => data == 1 ? 'Aktif' : 'Tidak aktif'},
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
		let keterangan = $('#keterangan').val()
		let tanggal_mulai = $('#tanggal_mulai').val()
		let tanggal_akhir = $('#tanggal_akhir').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/rab/insert',
					data: {keterangan, tanggal_mulai, tanggal_akhir, status}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'Rab')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Rab')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/rab/update',
					data: {id, keterangan, tanggal_mulai, tanggal_akhir, status}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'Rab')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Rab')
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
				url: '<?= base_url() ?>pengaturan/rab/delete',
				data: {id}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'RAB')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'RAB')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah RAB')
		$('#id').val('')
		$('#keterangan').val('')
		$('#tanggal_mulai').val('')
		$('#tanggal_akhir').val('')
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
		url: '<?= base_url() ?>pengaturan/rab/getDataDetail',
		data: {id}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Rab')
		$('#id').val(data.id)
		$('#keterangan').val(data.keterangan)
		$('#tanggal_mulai').val(data.tanggal_mulai)
		$('#tanggal_akhir').val(data.tanggal_akhir)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Rab')
	})
}
