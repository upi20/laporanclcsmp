let id_realisasi_send = [];
let id_rab_send = [];
let ringgit_send = [];
let rupiah_send = [];
let jumlah_ringgit_send = 0;
let jumlah_rupiah_send = 0;
let global_kode_standar_1 = '';
let global_kode_standar_2 = '';
let global_kode_standar_3 = '';
let global_kode_standar_4 = '';
let global_kode_standar_5 = '';
$(() => {
	// replace total_ringgit
	{
		const element = $("#format_ringgit_total");
		element.text(window.apiClient.format.format_ringgit(element.text(), 6));
	}
	$("#keterangan-container").css('display', 'none')

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	$('#dt_basic').DataTable({
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [0] }
		],
		"order": [[1, 'asc']]
	})

	$(".text-ringgit").each(function (el) {
		const text = $(this);
		text.text(window.apiClient.format.format_ringgit(text.text(), 6));
	})
	$(".text-rupiah").each(function (el) {
		const text = $(this);
		text.text(window.apiClient.format.format_rupiah(text.text(), 6));
	})

	// dynamic(npsn)
	$("#val-npsn").val(npsn)
	function dynamic(npsn = null) {
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>realisasi/ajax_data_dana_sisa/",
				"data": {
					'npsn': npsn
				},
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			"columns": [
				{ "data": "kodes" },
				{ "data": "nama_aktifitas" },
				{
					"data": "total_harga_ringgit", render(data, type, full, meta) {
						return window.apiClient.format.format_ringgit(data, 6)
					}
				},
				{
					"data": "total_harga_rupiah", render(data, type, full, meta) {
						return window.apiClient.format.format_rupiah(data, 6)
					}
				},
				{
					"data": "harga_ringgit", render(data, type, full, meta) {
						returnwindow.apiClient.format.format_ringgit(data, 6)
					}
				},
				{
					"data": "harga_rupiah", render(data, type, full, meta) {
						return window.apiClient.format.format_rupiah(data, 6)
					}
				},
				{
					"data": "sisa_ringgit", render(data, type, full, meta) {
						return window.apiClient.format.format_rupiah(data, 6)
					}
				},
				{
					"data": "sisa_rupiah", render(data, type, full, meta) {
						return window.apiClient.format.format_rupiah(data, 6)
					}
				},
				{
					"data": "id_realisasi", render(data, type, full, meta) {
						if (data == null) {
							return `Belum Dibelanjakan`
						} else {
							return `Sudah Dibelanjakan`
						}
					}
				},
				{
					"data": "id_realisasi", render(data, type, full, meta) {
						return `<button style="width: 100%;" class="btn btn-primary btn-xs" onclick="Tambah(${full.id})">
									<i class="fa fa-edit"></i> Tambah
								</button>`
					}
				}
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}

	$('#pilihan-tambahan').on('change', function () {
		switchView();
		var pilihan = this.value
		if (pilihan === 'rab') {
			if ($("#val-kode").val()) {
				setSubmitBtn(true);
			} else {
				setSubmitBtn(false);
			}
		} else {
			setSubmitBtn(true);
		}
	})

	$('#val-kode').on('change', function () {
		// button submit
		!(this.value) || setSubmitBtn(true);
		this.value || setSubmitBtn(false);

		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>realisasi/cek_kode',
			data: {
				kode: this.value,
				id_cabang: id_cabang
			},
			success: function (data) {
				if (data) {
					jumlah_ringgit_send = data.total_harga_ringgit;
					jumlah_rupiah_send = data.total_harga_rupiah;
					$('#id_rab').val(data.id)
					$('#total-ringgit').val(data.total_harga_ringgit);
					$('#jumlah-total-ringgit').val('RM ' + window.apiClient.format.format_ringgit(data.total_harga_ringgit, 6));
					$('#total-rupiah').val(data.total_harga_rupiah);
					$('#jumlah-total-rupiah').val('Rp ' + window.apiClient.format.format_rupiah(data.total_harga_rupiah, 6));
					// jumlahkan
					$('#sisa-total-ringgit').val(Number(data.total_harga_ringgit) + Number($("#sisa-ringgit").val()));
					$('#jumlah-sisa-total-ringgit').val('RM ' + window.apiClient.format.format_ringgit((Number(data.total_harga_ringgit) + Number($("#sisa-ringgit").val())), 6));
					$('#sisa-total-rupiah').val(Number(data.total_harga_rupiah) + Number($("#sisa-rupiah").val()));
					$('#jumlah-sisa-total-rupiah').val('Rp ' + window.apiClient.format.format_rupiah((Number(data.total_harga_rupiah) + Number($("#sisa-rupiah").val())), 6));

				} else {
					jumlah_ringgit_send = 0;
					jumlah_rupiah_send = 0;
					$('#id_rab').val("");
					$('#total-ringgit').val("");
					$('#jumlah-total-ringgit').val("");
					$('#total-rupiah').val("");
					$('#jumlah-total-rupiah').val("");

					$('#sisa-total-ringgit').val("");
					$('#jumlah-sisa-total-ringgit').val("");
					$('#sisa-total-rupiah').val("");
					$('#jumlah-sisa-total-rupiah').val("");
				}
			}
		})
	})

	$('#form').submit(function (evt) {
		evt.preventDefault();
		let validasi = true;

		// variabel non-rab
		const kode = $("#kode");
		const uraian = $("#nama");

		// validasi non-rab
		if ($("#pilihan-tambahan").val() == 'non-rab') {
			if (kode.val() == "") {
				kode.focus();
				validasi = false;
				$.failMessage('Kode wajib di isi.', 'Belanja')
			} else if (uraian.val() == "") {
				validasi = false;
				uraian.focus();
				$.failMessage('Uraian wajib di isi.', 'Belanja')
			}
		}
		if (validasi) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>realisasi/insertSisa',
				data: {
					data: JSON.stringify({
						'id_realisasi': id_realisasi_send,
						'id_rab': id_rab_send,
						'sisa_ringgit': ringgit_send,
						'sisa_rupiah': rupiah_send,
						'ringgit': jumlah_ringgit_send,
						'rupiah': jumlah_rupiah_send,
						'keterangan': $('#keterangan').val(),
						'kategori': $("#pilihan-tambahan").val(),
						'id_cabang': $("#id_cabang").val(),
						'id_rab_to': $('#id_rab').val(),
						"non_rab": {
							"id_aktifitas": $("#id_aktifitas").val() || "",
							"id_aktifitas_sub": $("#id_aktifitas_sub").val() || "",
							"id_aktifitas_cabang": $("#id_aktifitas_cabang").val() || "",
							"kode_isi_1": $("#kode_isi_1").val() || 0,
							"kode_isi_2": $("#kode_isi_2").val() || 0,
							"kode_isi_3": $("#kode_isi_3").val() || 0,
							"kode": $("#kode").val() || "",
							"nama": $("#nama").val() || "",
							"jumlah_1": $("#jumlah_1").val() || "",
							"satuan_1": $("#satuan_1").val() || "",
							"jumlah_2": $("#jumlah_2").val() || "",
							"satuan_2": $("#satuan_2").val() || "",
							"jumlah_3": $("#jumlah_3").val() || "",
							"satuan_3": $("#satuan_3").val() || "",
							"jumlah_4": $("#jumlah_4").val() || "",
							"satuan_4": $("#satuan_4").val() || "",
							"harga_ringgit": $("#val_harga_ringgit").val() || "",
							"harga_rupiah": $("#val_harga_rupiah").val() || "",
							"total_harga_ringgit": $("#val_total_harga_ringgit").val() || "",
							"total_harga_rupiah": $("#val_total_harga_rupiah").val() || "",
							"prioritas": $("#prioritas").val() || "",
							"status": $("#status").val() || "",
							"keterangan": $("#keterangan").val() || "",
						}
					}),
				},
				success: function (data) {
					if (data.result) {

						$.doneMessage('Berhasil ditambahkan.', 'Belanja');
					} else {
						$.failMessage('Gagal ditambahkan.', 'Belanja')
					}
					$('#myModal').modal('toggle');
					location.reload();
				},
				error: function (data) {
					$('#myModal').modal('toggle');
					location.reload();
				}
			});
		}

	});


	$(".check").on('change', function () {
		setBtnUbah();
	});


	// dana sisa non rab
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

	aktifitas();

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
})

