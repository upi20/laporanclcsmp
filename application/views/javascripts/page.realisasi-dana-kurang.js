let id_realisasi_send = [];
let id_rab_from = [];
let ringgit_send = [];
let rupiah_send = [];
let jumlah_ringgit_send = 0;
let jumlah_rupiah_send = 0;

$(() => {
	$(".text-ringgit").each(function (el) {
		const text = $(this);
		text.text(window.apiClient.format.format_ringgit(text.text(), 6));
	})
	$(".text-rupiah").each(function (el) {
		const text = $(this);
		text.text(window.apiClient.format.format_rupiah(text.text(), 6));
	})

	// replace total_ringgit
	{
		const element = $("#format_ringgit_total");
		element.text(window.apiClient.format.format_ringgit(element.text(), 6));
	}
	$("#dt_basic").DataTable({
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [0] }
		],
		"order": [[1, 'asc']]
	});
	$("#keterangan").css('display', 'none')



	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	$("#val-npsn").val(npsn)

	$('#pilihan-tambahan').on('change', function () {
		var pilihan = this.value

		if (pilihan === 'rab') {
			$('#kode-label').css('display', "block");
			$('#kode').css('display', "block");
			$('#total-ringgit').css('display', "block");
			$('#jumlah-total-ringgit').css('display', "block");
			$('#text-total-ringgit').css('display', "block");
			$('#jumlah-total-rupiah').css('display', "block");
			$('#total-rupiah').css('display', "block");
			$('#text2-total-rupiah').css('display', "block");
			$('#keterangan').css('display', "none");
		} else {
			$('#kode-label').css('display', "none");
			$('#kode').css('display', "none");
			$('#jumlah-total-ringgit').css('display', "none");
			$('#total-ringgit').css('display', "none");
			$('#text-total-ringgit').css('display', "none");
			$('#jumlah-total-rupiah').css('display', "none");
			$('#total-rupiah').css('display', "none");
			$('#text2-total-rupiah').css('display', "none");
			$('#keterangan').css('display', "block");
		}
	})

	$('#kode').on('change', function () {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>realisasi/cek_kode',
			data: {
				kode: this.value,
				id_cabang: 7
			},
			success: function (data) {
				$('#id_rab').val(data.id)
				$('#total-ringgit').val(data.total_harga_ringgit);
				$('#jumlah-total-ringgit').val('RM ' + window.apiClient.format.format_ringgit(data.total_harga_ringgit, 6));
				$('#total-rupiah').val(data.total_harga_rupiah);
				$('#jumlah-total-rupiah').val('Rp ' + window.apiClient.format.format_rupiah(data.total_harga_ringgit, 6));
			}
		})
	})

	$('#form').submit(function (evt) {
		evt.preventDefault();
		let id = $('#form input[name=id]').val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>realisasi/insertKurang',
			data: {
				data: JSON.stringify({
					'id_realisasi': id_realisasi_send,
					'id_rab': id_rab_from,
					'sisa_ringgit': ringgit_send,
					'sisa_rupiah': rupiah_send,
					'ringgit': jumlah_ringgit_send,
					'rupiah': jumlah_rupiah_send,
					'keterangan': $('#keterangan').val(),
					'kategori': $("#pilihan-tambahan").val(),
					'id_cabang': $("#id_cabang").val(),
					'id_rab_to': $('#id_rab').val()
				}),
				non_rab: {

				}
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
				$.failMessage('Gagal ditambahkan.', 'Belanja')
				location.reload();
			}
		});

	});
	$('#val-kode').on('change', function () {
		const btn = $('#submit-modal');
		// button submit
		!(this.value) || btn.removeAttr("disabled");
		this.value || btn.prop("disabled", "true");
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
					$('#jumlah-sisa-total-ringgit').val('RM ' + window.apiClient.format.format_ringgit(Number(data.total_harga_ringgit) + Number($("#sisa-ringgit").val()), 6));
					$('#sisa-total-rupiah').val(Number(data.total_harga_rupiah) + Number($("#sisa-rupiah").val()));
					$('#jumlah-sisa-total-rupiah').val('Rp ' + window.apiClient.format.format_rupiah(Number(data.total_harga_rupiah) + Number($("#sisa-rupiah").val()), 6));

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
	$(".check").on('change', function () {
		setBtnUbah();
	});
})


// Click tambah
const Tambah = (id) => {
	$('#myModalLabel').html('Tambahkan Dana Sisa')
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>realisasi/getDetailRab',
		data: {
			id: id
		}
	}).done((data) => {
		// $("#npsn").text('NPSN: ' + data.npsn)
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
	})
		.fail(($data) => {
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
			$("#jumlah-sisa-ringgit").val(this.value)
			$("#sisa-rupiah").val(data.rupiah)
			$("#jumlah-sisa-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(data.rupiah, 6))
		}).fail(($xhr) => {
			// console.log($xhr)
		})

	})
}

function ubah(data) {
	if ($(data).attr("disabled") == undefined) {
		id_realisasi_send = [];
		id_rab_from = [];
		ringgit_send = [];
		rupiah_send = [];
		let jml_ringgit = 0;
		let jml_rupiah = 0;

		$(".check").each(function () {
			if (this.checked) {
				id_realisasi_send.push(this.value);
				id_rab_from.push(this.dataset.id);
				ringgit_send.push(this.dataset.ringgit);
				rupiah_send.push(this.dataset.rupiah);

				jml_ringgit += Number(this.dataset.ringgit);
				jml_rupiah += Number(this.dataset.rupiah);
			}
		});

		$("#id_rab").val(data.dataset.id)
		$("#sisa-ringgit").val(jml_ringgit)
		$("#jumlah-sisa-ringgit").val('RM ' + window.apiClient.format.format_ringgit(jml_ringgit, 6))
		$("#sisa-rupiah").val(jml_rupiah)
		$("#jumlah-sisa-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(jml_rupiah, 6))
		$('#myModalLabel').html('Subsidi Dana Kurang')
		$('#myModal').modal('toggle')
	} else {
		$.failMessage('Belum ada realisasi yang dipilih', 'Dana Kurang');
	}

}

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