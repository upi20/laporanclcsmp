$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>soal/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "id" },
				{ "data": "jenis_soal" },
				{ "data": "nama" },
				{ "data": "token" },
				// { "data": "model" },
				{ "data": "pengaturan" },
				{ "data": "jumlah" },
				{
					"data": "status", render(data, type, full, meta)
					{
						if(data == 1){
							return `Aktif`;
						}else{
							return `Tidak Aktif`;							
						}
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
									<a class="btn btn-success btn-xs" href="<?=base_url()?>detailSoal/index/${data}"><i class="fa fa-check"></i> Detail Soal</a>
									<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
										<i class="fa fa-trash"></i> Hapus
									</button>
									<a class="btn btn-warning btn-xs" href="<?= base_url() ?>soal/preview/${data}" target="_blank">
										<i class="fa fa-eye"></i> Preview
									</a>
								</div>`
					}
				}
			],
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
			]
		})
	}


	function mata_pelajaran(id=null){
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>soal/getMataPelajaran',
			data: {
				id: id,
			}
		}).done((data) =>
		{
			$('#id_mata_pelajaran').html('<option value="">--Pilih Mata Pelajaran--</option>')

			$.each(data, (value, key) =>
			{
				$('#id_mata_pelajaran').append("<option value='"+key.id+"'>"+key.nama+"</option>")
			})
		})
	}


	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let jenis_soal = $('#jenis_soal').val()
		let id_mata_pelajaran = $('#id_mata_pelajaran').val()
		let model = 'haha'
		let pengaturan = $('#pengaturan').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>soal/insert',
					data: {
						jenis_soal: jenis_soal,
						id_mata_pelajaran: id_mata_pelajaran,
						model: model,
						pengaturan: pengaturan,
						status: status
					}
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

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>soal/update',
					data: {
						id: id,
						jenis_soal: jenis_soal,
						id_mata_pelajaran: id_mata_pelajaran,
						model: model,
						pengaturan: pengaturan,
						status: status
					}
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
				url: '<?= base_url() ?>soal/delete',
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
		$('#id_mata_pelajaran').val('')
		$('#jenis_soal').val('')
		// $('#model').val('')
		$('#pengaturan').val('')
		$('#status').val(1)
		mata_pelajaran()
		$('#myModal').modal('toggle')
	})

})

function mata_pelajaran(id=null){
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>soal/getMataPelajaran',
		data: {
			id: null,
		}
	}).done((data) =>
	{
		$('#id_mata_pelajaran').html('<option value="">--Pilih Mata Pelajaran--</option>')

		$.each(data, (value, key) =>
		{
			if(key.id == id){
				$('#id_mata_pelajaran').append("<option  selected value='"+key.id+"'>"+key.nama+"</option>")	
			}else{
				$('#id_mata_pelajaran').append("<option value='"+key.id+"'>"+key.nama+"</option>")
			}
			
		})
	})
}

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
		url: '<?= base_url() ?>soal/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		console.log(data.model)
		$('#myModalLabel').html('Ubah Soal')
		$('#id').val(data.id)
		$('#jenis_soal').val(data.jenis_soal)
		mata_pelajaran(data.id_mata_pelajaran)
		// $('#id_mata_pelajaran').val(data.id_mata_pelajaran)
		// $('#model').val(data.model)
		$('#pengaturan').val(data.pengaturan)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Soal')
	})
}

