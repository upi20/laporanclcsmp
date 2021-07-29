$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()
	// getKode()

	function cabang() {
		// body...
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getCabang',
			data: null,
		}).done((data) => {
			$('#id_cabang').html('<option value="">--Pilih Cabang--</option>')

			$.each(data, (value, key) => {
				$('#id_cabang').append("<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>")
			})

		}).fail(($xhr) => {
			console.log($xhr)
		})
	}

	function aktifitas() {
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getAktifitas',
			data: null,
		}).done((data) => {
			$('#id_aktifitas').html('<option value="">--Pilih Aktifitas--</option>')

			$.each(data, (value, key) => {
				$('#id_aktifitas').append("<option value='" + key.id + "'>" + key.kode + " - " + key.uraian + "</option>")
			})

		}).fail(($xhr) => {
			console.log($xhr)
		})
	}

	$('#id_aktifitas').on('change', () => {
		let id_aktifitas = $('#id_aktifitas').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getAktifitasSub',
			data: {
				id_aktifitas: id_aktifitas
			},
		}).done((data) => {
			$('#id_aktifitas_sub').html('<option value="">--Pilih Sub Aktifitas--</option>')

			$.each(data, (value, key) => {
				$('#id_aktifitas_sub').append("<option value='" + key.id + "'>" + key.kode + " - " + key.uraian + "</option>")
			})

		}).fail(($xhr) => {
			console.log($xhr)
		})
	})

	$('#id_aktifitas_sub').on('change', () => {
		let id_aktifitas_sub = $('#id_aktifitas_sub').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getAktifitasCabang',
			data: {
				id_aktifitas_sub: id_aktifitas_sub
			},
		}).done((data) => {
			$('#id_aktifitas_cabang').html('<option value="">--Pilih Sub Aktifitas--</option>')

			$.each(data, (value, key) => {
				$('#id_aktifitas_cabang').append("<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>")
			})

		}).fail(($xhr) => {
			console.log($xhr)
		})

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getKodeCabang',
			data: {
				id_aktifitas_sub: id_aktifitas_sub
			},
		}).done((data) => {
			let detail = data.kode.split('.')
			var tamp = Number(detail[2]) + 1
			let kode = detail[0] + '.' + detail[1] + '.' + tamp
			$("#kode").val(kode)
		}).fail(($xhr) => {
			console.log($xhr)
		})
	})

	$('#id_aktifitas_cabang').on('change', () => {
		let id_aktifitas_cabang = $('#id_aktifitas_cabang').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getAktifitasCabangKodeIsi1',
			data: {
				id_aktifitas_cabang: id_aktifitas_cabang
			},
		}).done((data) => {
			$('#kode_isi_1').html('<option value="">--Pilih Sub Aktifitas--</option>')

			$.each(data, (value, key) => {
				$('#kode_isi_1').append("<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>")
			})

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getKodeCabangKodeIsi1',
				data: {
					id_aktifitas_cabang: id_aktifitas_cabang
				},
			}).done((data) => {
				let detail = data.kode.split('.')
				var tamp = Number(detail[3]) + 1
				let kode = detail[0] + '.' + detail[1] + '.' + detail[2] + '.' + tamp
				$("#kode").val(kode)
			}).fail(($xhr) => {
				console.log($xhr)
			})
		}).fail(($xhr) => {
			console.log($xhr)
		})
	})

	$('#kode_isi_1').on('change', () => {
		let kode_isi_1 = $('#kode_isi_1').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getAktifitasCabangKodeIsi2',
			data: {
				kode_isi_1: kode_isi_1
			},
		}).done((data) => {
			$('#kode_isi_2').html('<option value="">--Pilih Sub Aktifitas--</option>')

			$.each(data, (value, key) => {
				$('#kode_isi_2').append("<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>")
			})

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getKodeCabangKodeIsi2',
				data: {
					kode_isi_1: kode_isi_1
				},
			}).done((data) => {
				let detail = data.kode.split('.')
				var tamp = Number(detail[4]) + 1
				let kode = detail[0] + '.' + detail[1] + '.' + detail[2] + '.' + detail[3] + '.' + tamp
				$("#kode").val(kode)
			}).fail(($xhr) => {
				console.log($xhr)
			})

		}).fail(($xhr) => {
			console.log($xhr)
		})
	})

	$('#kode_isi_2').on('change', () => {
		let kode_isi_2 = $('#kode_isi_2').val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getAktifitasCabangKodeIsi3',
			data: {
				kode_isi_2: kode_isi_2
			},
		}).done((data) => {
			$('#kode_isi_3').html('<option value="">--Pilih Sub Aktifitas--</option>')

			$.each(data, (value, key) => {
				$('#kode_isi_3').append("<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>")
			})

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getKodeCabangKodeIsi3',
				data: {
					kode_isi_2: kode_isi_2
				},
			}).done((data) => {
				console.log(data)
				let detail = data.kode.split('.')
				var tamp = Number(detail[5]) + 1
				let kode = detail[0] + '.' + detail[1] + '.' + detail[2] + '.' + detail[3] + '.' + detail[4] + '.' + tamp
				$("#kode").val(kode)
			}).fail(($xhr) => {
				console.log($xhr)
			})
		}).fail(($xhr) => {
			console.log($xhr)
		})
	})

	$('#kode_isi_3').on('change', () => {
		alert('s')
	})

	function dynamic() {
		let base_url = "<?php echo base_url();?>"
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>rab/preview/ajax_data/",
				"data": null,
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			"columns": [
				{ "data": "npsn", className: "width70" },
				{ "data": "nama_cabang", className: "nowrap" },
				{
					"data": "total_harga_ringgit", render(data, type, full, meta) {
						return window.apiClient.format.format_ringgit(data, 6)
					}, className: "width130"
				},
				{
					"data": "total_harga_rupiah", render(data, type, full, meta) {
						return window.apiClient.format.format_rupiah(data, 6)
					}, className: "width130"
				},
				{
					"data": "status", render(data, type, full, meta) {
						if (data == 0) {
							return `Proses`
						} else if (data == 1) {
							return `Ajukan`
						} else if (data == 2) {
							return `Terima`
						} else if (data == 3) {
							return `Tolak`
						} else if (data == 4) {
							return `Dicairkan`
						} else {
							return `Proses`
						}
					}, className: "width100"
				},
				{
					"data": "id", render(data, type, full, meta) {
						return `<div class="pull-right">
						<a class="btn btn-primary btn-xs" href="${base_url}rab/preview/detail/${full.npsn}">
							<i class="fa fa-info"></i> Detail
						</a>
					</div><div class="pull-right">
						<a class="btn btn-warning btn-xs" style="margin-right: 10px" href="${base_url}rab/preview/ubah/${full.npsn}">
							<i class="fa fa-edit"></i> Ubah
						</a>
					</div>`
					}, className: "nowrap width130"
				}
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}

	function getKode() {
		// body...
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/aktifitas/getIdPengkodeans',
			data: null,
		}).done((data) => {

			if (data.id == null) {
				$('#id_pengkodeans').html('');
				$('#kode_').val('1');
			} else {
				$('#kode_').val(data.id);
				$("#id_pengkodeans").html('<option value="" disable>Pilih pengkodean</option>');
				$.ajax({
					method: 'post',
					url: '<?= base_url() ?>rab/aktifitas/getDataPengkodeans',
					data: null,
				}).done((data2) => {
					console.log(data2)
					for (var i = 0; i < data2.length; i++) {
						$("#id_pengkodeans").append('<option value="' + data2[i].id + '">' + data2[i].kode + ' ' + data2[i].uraian + '</option>');
					}
				})
			}
		}).fail(($xhr) => {
			console.log($xhr)
		})
	}

	$('#harga_ringgit').on('change', function () {
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getkurs',
			data: {
				ringgit: this.value,
			},
		}).done((data) => {
			$("#harga_rupiah").val(data.rupiah);

		}).fail(($xhr) => {
			// console.log($xhr)
		})
	})

	$('#jumlah_1').on('change', function () {
		var jumlah_1 = $("#jumlah_1").val()
		var jumlah_2 = $("#jumlah_2").val()
		var jumlah_3 = $("#jumlah_3").val()
		var jumlah_4 = $("#jumlah_4").val()
		var total_harga_ringgit = $("#harga_ringgit").val()
		var total_harga_rupiah = $("#harga_rupiah").val()
		var jumlah = parseInt(jumlah_1) + parseInt(jumlah_2) + parseInt(jumlah_3) + parseInt(jumlah_4)

		total_harga_ringgit = total_harga_ringgit * jumlah
		total_harga_rupiah = total_harga_rupiah * jumlah

		$("#total_harga_ringgit").val(total_harga_ringgit);
		$("#total_harga_rupiah").val(total_harga_rupiah);

	})

	$('#jumlah_2').on('change', function () {

		var jumlah_1 = $("#jumlah_1").val()
		var jumlah_2 = $("#jumlah_2").val()
		var jumlah_3 = $("#jumlah_3").val()
		var jumlah_4 = $("#jumlah_4").val()
		var total_harga_ringgit = $("#harga_ringgit").val()
		var total_harga_rupiah = $("#harga_rupiah").val()
		var jumlah = parseInt(jumlah_1) + parseInt(jumlah_2) + parseInt(jumlah_3) + parseInt(jumlah_4)

		total_harga_ringgit = total_harga_ringgit * jumlah
		total_harga_rupiah = total_harga_rupiah * jumlah

		$("#total_harga_ringgit").val(total_harga_ringgit);
		$("#total_harga_rupiah").val(total_harga_rupiah);

	})

	$('#jumlah_3').on('change', function () {

		var jumlah_1 = $("#jumlah_1").val()
		var jumlah_2 = $("#jumlah_2").val()
		var jumlah_3 = $("#jumlah_3").val()
		var jumlah_4 = $("#jumlah_4").val()
		var total_harga_ringgit = $("#harga_ringgit").val()
		var total_harga_rupiah = $("#harga_rupiah").val()
		var jumlah = parseInt(jumlah_1) + parseInt(jumlah_2) + parseInt(jumlah_3) + parseInt(jumlah_4)

		total_harga_ringgit = total_harga_ringgit * jumlah
		total_harga_rupiah = total_harga_rupiah * jumlah

		$("#total_harga_ringgit").val(total_harga_ringgit);
		$("#total_harga_rupiah").val(total_harga_rupiah);

	})

	$('#jumlah_4').on('change', function () {

		var jumlah_1 = $("#jumlah_1").val()
		var jumlah_2 = $("#jumlah_2").val()
		var jumlah_3 = $("#jumlah_3").val()
		var jumlah_4 = $("#jumlah_4").val()
		var total_harga_ringgit = $("#harga_ringgit").val()
		var total_harga_rupiah = $("#harga_rupiah").val()
		var jumlah = parseInt(jumlah_1) + parseInt(jumlah_2) + parseInt(jumlah_3) + parseInt(jumlah_4)

		total_harga_ringgit = total_harga_ringgit * jumlah
		total_harga_rupiah = total_harga_rupiah * jumlah

		$("#total_harga_ringgit").val(total_harga_ringgit);
		$("#total_harga_rupiah").val(total_harga_rupiah);

	})


	// Fungsi simpan
	$('#form').submit((ev) => {
		ev.preventDefault()

		let id = $('#id').val()
		let id_cabang = $('#id_cabang').val()
		let id_aktifitas = $('#id_aktifitas').val()
		let id_aktifitas_sub = $('#id_aktifitas_sub').val()
		let id_aktifitas_cabang = $('#id_aktifitas_cabang').val()
		let kode = $('#kode').val()
		let kode_isi_1 = $('#kode_isi_1').val()
		let kode_isi_2 = $('#kode_isi_2').val()
		let kode_isi_3 = $('#kode_isi_3').val()

		if (kode_isi_1 == null || kode_isi_1 == '') {
			kode_isi_1 = '0'
		}

		if (kode_isi_2 == null || kode_isi_2 == '') {
			kode_isi_2 = '0'
		}

		if (kode_isi_3 == null || kode_isi_3 == '') {
			kode_isi_3 = '0'
		}

		let nama = $('#nama').val()
		let satuan_1 = $('#satuan_1').val()
		let satuan_2 = $('#satuan_2').val()
		let satuan_3 = $('#satuan_3').val()
		let satuan_4 = $('#satuan_4').val()
		let harga_ringgit = $('#harga_ringgit').val()
		let harga_rupiah = $('#harga_rupiah').val()
		let jumlah_1 = $('#jumlah_1').val()
		let jumlah_2 = $('#jumlah_2').val()
		let jumlah_3 = $('#jumlah_3').val()
		let jumlah_4 = $('#jumlah_4').val()
		let total_harga_ringgit = $('#total_harga_ringgit').val()
		let total_harga_rupiah = $('#total_harga_rupiah').val()
		let prioritas = $('#prioritas').val()
		let status = $('#status').val()

		if (id == 0) {

			// Insert
			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/insert',
				data: {
					id_cabang: id_cabang,
					id_aktifitas: id_aktifitas,
					id_aktifitas_sub: id_aktifitas_sub,
					id_aktifitas_cabang: id_aktifitas_cabang,
					kode: kode,
					kode_isi_1: kode_isi_1,
					kode_isi_2: kode_isi_2,
					kode_isi_3: kode_isi_3,
					nama: nama,
					jumlah_1: jumlah_1,
					satuan_1: satuan_1,
					jumlah_2: jumlah_2,
					satuan_2: satuan_2,
					jumlah_3: jumlah_3,
					satuan_3: satuan_3,
					jumlah_4: jumlah_4,
					satuan_4: satuan_4,
					harga_ringgit: harga_ringgit,
					harga_rupiah: harga_rupiah,
					total_harga_ringgit: total_harga_ringgit,
					total_harga_rupiah: total_harga_rupiah,
					prioritas: prioritas,
					status: status
				}
			}).done((data) => {
				$.doneMessage('Berhasil ditambahkan.', 'Aktifitas')
				$('#id').val('')
				$('#id_cabang').val('')
				$('#id_aktifitas').val('')
				$('#kode').val('')
				$('#kode_isi_1').val('')
				$('#kode_isi_2').val('')
				$('#kode_isi_3').val('')
				$('#nama').val('')
				$('#jumlah_1').val('')
				$('#satuan_1').val('')
				$('#jumlah_2').val('')
				$('#satuan_2').val('')
				$('#jumlah_3').val('')
				$('#satuan_3').val('')
				$('#jumlah_4').val('')
				$('#satuan_4').val('')
				$('#harga_ringgit').val('')
				$('#harga_rupiah').val('')
				$('#total_harga_ringgit').val('')
				$('#total_harga_rupiah').val('')
				$('#prioritas').val('')
				$('#status').val('')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()
			})
				.fail(($xhr) => {
					$.failMessage('Gagal ditambahkan.', 'Aktifitas')
				}).
				always(() => {
					$('#myModal').modal('toggle')
				})
		} else {

			// Update

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/update',
				data: {
					id: id,
					id_cabang: id_cabang,
					id_aktifitas: id_aktifitas,
					kode: kode,
					kode_isi_1: kode_isi_1,
					kode_isi_2: kode_isi_2,
					kode_isi_3: kode_isi_3,
					nama: nama,
					jumlah_1: jumlah_1,
					satuan_1: satuan_1,
					jumlah_2: jumlah_2,
					satuan_2: satuan_2,
					jumlah_3: jumlah_3,
					satuan_3: satuan_3,
					jumlah_4: jumlah_4,
					satuan_4: satuan_4,
					harga_ringgit: harga_ringgit,
					harga_rupiah: harga_rupiah,
					total_harga_ringgit: total_harga_ringgit,
					total_harga_rupiah: total_harga_rupiah,
					prioritas: prioritas,
					status: status
				}
			}).done((data) => {
				$.doneMessage('Berhasil diubah.', 'Aktifitas')
				$('#id').val('')
				$('#id_cabang').val('')
				$('#id_aktifitas').val('')
				$('#kode').val('')
				$('#kode_isi_1').val('')
				$('#kode_isi_2').val('')
				$('#kode_isi_3').val('')
				$('#nama').val('')
				$('#satuan').val('')
				$('#harga_ringgit').val('')
				$('#harga_rupiah').val('')
				$('#jumlah').val('')
				$('#total_harga_ringgit').val('')
				$('#total_harga_rupiah').val('')
				$('#prioritas').val('')
				$('#status').val('')
				$("#dt_basic").dataTable().fnDestroy()
				dynamic()

			})
				.fail(($xhr) => {
					$.failMessage('Gagal diubah.', 'Aktifitas')
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
			url: '<?= base_url() ?>rab/cabang/delete',
			data: {
				id: id
			}
		}).done((data) => {
			$.doneMessage('Berhasil dihapus.', 'Aktifitas')
			$("#dt_basic").dataTable().fnDestroy()
			dynamic()

		})
			.fail(($xhr) => {
				$.failMessage('Gagal dihapus.', 'Aktifitas')
			}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		$('#myModalLabel').html('Tambah Aktifitas')
		$('#id').val('')
		$('#id_pengkodeans').val('')
		$('#kode').val('')
		$('#uraian').val('')
		$('#status').val('')
		cabang()
		aktifitas()
		getKode()
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
		url: '<?= base_url() ?>rab/aktifitas/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		$('#myModalLabel').html('Ubah Aktifitas')
		console.log(data)
		$('#id').val(data.id)
		$('#id_pengkodeans').val(data.id_pengkodeans)
		$('#kode').val(data.kode)
		$('#uraian').val(data.uraian)
		$('#status').val(data.status)
		$('#myModal').modal('toggle')
	})
		.fail(($xhr) => {
			$.failMessage('Gagal mendapatkan data.', ' Aktifitas')
		})
}
