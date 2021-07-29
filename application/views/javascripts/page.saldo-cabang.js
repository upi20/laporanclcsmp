$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable()
	}


	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let nama = $('#nama').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/saldo/insert',
					data: {
						nama: nama,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'saldo')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'saldo')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/saldo/update',
					data: {
						id: id,
						nama: nama,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'saldo')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'saldo')
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
				url: '<?= base_url() ?>pengaturan/saldo/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'saldo')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'saldo')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('TAMBAH SALDO')
		$('#id').val('')
		$('#nama').val('')
		$('#status').val(1)
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
		url: '<?= base_url() ?>pengaturan/saldo/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah saldo')
		$('#id').val(data.id)
		$('#nama').val(data.nama)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' saldo')
	})
}
