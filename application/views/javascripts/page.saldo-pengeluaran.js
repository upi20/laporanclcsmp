$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	getCabang()

	function dynamic(id_cabang=null)
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>saldo/pengeluaran/ajax_data/",
				"data": {
					id_cabang: id_cabang
				},
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "cabang_nama" },
				{ "data": "rab_nama" },
				{ "data": "nama" },
				{ "data": "total_ringgit" },
				{ "data": "total_rupiah" },
				{ "data": "keterangan" },
				{
					"data": "bukti_1", render(data, type, full, meta)
					{
						return `<div class="pull-right">
									<a href="<?php echo base_url()?>uploads/gambar/pengeluaran/${data}" target="_BLANK" class="btn btn-primary btn-xs">
										${data}
									</a>
								</div>`
					}
				},
				{
					"data": "bukti_2", render(data, type, full, meta)
					{
						return `<div class="pull-right">
									<a href="<?php echo base_url()?>uploads/gambar/pengeluaran/${data}" target="_BLANK" class="btn btn-primary btn-xs">
										${data}
									</a>
								</div>`
					}
				},
				{ "data": "status" },
				
			],
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
			]
		})
	}


	// Fungsi simpan 
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id 				= $('#id').val()
		let id_user 		= $('#id_user').val()
		let id_cabang		= $('#id_cabang').val()
		let id_rab 			= $('#id_rab').val()
		let keterangan		= $('#keterangan').val()
		let total_ringgit	= $('#total_ringgit').val()
		let total_rupiah 	= $('#total_rupiah').val()
		let status 			= $('#status').val()

		if (id == 0) {

			// Insert

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>saldo/pemasukan/insert',
					data: {
						id_user: id_user,
						id_cabang: id_cabang,
						id_rab: id_rab,
						keterangan: keterangan,
						total_ringgit: total_ringgit,
						total_rupiah: total_rupiah,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'pemasukan')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'pemasukan')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>saldo/pemasukan/update',
					data: {
						id: id,
						id_user: id_user,
						id_cabang: id_cabang,
						id_rab: id_rab,
						keterangan: keterangan,
						total_ringgit: total_ringgit,
						total_rupiah: total_rupiah,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'pemasukan')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'pemasukan')
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
				url: '<?= base_url() ?>saldo/pemasukan/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'pemasukan')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'pemasukan')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah pemasukan')
		$('#id').val('')
		$('#id_user').val('')
		$('#id_cabang').val('')
		$('#id_rab').val('')
		$('#keterangan').val('')
		$('#total_ringgit').val('')
		$('#total_rupiah').val('')
		$('#status').val(1)
		$('#myModal').modal('toggle')
	})

	// Clik Search
	$('#search').on('click', () => {
		let id_cabang = $("#id_cabang").val()
		$("#dt_basic").dataTable().fnDestroy()
		dynamic(id_cabang)
	})

	//click search
	function getCabang(id=null){
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>saldo/pemasukan/getCabang',
			data: {
				id: id,
			}
		}).done((data) =>
		{
			$('#id_cabang').html('<option value="">--Pilih Cabang--</option>')

			$.each(data, (value, key) =>
			{
				$('#id_cabang').append("<option value='"+key.id+"'>"+key.nama+"</option>")
			})
		})
	}

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
		url: '<?= base_url() ?>saldo/pemasukan/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah pemasukan')
		$('#id').val(data.id)
		$('#id_user').val(data.id_user)
		$('#id_cabang').val(data.id_cabang)
		$('#id_rab').val(data.id_rab)
		$('#keterangan').val(data.keterangan)
		$('#total_ringgit').val(data.total_ringgit)
		$('#total_rupiah').val(data.total_rupiah)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' pemasukan')
	})
}
