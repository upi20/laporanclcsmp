$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	$('#import-excel').on('click', e =>
	{
		e.preventDefault()

		$('#myModal-import').modal('show')
	})

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>siswa/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "id" },
				{ "data": "nama" },
				{ "data": "user_email" },
				{ "data": "rombel" },
				{ "data": "grup" },
				{
					"data": "status", render(data, type, full, meta)
					{
						if(data > 0){
							return `<button onclick="changeStatus(${full.id}, ${data})" 
											class="btn btn-primary btn-xs">
											Aktif
									</button>`
						}else{
							return `<button onclick="changeStatus(${full.id}, ${data})" 
											class="btn btn-danger btn-xs">
											Tidak Aktif
									</button>`							
						}
					}
				},
				{ "data": "tanggal" },
				{
					"data": "id", render(data, type, full, meta)
					{
						return `<div class="pull-right">
									<button class="btn btn-primary btn-xs" onclick="Ubah(${full.id})">
										<i class="fa fa-edit"></i> Ubah
									</button>
									<button class="btn btn-danger btn-xs" onclick="Hapus(${full.id})">
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


	function mata_pelajaran(id=null){
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>siswa/getMataPelajaran',
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

		let id_user 	= $('#id_user').val()
		let nis 		= $('#nis').val()
		let nama 		= $('#nama').val()
		let email 		= $('#email').val()
		let password 	= $('#password').val()
		let rombel 		= $('#rombel').val()
		let grup 		= $('#grup').val()
		let status 		= $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>siswa/insert',
					data: {
						nis: nis,
						nama: nama,
						email: email,
						rombel: rombel,
						grup: grup,
						password: password,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'Siswa')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Siswa')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>siswa/update',
					data: {
						id: id,
						id_user: id_user,
						nis: nis,
						nama: nama,
						email: email,
						rombel: rombel,
						grup: grup,
						password: password,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'Siswa')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Siswa')
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
				url: '<?= base_url() ?>siswa/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Siswa')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Siswa')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Siswa')
		$('#id').val('')
		$('#id_user').val('')
		$('#nis').val('')
		$('#nama').val('')
		$('#email').val('')
		// $('#password').val('')
		$('#rombel').val('')
		$('#grup').val('')
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
		url: '<?= base_url() ?>siswa/getDataDetail',
		data: {
			id: id,
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Siswa')
		$('#id').val(id)
		$('#nis').val(id)
		$('#id_user').val(data.id_user)
		$('#nama').val(data.nama)
		$('#email').val(data.user_email)
		// $('#password').val('')
		$('#rombel').val(data.rombel)
		$('#grup').val(data.grup)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Siswa')
	})
}

// Chnage Status
const changeStatus = (id, status) =>
{
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>siswa/changeStatus',
		data: {
			id: id,
			status: (!status) ? 1 : 0,
		}
	})
	.then(res =>
	{
		location.reload()
	})
}
