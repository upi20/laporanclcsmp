$(() => {


	// initialize responsive datatable
	$.initBasicTable('#dt_basic')
	const $table = $('#dt_basic').DataTable()
	$table.columns(0)
		.order('asc')
		.draw()





	// Add Row
	const addRow = (data) => {
		let row = [
			data.id,
			data.nama,
			data.keterangan,
			(data.status == 1) ? 'Aktif' : 'Tidak Aktif',
			'<div>' +
			'<button class="btn btn-primary btn-sm" onclick="Ubah(' + data.id + ')"><i class="fa fa-edit"></i> Ubah</button>' +
			'<button class="btn btn-danger btn-sm" onclick="Hapus(' + data.id + ')"><i class="fa fa-trash"></i> Hapus</button>' +
			'</div>'
		]

		let $node = $($table.row.add(row).draw().node())
		$node.attr('data-id', data.id)
	}

	// Edit Row
	const editRow = (id, data) => {
		let row = $table.row('[data-id=' + id + ']').index()

		$($table.row(row).node()).attr('data-id', id)
		$table.cell(row, 0).data(data.id)
		$table.cell(row, 1).data(data.nama)
		$table.cell(row, 2).data(data.keterangan)
		$table.cell(row, 3).data((data.status == 1) ? 'Aktif' : 'Tidak Aktif')
	}

	// Delete Row
	const deleteRow = (id) => {
		$table.row('[data-id=' + id + ']').remove().draw()
	}





	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let nama = $('#nama').val()
		let keterangan = $('#keterangan').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>mataPelajaran/insert',
					data: {
						nama: nama,
						keterangan: keterangan,
						status: status
					}
				}).done((data) => {
					if(data.codeStatus == 0)
					{
						$.doneMessage('Berhasil ditambahkan.', 'Mata Pelajaran')
						addRow(data)
					}
					else
					{
						$.failMessage('Data sudah ada.', 'Mata Pelajaran')
					}

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Mata Pelajaran')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>mataPelajaran/update',
					data: {
						id: id,
						nama: nama,
						keterangan: keterangan,
						status: status
					}
				}).done((data) => {
					if(data.codeStatus == 0)
					{
						$.doneMessage('Berhasil diubah.', 'Mata Pelajaran')
						editRow(id, data)
					}
					else
					{
						$.failMessage('Data sudah ada.', 'Mata Pelajaran')
					}

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Mata Pelajaran')
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
				url: '<?= base_url() ?>mataPelajaran/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Mata Pelajaran')
				deleteRow(id)

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Mata Pelajaran')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Mata Pelajaran')
		$('#id').val('')
		$('#nama').val('')
		$('#keterangan').val('')
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
			url: '<?= base_url() ?>mataPelajaran/getDataDetail',
			data: {
				id: id
			}
		}).done((data) => {
			$('#myModalLabel').html('Ubah Mata Pelajaran')
			$('#id').val(data.id)
			$('#nama').val(data.nama)
			$('#keterangan').val(data.keterangan)
			$('#status').val(data.status)

			$('#myModal').modal('toggle')
		})
		.fail(($xhr) => {
			$.failMessage('Gagal mendapatkan data.', ' Mata Pelajaran')
		})
}