function setBtnUbah() {

	let submitOk = false;
	let checkAll = true;
	$(".check").each(function () {
		if (this.checked) submitOk = true;
		if (!this.checked) checkAll = false;

	});
	if (submitOk) {
		$("#btn-ubah").removeAttr("disabled");
	} else {
		$("#btn-ubah").attr("disabled", "");
	}
	$("#check-all").prop('checked', checkAll);
}

function setSubmitBtn(isBtn) {
	const btn = $('#submit-modal');
	// button submit
	!(isBtn) || btn.removeAttr("disabled");
	isBtn || btn.prop("disabled", "true");
}


// Click tambah
const Tambah = (id) => {

	$("#id_rab").val(id)
	$('#myModalLabel').html('Tambahkan Dana Sisa')
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>realisasi/getDetailRab',
		data: {
			id: id
		}
	}).done((data) => {
		$("#npsn").text('NPSN: ' + data.npsn)
		$("#id").val(id)
		$("#id_cabang").val(data.id_cabang)
		$("#text-kode").val(data.kode)

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>realisasi/dataTotalSisa',
			data: {
				id_cabang: data.id_cabang,
				id_rab: data.id,
			}
		}).done((data2) => {
			$("#sisa-ringgit").val(data2.sisa_ringgit)
			$("#jumlah-sisa-ringgit").val('RM ' + window.apiClient.format.format_ringgit(data2.sisa_ringgit, 6))
			$("#sisa-rupiah").val(data2.sisa_rupiah)
			$("#jumlah-sisa-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(data2.sisa_rupiah, 6))
		})

		$('#myModal').modal('toggle')
	}).fail(($data) => {
		$.failMessage('Gagal mendapatkan data.', ' cabang')
	})

	$('#jumlah-sisa-ringgit').on('change', function () {
		$("#sisa-ringgit").val(this.value)
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/cabang/getkurs',
			data: {
				ringgit: this.value,
			},
		}).done((data) => {
			$("#jumlah-sisa-ringgit").val('RM ' + this.value)
			$("#sisa-rupiah").val(data.rupiah)
			$("#jumlah-sisa-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(data.rupiah, 6))
		}).fail(($xhr) => {
			// console.log($xhr)
		})

	})
}

