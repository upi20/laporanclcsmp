$(() => {

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>jadwal/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "id", render(data, type, full, meta)
					{
						return full.nama + ' ' + full.token
					} 
				},
				{ "data": "mode_jadwal", render(data)
					{
						return 'Mode ' + data
					} 
				},
				{ "data": "mode_timer", render(data)
					{
						return 'Mode ' + data
					}  
				},
				{ "data": "kota" },
				{ "data": "waktu_mulai" },
				{ "data": "waktu_selesai" },
				{ 
					"data": "status", render(data, type, full, meta)
					{
						return (data > 0) ? 'Aktif' : 'Tidak Aktif' 
					} 
				},
				{
					"data": "id", render(data, type, full, meta)
					{
						return `${(lev_id == 4) 
									?
									`${(full.mode_jadwal == 2) ? `<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
											<i class="fa fa-edit"></i> Ubah
										</button>` : ''}`
									: `<div class="pull-right">
										<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
											<i class="fa fa-edit"></i> Ubah
										</button>
										<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
											<i class="fa fa-trash"></i> Hapus
										</button>
									</div>`
								}`
					}
				}
			],
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
			]
		})
	}

	$('#mata-pelajaran').on('change', e =>
	{
		e.preventDefault()

		let mapel = $('#mata-pelajaran').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>jadwal/getSoalData/',
			data:
			{
				id: mapel,
			}
		}).done(data =>
		{
			$('#soal').html('<option value="">--Pilih Soal--</option>')

			$.each(data, (val, key) =>
			{
				$('#soal').append('<option value="'+key.id+'">'+key.token+'</option>')
			})
		})
	})

	$('#mode-timer').on('change', e =>
	{
		e.preventDefault()

		let mode = $('#mode-timer').val()

		// if(mode == 2)
		// {
		// 	$("#waktu").css('display', 'none')
		// }
		// else
		// {
		// 	$("#waktu").css('display', 'block')
		// }
	})



	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let soal = $('#soal').val()
		let kota = $('#kota').val()
		let mode_jadwal = $('#mode-jadwal').val()
		let mode_timer = $('#mode-timer').val()
		let waktu_mulai = $('#waktu-mulai').val()
		let waktu_selesai = $('#waktu-selesai').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>jadwal/insert',
					data: {
						soal: soal,
						kota: kota,
						mode_jadwal: mode_jadwal,
						mode_timer: mode_timer,
						waktu_mulai: waktu_mulai,
						waktu_selesai: waktu_selesai,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'Kota')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Kota')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>jadwal/update',
					data: {
						id: id,
						soal: soal,
						kota: kota,
						mode_jadwal: mode_jadwal,
						mode_timer: mode_timer,
						waktu_mulai: waktu_mulai,
						waktu_selesai: waktu_selesai,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'Kota')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Kota')
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
				url: '<?= base_url() ?>jadwal/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Kota')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Kota')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Kota')
		$('#id').val('')
		$('#mata-pelajaran').val('')
		$('#soal').val('')
		$('#kota').val('')
		$('#mode-jadwal').val('')
		$('#mode-timer').val('')
		$('#waktu-mulai').val('')
		$('#waktu-selesai').val('')
		$('#status').val('')
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
		url: '<?= base_url() ?>jadwal/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Kota')
		$('#id').val(data.id)
		$('#mata-pelajaran').val(data.id_mapel)
		let id_soal = data.id_soal
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>jadwal/getSoalData/',
			data:
			{
				id: data.id_mapel,
			}
		}).done(data =>
		{
			$('#soal').html('<option value="">--Pilih Soal--</option>')

			$.each(data, (val, key) =>
			{
				$('#soal').append(`<option ${(id_soal == key.id) ? 'selected' : ''} value="${key.id}">${key.token}</option>`)
			})


		})

		// if(data.mode_timer == 2)
		// {
		// 	$("#waktu").css('display', 'none')
		// }
		// else
		// {
		// 	$("#waktu").css('display', 'block')
		// }
		
		$('#kota').val(data.kota_kab)
		$('#mode-jadwal').val(data.mode_jadwal)
		$('#mode-timer').val(data.mode_timer)
		$('#waktu-mulai').val(data.waktu_mulai)
		$('#waktu-selesai').val(data.waktu_selesai)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Kota')
	})
}
