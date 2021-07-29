$(() => {

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>detailSoal/ajax_data/" + id_soal,
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "kategori" },
				{ "data": "jawaban" },
				{ "data": "keterangan" },
				{ "data": "gambar" },
				{ "data": "file_audio" },
				{ 
					"data": "status", render(data, type, full, meta)
					{
						return (data > 0) ? 'Aktif' : 'Tidak Aktif' 
					} 
				},
				{ "data": "tanggal" },
				{
					"data": "id", render(data, type, full, meta)
					{
						return `<div class="pull-right">
									<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
										<i class="fa fa-edit"></i> Ubah
									</button>
									<button class="btn btn-success btn-xs" onclick="Jawaban(${data}, '${full.kategori}')">
										<i class="fa fa fa-check"></i> Detail Jawaban
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


	// $('#kategori').on('change', e =>
	// {
	// 	if($('#kategori').val() == 'Audio')
	// 	{
	// 		$('#file-container').css('display', 'block')
	// 	}
	// 	else
	// 	{
	// 		$('#file-container').css('display', 'none')
	// 	}
	// })


	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let fd = new FormData()
		let id = $('#id').val()
		let kategori = $('#kategori').val()
		let jawaban = $('#jawaban').val()
		let file = $('#file')[0].files[0]
		let gambar = $('#gambar')[0].files[0]
		let keterangan = $('#keterangan').val()
		let status = $('#status').val()

		fd.append('id_soal', id_soal)
		fd.append('kategori', kategori)
        fd.append('jawaban', jawaban)
        fd.append('keterangan', keterangan)
        fd.append('status', status)

        if(file !== undefined)
        {
        	fd.append('file', file)
        }

        if(gambar !== undefined)
        {
        	fd.append('gambar', gambar)
        }

		if (id == 0) {

			// Insert

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>detailSoal/insert',
				data: fd,
				processData: false,
                contentType: false,
                cache: false,
                async: false,
			}).done((data) => {
				$.doneMessage('Berhasil ditambahkan.', 'Soal')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal ditambahkan.', 'Soal')
			}).
			always(() => {
				$('#myModal').modal('toggle')
			})
		} else {

			fd.append('id', id)
			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>detailSoal/update',
					data: fd,
					processData: false,
	                contentType: false,
	                cache: false,
	                async: false,
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'Soal')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Soal')
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
				url: '<?= base_url() ?>detailSoal/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Soal')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Soal')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Soal')
		$('#id').val('')
		$('#kategori').val('')
		$('#keterangan').val('')
		$('#status').val('')
		$('#myModal').modal('toggle')
	})

	// Submit jawaban
	$('#form-jawaban').submit(ev =>
	{
		ev.preventDefault()

		let type = $('#type').val()
		let id_a = $('#id-a').val()
		let id_b = $('#id-b').val()
		let id_c = $('#id-c').val()
		let id_d = $('#id-d').val()
		let id_e = $('#id-e').val()
		let a = $('#jawaban-a').val()
		let b = $('#jawaban-b').val()
		let c = $('#jawaban-c').val()
		let d = $('#jawaban-d').val()
		let e = $('#jawaban-e').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>detailSoal/addSoal',
			data: {
				id_detail: $('#id-detail-soal').val(),
				id_a: id_a,
				id_b: id_b,
				id_c: id_c,
				id_d: id_d,
				id_e: id_e,
				a: a,
				b: b,
				c: c,
				d: d,
				e: e,
				type: type,
				model: model,
			}
		})
		.done((data) => {
			$.doneMessage('Berhasil menambahkan jawaban.', 'Soal')
			$('#myModal-Jawaban').modal('hide')
		})
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
		url: '<?= base_url() ?>detailSoal/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Soal')
		$('#id').val(data.id)
		$('#kategori').val(data.kategori)
		$('#jawaban').val(data.jawaban)
		$('#keterangan').val(data.keterangan)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Soal')
	})
}


// Add jawaban
const Jawaban = (id, kategori) =>
{
	$('#id-detail-soal').val(id)
	
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>detailSoal/cekSoal',
		data: {
			id: id
		},
		success(data)
		{
			model = kategori

			if(data.length > 0)
			{
				$('#type').val('update')

				$('#id-a').val(data[0].id)
				$('#id-b').val(data[1].id)

				if(kategori == 'Pilihan Ganda')
				{
					$('#c-e').css('display', 'block')

					$('#id-c').val(data[2] == undefined ? '' : data[2].id)
					$('#id-d').val(data[3] == undefined ? '' : data[3].id)
					$('#id-e').val(data[4] == undefined ? '' : data[4].id)
					$('#jawaban-c').val(data[2] == undefined ? '' : data[2].keterangan)
					$('#jawaban-d').val(data[3] == undefined ? '' : data[3].keterangan)
					$('#jawaban-e').val(data[4] == undefined ? '' : data[4].keterangan)
				}
				else
				{
					$('#c-e').css('display', 'none')
				}

				$('#jawaban-a').val(data[0].keterangan)
				$('#jawaban-b').val(data[1].keterangan)
			}
			else
			{
				$('#type').val('create')

				if(kategori == 'Pilihan Ganda')
				{
					$('#c-e').css('display', 'block')
				}
				else
				{
					$('#c-e').css('display', 'none')
				}

				$('#id-a').val('')
				$('#id-b').val('')
				$('#id-c').val('')
				$('#id-d').val('')
				$('#id-e').val('')
				$('#jawaban-a').val('')
				$('#jawaban-b').val('')
				$('#jawaban-c').val('')
				$('#jawaban-d').val('')
				$('#jawaban-e').val('')
			}
		}
	})

	$('#myModal-Jawaban').modal('toggle')
}