function ubah(data) {
	if ($(data).attr("disabled") == undefined) {
		switchView();
		id_realisasi_send = [];
		id_rab_send = [];
		ringgit_send = [];
		rupiah_send = [];
		let jml_ringgit = 0;
		let jml_rupiah = 0;

		$(".check").each(function () {
			if (this.checked) {
				id_realisasi_send.push(this.value);
				id_rab_send.push(this.dataset.id_rab);
				ringgit_send.push(this.dataset.ringgit);
				rupiah_send.push(this.dataset.rupiah);

				jml_ringgit += Number(this.dataset.ringgit);
				jml_rupiah += Number(this.dataset.rupiah);
			}
		});

		$("#id_rab").val(id.value)
		$("#sisa-ringgit").val(jml_ringgit)
		$("#jumlah-sisa-ringgit").val('RM ' + window.apiClient.format.format_ringgit(jml_ringgit, 6))
		$("#sisa-rupiah").val(jml_rupiah)
		$("#jumlah-sisa-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(jml_rupiah, 6))
		$('#myModalLabel').html('Alihkan Dana Sisa')

		// non rab
		$("#val_harga_ringgit").val(jml_ringgit)
		$("#harga_ringgit").val('RM ' + window.apiClient.format.format_ringgit(jml_ringgit, 6))
		$("#val_harga_rupiah").val(jml_rupiah)
		$("#harga_rupiah").val('RM ' + window.apiClient.format.format_rupiah(jml_rupiah, 6))
		// total non rab
		$("#val_total_harga_ringgit").val(jml_ringgit)
		$("#total_harga_ringgit").val('RM ' + window.apiClient.format.format_ringgit(jml_ringgit, 6))
		$("#val_total_harga_rupiah").val(jml_rupiah)
		$("#total_harga_rupiah").val('RM ' + window.apiClient.format.format_rupiah(jml_rupiah, 6))
		$('#myModal').modal('toggle')
	} else {
		$.failMessage('Belum ada realisasi yang dipilih', 'Dana Sisa');
	}
}

function switchView() {
	const kategori = $("#pilihan-tambahan");
	const rab = $("#form-rab");
	const non_rab = $("#form-non-rab");
	if (kategori.val() == 'rab') {
		non_rab.attr("style", "display:none");
		rab.removeAttr("style");
	} else {
		rab.attr("style", "display:none");
		non_rab.removeAttr("style");
	}
}
