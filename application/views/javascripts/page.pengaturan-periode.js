$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()

	function dynamic()
	{
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>pengaturan/periode/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"processing": true,
          	"serverSide": true,
			"columns": [
				{ "data": "tahun_awal" },
				{ "data": "tahun_akhir" },
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
		let tahun_awal = $('#tahun_awal').val()
		let tahun_akhir = $('#tahun_akhir').val()
		let status = $('#status').val()

		if (id == 0) {
			// Insert
			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/periode/insert',
					data: {
						tahun_awal: tahun_awal,
						tahun_akhir: tahun_akhir,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil ditambahkan.', 'Periode')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Periode')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update
			$.ajax({
					method: 'post',
					url: '<?= base_url() ?>pengaturan/periode/update',
					data: {
						id: id,
						tahun_awal: tahun_awal,
						tahun_akhir: tahun_akhir,
						status: status
					}
				}).done((data) => {
					$.doneMessage('Berhasil diubah.', 'Periode')
					$("#dt_basic").dataTable().fnDestroy()
					dynamic()

				})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Periode')
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
				url: '<?= base_url() ?>pengaturan/periode/delete',
				data: {
					id: id
				}
			}).done((data) => {
				$.doneMessage('Berhasil dihapus.', 'Periode')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Periode')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('TAMBAH PERIODE')
		$('#id').val(0)
		$('#tahun_awal').val('')
		$('#tahun_akhir').val('')
		$('#status').val('Aktif')
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
		url: '<?= base_url() ?>pengaturan/periode/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Periode')
		$('#id').val(data.id)
		$('#tahun_awal').val(data.tahun_awal)
		$('#tahun_akhir').val(data.tahun_akhir)
		$('#status').val(data.status)
		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' Periode')
	})
}
