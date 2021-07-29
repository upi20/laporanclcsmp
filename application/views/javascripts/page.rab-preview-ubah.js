let global_kode_standar_1 = '';
let global_kode_standar_2 = '';
let global_kode_standar_3 = '';
let global_kode_standar_4 = '';
let global_kode_standar_5 = '';

$(() => {
	// initialize responsive datatable
	dynamic()
	getKode()

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
			$("#id_aktifitas_sub").html("");
			$("#id_aktifitas_cabang").html("");
			$("#kode_isi_1").html("");
			$("#kode_isi_2").html("");
			$("#kode").val("");
		}).fail(($xhr) => {
			console.log($xhr)
			$("#id_aktifitas_sub").html("");
			$("#id_aktifitas_cabang").html("");
			$("#kode_isi_1").html("");
			$("#kode_isi_2").html("");
			$("#kode").val("");
		})
	}

	// 1
	const aktifitasChange = (id) => {
		global_kode_standar_1 = id;
		if (id != "") {
			let id_aktifitas = id;
			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getAktifitasSub',
				data: {
					id_aktifitas: id_aktifitas
				},
			}).done((data) => {
				let strhtml = ``;
				if (data.length) {
					strhtml += '<option value="">--Pilih Sub Aktifitas--</option>';
					$.each(data, (value, key) => {
						strhtml += "<option value='" + key.id + "'>" + key.kode + " - " + key.uraian + "</option>";
					})
				}

				$('#id_aktifitas_sub').html(strhtml)
				$("#id_aktifitas_cabang").html("");
				$("#kode_isi_1").html("");
				$("#kode_isi_2").html("");
				$("#kode").val("");

			}).fail(($xhr) => {
				console.log($xhr)
			})
		} else {
			$('#id_aktifitas_sub').html('');
			$("#id_aktifitas_cabang").html("");
			$("#kode_isi_1").html("");
			$("#kode_isi_2").html("");
			$("#kode").val("");
		}
	}

	// 2
	const aktifitasSubChange = (id) => {
		global_kode_standar_2 = id;
		if (id != "") {
			let id_aktifitas_sub = id
			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getAktifitasCabang',
				data: {
					id_aktifitas_sub: id_aktifitas_sub,
					id_cabang: global_id_cabang
				},
			}).done((data) => {
				let strhtml = ``;
				if (data.length) {
					strhtml += '<option value="">--Pilih Sub Aktifitas--</option>';
					$.each(data, (value, key) => {
						strhtml += "<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>";
					})
				}
				$('#id_aktifitas_cabang').html(strhtml)
				$("#kode_isi_1").html("");
				$("#kode_isi_2").html("");
			}).fail(($xhr) => {
				console.log($xhr)
			})

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getKodeCabang',
				data: {
					id_aktifitas_sub: id_aktifitas_sub,
					id_cabang: global_id_cabang
				},
			}).done((data) => {
				let detail = data.kode.split('.')
				var tamp = Number(detail[2] ? detail[2] : 0) + 1
				let kode = detail[0] + '.' + detail[1] + '.' + tamp
				$("#kode").val(kode)
			}).fail(($xhr) => {
				console.log($xhr)
			})
		} else {
			$("#id_aktifitas_cabang").html("");
			$("#kode_isi_1").html("");
			$("#kode_isi_2").html("");
			$("#kode").val("");
		}
	}

	// 3
	const aktifitasCabangChange = (id) => {
		global_kode_standar_3 = id;
		if (id != "") {
			let id_aktifitas_cabang = id
			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getAktifitasCabangKodeIsi1',
				data: {
					id_aktifitas_cabang: id_aktifitas_cabang,
					id_cabang: global_id_cabang
				},
			}).done((data) => {
				let strhtml = ``;
				if (data.length) {
					strhtml += '<option value="">--Pilih Sub Aktifitas--</option>';
					$.each(data, (value, key) => {
						strhtml += "<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>";
					})
				}

				$('#kode_isi_1').html(strhtml)

				$.ajax({
					method: 'post',
					url: '<?= base_url() ?>rab/cabang/getKodeCabangKodeIsi1',
					data: {
						id_aktifitas_cabang: id_aktifitas_cabang,
						id_cabang: global_id_cabang
					},
				}).done((data) => {
					let detail = data.kode.split('.')
					var tamp = Number(detail[3] ? detail[3] : 0) + 1
					let kode = detail[0] + '.' + detail[1] + '.' + detail[2] + '.' + tamp
					$("#kode").val(kode)
				}).fail(($xhr) => {
					console.log($xhr)
				})
			}).fail(($xhr) => {
				console.log($xhr)
			})
		} else {
			$("#kode_isi_1").html("");
			$("#kode_isi_2").html("");
			$("#kode").val("");
			aktifitasSubChange(global_kode_standar_2);
		}
	}

	// 4
	const kodeIsi1Change = (id) => {
		global_kode_standar_4 = id;
		if (id != "") {
			let kode_isi_1 = id

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getAktifitasCabangKodeIsi2',
				data: {
					kode_isi_1: kode_isi_1,
					id_cabang: global_id_cabang
				},
			}).done((data) => {
				let strhtml = ``;
				if (data.length) {
					strhtml += '<option value="">--Pilih Sub Aktifitas--</option>';
					$.each(data, (value, key) => {
						strhtml += "<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>";
					})
				}
				$('#kode_isi_2').html(strhtml);

				$.ajax({
					method: 'post',
					url: '<?= base_url() ?>rab/cabang/getKodeCabangKodeIsi2',
					data: {
						kode_isi_1: kode_isi_1,
						id_cabang: global_id_cabang
					},
				}).done((data) => {
					let detail = data.kode.split('.')
					var tamp = Number(detail[4] ? detail[4] : 0) + 1
					let kode = detail[0] + '.' + detail[1] + '.' + detail[2] + '.' + detail[3] + '.' + tamp
					$("#kode").val(kode)
				}).fail(($xhr) => {
					console.log($xhr)
				})

			}).fail(($xhr) => {
				console.log($xhr)
			})
		} else {
			$("#kode_isi_2").html("");
			$("#kode").val("");
			aktifitasCabangChange(global_kode_standar_3);
		}
	}

	// 5
	const kodeIsi2Change = (id) => {
		global_kode_standar_5 = id;
		if (id != "") {
			let kode_isi_2 = id

			$.ajax({
				method: 'post',
				url: '<?= base_url() ?>rab/cabang/getAktifitasCabangKodeIsi3',
				data: {
					kode_isi_2: kode_isi_2,
					id_cabang: global_id_cabang
				},
			}).done((data) => {
				let strhtml = ``;
				if (data.length) {
					strhtml += '<option value="">--Pilih Sub Aktifitas--</option>';
					$.each(data, (value, key) => {
						strhtml += "<option value='" + key.id + "'>" + key.kode + " - " + key.nama + "</option>";
					})
				}
				$('#kode_isi_3').html(strhtml);

				$.ajax({
					method: 'post',
					url: '<?= base_url() ?>rab/cabang/getKodeCabangKodeIsi3',
					data: {
						kode_isi_2: kode_isi_2,
						id_cabang: global_id_cabang
					},
				}).done((data) => {
					console.log(data);
					let detail = data.kode.split('.')
					var tamp = Number(detail[5] ? detail[5] : 0) + 1
					let kode = detail[0] + '.' + detail[1] + '.' + detail[2] + '.' + detail[3] + '.' + detail[4] + '.' + tamp
					$("#kode").val(kode)
				}).fail(($xhr) => {
					console.log($xhr)
				})
			}).fail(($xhr) => {
				console.log($xhr)
			})
		} else {
			$("#kode").val("");
			kodeIsi1Change(global_kode_standar_4);
		}
	}

	// 6
	const kodeIsi3Change = (id) => {

	}

	// kode___ 1
	$('#id_aktifitas').on('change', () => {
		let id_aktifitas = $('#id_aktifitas').val()
		aktifitasChange(id_aktifitas);
	})

	// kode___ 2
	$('#id_aktifitas_sub').on('change', () => {
		let id_aktifitas_sub = $('#id_aktifitas_sub').val()
		aktifitasSubChange(id_aktifitas_sub);
	})

	// kode___ 3
	$('#id_aktifitas_cabang').on('change', () => {
		let id_aktifitas_cabang = $('#id_aktifitas_cabang').val()
		aktifitasCabangChange(id_aktifitas_cabang);
	})

	// kode___ 4
	$('#kode_isi_1').on('change', () => {
		let kode_isi_1 = $('#kode_isi_1').val()
		kodeIsi1Change(kode_isi_1);
	})

	// kode___ 5
	$('#kode_isi_2').on('change', () => {
		let kode_isi_2 = $('#kode_isi_2').val()
		kodeIsi2Change(kode_isi_2);
	})

	// kode___ 6
	$('#kode_isi_3').on('change', () => {

	})

	function dynamic() {
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getTotalHarga',
			data: { id: global_id_cabang },
		}).done((data) => {
			const element = $("#format_ringgit_total");
			element.html(window.apiClient.format.format_ringgit(data.total_harga_ringgit, 6));
			console.log(data);
		}).fail(($xhr) => {
			console.log($xhr)
		})
		$("#dt_basic").dataTable().fnDestroy()
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>rab/preview/ubah_ajax_data/" + npsn,
				"data": {
					nspn: npsn
				},
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			"columns": [
				{ "data": "kodes" },
				{ "data": "nama_aktifitas" },
				{ "data": "jumlah_1" },
				{ "data": "satuan_1" },
				{ "data": "jumlah_2" },
				{ "data": "satuan_2" },
				{ "data": "jumlah_3" },
				{ "data": "satuan_3" },
				{ "data": "jumlah_4" },
				{ "data": "satuan_4" },
				{
					"data": "harga_ringgit", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_ringgit(data, 6) + '<p>';
					}
				},
				{
					"data": "harga_rupiah", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_rupiah(data, 6) + '<p>';
					}
				},
				{
					"data": "total_harga_ringgit", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_rupiah(data, 6) + '<p>';
					}
				},
				{
					"data": "total_harga_rupiah", render(data, type, full, meta) {
						return '<p style="text-align:right">' + window.apiClient.format.format_ringgit(data, 6) + '<p>';
					}
				},
				{ "data": "keterangan" },
				{
					"data": "id", render(data, type, full, meta) {
						if (full.fungsi == 0) {
							return `<div class="pull-right">
										<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
											<i class="fa fa-edit"></i> Ubah
										</button>
										<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
											<i class="fa fa-trash"></i> Hapus
										</button>
									</div>`
						} else {
							return `-`
						}
					}
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
					for (var i = 0; i < data2.length; i++) {
						$("#id_pengkodeans").append('<option value="' + data2[i].id + '">' + data2[i].kode + ' ' + data2[i].uraian + '</option>');
					}
				})
			}
		}).fail(($xhr) => {
			console.log($xhr)
		})
	}

	const refreshTotal = (ubah = '') => {
		const harga_ringgit = parseFloat($("#" + ubah + "val_harga_ringgit").val());
		const harga_rupiah = parseFloat($("#" + ubah + "val_harga_rupiah").val());
		const jumlah_1 = Number($("#" + ubah + "jumlah_1").val())
		const jumlah_2 = Number($("#" + ubah + "jumlah_2").val())
		const jumlah_3 = Number($("#" + ubah + "jumlah_3").val())
		const jumlah_4 = Number($("#" + ubah + "jumlah_4").val())

		const rupiah_total = harga_rupiah * jumlah_1 * jumlah_2 * jumlah_3 * jumlah_4;
		const ringgit_total = harga_ringgit * jumlah_1 * jumlah_2 * jumlah_3 * jumlah_4;

		// view value
		$("#" + ubah + "total_harga_ringgit").val('RM ' + window.apiClient.format.format_ringgit(ringgit_total, 6))
		$("#" + ubah + "total_harga_rupiah").val('Rp ' + window.apiClient.format.format_ringgit(rupiah_total, 6))

		// value send
		$("#" + ubah + "val_total_harga_ringgit").val(ringgit_total)
		$("#" + ubah + "val_total_harga_rupiah").val(rupiah_total)
	}

	$('#harga_ringgit').on('change', function () {
		const value = this.value || 0;
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getkurs',
			data: {
				ringgit: value,
			},
		}).done((data) => {
			let harga_ringgit = value;

			$("#harga_ringgit").val(value)
			$("#harga_rupiah").val(data.rupiah)

			$("#val_harga_ringgit").val(value)
			$("#val_harga_rupiah").val(data.rupiah)

			$("#total_harga_ringgit").val('RM ' + window.apiClient.format.format_ringgit(value, 6))
			$("#total_harga_rupiah").val('Rp ' + window.apiClient.format.format_ringgit(data.rupiah, 6))

			$("#val_total_harga_ringgit").val(harga_ringgit)
			$("#val_total_harga_rupiah").val(data.rupiah)
			refreshTotal();
		}).fail(($xhr) => {
			// console.log($xhr)
		})
	})

	$('#jumlah_1').on('change', function () {
		refreshTotal();
	})

	$('#jumlah_2').on('change', function () {
		refreshTotal();
	})

	$('#jumlah_3').on('change', function () {
		refreshTotal();
	})

	$('#jumlah_4').on('change', function () {
		refreshTotal();
	})


	// ubah
	$('#ubah-jumlah_1').on('change', function () {
		refreshTotal("ubah-");
	})

	$('#ubah-jumlah_2').on('change', function () {
		refreshTotal("ubah-");
	})

	$('#ubah-jumlah_3').on('change', function () {
		refreshTotal("ubah-");
	})

	$('#ubah-jumlah_4').on('change', function () {
		refreshTotal("ubah-");
	})

	$('#ubah-harga_ringgit').on('change', function () {
		const value = this.value || 0;
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getkurs',
			data: {
				ringgit: value,
			},
		}).done((data) => {
			let harga_ringgit = value;

			$("#ubah-harga_ringgit").val(value)
			$("#ubah-harga_rupiah").val(data.rupiah)

			$("#ubah-val_harga_ringgit").val(value)
			$("#ubah-val_harga_rupiah").val(data.rupiah)

			$("#ubah-total_harga_ringgit").val('RM ' + window.apiClient.format.format_ringgit(value, 6))
			$("#ubah-total_harga_rupiah").val('Rp ' + window.apiClient.format.format_ringgit(data.rupiah, 6))

			$("#ubah-val_total_harga_ringgit").val(harga_ringgit)
			$("#ubah-val_total_harga_rupiah").val(data.rupiah)
			refreshTotal();
		}).fail(($xhr) => {
			// console.log($xhr)
		})
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
		let harga_ringgit = $('#val_harga_ringgit').val()
		let harga_rupiah = $('#val_harga_rupiah').val()
		let jumlah_1 = $('#jumlah_1').val()
		let jumlah_2 = $('#jumlah_2').val()
		let jumlah_3 = $('#jumlah_3').val()
		let jumlah_4 = $('#jumlah_4').val()
		let total_harga_ringgit = $('#val_total_harga_ringgit').val()
		let total_harga_rupiah = $('#val_total_harga_rupiah').val()
		let prioritas = $('#prioritas').val()
		let status = $('#status').val()
		let keterangan = $('#keterangan').val()


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
				status: status,
				keterangan: keterangan
			}
		}).done((data) => {
			$.doneMessage('Berhasil ditambahkan.', 'Aktifitas')
			$('#id').val('')
			$('#id_aktifitas').val('')
			$('#kode').val('')
			$('#kode_isi_1').val('')
			$('#kode_isi_2').val('')
			$('#kode_isi_3').val('')
			$('#nama').val('')
			$('#jumlah_1').val(1)
			$('#satuan_1').val('')
			$('#jumlah_2').val(1)
			$('#satuan_2').val('')
			$('#jumlah_3').val(1)
			$('#satuan_3').val('')
			$('#jumlah_4').val(1)
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
		$('#myModalLabel').html('Tambah Data')
		$('#id').val('')
		$('#id_pengkodeans').val('')
		$('#kode').val('')
		$('#uraian').val('')
		$('#status').val('')
		$("#title-cabang").html(`<br> <h4 style="font-weight: bold;" class="modal-title">${global_cabang_nama}</h4>`);
		aktifitas()
		getKode()
		$('#myModal').modal('toggle')
	})

	$("#ubah-form").submit(function (ev) {
		ev.preventDefault();
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/update',
			data: {
				id: $("#ubah-id").val(),
				id_cabang: global_id_cabang,
				kode: $("#ubah-kode").val(),
				nama: $("#ubah-nama").val(),
				jumlah_1: $("#ubah-jumlah_1").val(),
				satuan_1: $("#ubah-satuan_1").val(),
				jumlah_2: $("#ubah-jumlah_2").val(),
				satuan_2: $("#ubah-satuan_2").val(),
				jumlah_3: $("#ubah-jumlah_3").val(),
				satuan_3: $("#ubah-satuan_3").val(),
				jumlah_4: $("#ubah-jumlah_4").val(),
				satuan_4: $("#ubah-satuan_4").val(),
				harga_ringgit: $("#ubah-harga_ringgit").val(),
				harga_rupiah: $("#ubah-harga_rupiah").val(),
				total_harga_ringgit: $("#ubah-val_total_harga_ringgit").val(),
				total_harga_rupiah: $("#ubah-val_total_harga_rupiah").val(),
				prioritas: $("#ubah-prioritas").val(),
				keterangan: $("#ubah-keterangan").val()
			}
		}).done((data) => {
			$.doneMessage('Berhasil diubah.', 'Aktifitas')

			dynamic()

		}).fail(($xhr) => {
			$.failMessage('Gagal diubah.', 'Aktifitas')
		}).always(() => {
			$('#modalUbah').modal('toggle')
		})
	})

	// import submit
	$('#form-import').submit(function (ev) {
		ev.preventDefault();
		const formData = new FormData(this);
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>rab/cabang/importFromExcel',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data.code == 0) {
					$.doneMessage('Berhasil Disimpan. ', 'RAB')

					dynamic();
					$("#file").empty();
				} else {
					$.failMessage('Gagal Disimpan. ' + data.message, 'RAB')
				}
				$("#modal-import").modal('toggle');
			},
			error: function (data) {
				$.failMessage('Gagal Disimpan. ' + data.message, 'RAB')
				$("#modal-import").modal('toggle');
			}
		});
	})

	// import submit
	$('#form-reset').submit(function (ev) {
		ev.preventDefault();
		const formData = new FormData(this);
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>rab/cabang/resetRab',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data) {
					$.doneMessage('Berhasil Direset. ', 'RAB')

					dynamic();
				} else {
					$.failMessage('Gagal Direset. ' + data.message, 'RAB')
				}
				$("#modal-reset").modal('toggle');
			},
			error: function (data) {
				$.failMessage('Gagal Direset. ' + data.message, 'RAB')
				$("#modal-reset").modal('toggle');
			}
		});
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
		url: '<?= base_url() ?>rab/cabang/getDataDetail',
		data: {
			id: id
		}
	}).done((data) => {
		// set ubah
		$("#ubah-kode").val(data.kode);
		$("#ubah-nama").val(data.nama);
		$("#ubah-harga_ringgit").val(data.harga_ringgit);
		$("#ubah-val_harga_ringgit").val(data.harga_ringgit);
		$("#ubah-harga_rupiah").val(data.harga_rupiah);
		$("#ubah-val_harga_rupiah").val(data.harga_rupiah);
		$("#ubah-jumlah_1").val(data.jumlah_1);
		$("#ubah-satuan_1").val(data.satuan_1);
		$("#ubah-jumlah_2").val(data.jumlah_2);
		$("#ubah-satuan_2").val(data.satuan_2);
		$("#ubah-jumlah_3").val(data.jumlah_3);
		$("#ubah-satuan_3").val(data.satuan_3);
		$("#ubah-jumlah_4").val(data.jumlah_4);
		$("#ubah-satuan_4").val(data.satuan_4);
		$("#ubah-val_total_harga_ringgit").val(data.total_harga_ringgit);
		$("#ubah-total_harga_ringgit").val("RM " + window.apiClient.format.format_ringgit(data.total_harga_ringgit, 6));
		$("#ubah-val_total_harga_rupiah").val(data.total_harga_rupiah);
		$("#ubah-total_harga_rupiah").val("RM " + window.apiClient.format.format_ringgit(data.total_harga_rupiah, 6));
		$("#ubah-prioritas").val(data.prioritas);
		$("#ubah-keterangan").val(data.keterangan);
		$("#ubah-id").val(data.id);
		$('#modalUbah').modal('toggle')


	}).fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', 'RAB')
	})
}
