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
				"url": "<?= base_url()?>adminSekolah/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "id" },
				{ "data": "kode" },
				{ "data": "nama" },
				{ 
					"data": "kota_kab", render(data, type, full, meta)
					{
						return data == null ? full.kota_text : data
					} 
				},
				{ "data": "user_email" },
				{ "data": "jumlah_siswa" },
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


	function mata_pelajaran(id=null){
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>adminSekolah/getMataPelajaran',
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
		let kode 		= $('#kode').val()
		let nama 		= $('#nama').val()
		let kota_kab 	= $('#kota_kab').val()
		let email 		= $('#email').val()
		let password 	= $('#password').val()
		let status 		= 1

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>adminSekolah/insert',
					data: {
						kode: kode,
						nama: nama,
						kota_kab: kota_kab,
						email: email,
						password: password,
						status: status
					}
				}).done((data) => {
					if(data.codeStatus == 0)
					{
						$.doneMessage('Berhasil ditambahkan.', 'Admin Sekolah')
						$("#dt_basic").dataTable().fnDestroy()
						dynamic()
					}
					else
					{
						$.failMessage('Data sudah ada.', 'Sekolah')
					}
				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Admin Sekolah')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>adminSekolah/update',
					data: {
						id: id,
						id_user: id_user,
						kode: kode,
						nama: nama,
						kota_kab: kota_kab,
						email: email,
						password: password,
						status: status
					}
				}).done((data) => {
					if(data.codeStatus == 0)
					{
						$.doneMessage('Berhasil diubah.', 'Admin Sekolah')
						$("#dt_basic").dataTable().fnDestroy()
						dynamic()
					}
					else
					{
						$.failMessage('Data sudah ada.', 'Sekolah')
					}
				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Admin Sekolah')
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
				url: '<?= base_url() ?>adminSekolah/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Admin Sekolah')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Admin Sekolah')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Admin Sekolah')
		$('#id').val('')
		$('#id_user').val('')
		$('#kode').val('')
		$('#nama').val('')
		$('#kota_kab').val('')
		$('#email').val('')
		// $('#password').val('')
		// $('#status').val(1)
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
		url: '<?= base_url() ?>adminSekolah/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Admin Sekolah')
		$('#id').val(data.id)
		$('#id_user').val(data.id_user)
		$('#kode').val(data.kode)
		$('#nama').val(data.nama)
		$('#kota_kab').val(data.kota_kab)
		$('#email').val(data.email)
		$('#password').val(123456)
		$('#status').val('')

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Admin Sekolah')
	})
}

// Chnage Status
const changeStatus = (id, status) =>
{
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>adminSekolah/changeStatus',
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
