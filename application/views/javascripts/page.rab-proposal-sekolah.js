let global_dynamic;
let global_total_rupiah;
let global_total_ringgit;
$(() => {

	let base_url = '<?php echo base_url();?>'

	// initialize responsive datatable
	dynamic()
	function dynamic() {
		$("#dt_basic").dataTable().fnDestroy()
		$('#dt_basic').DataTable({
			"ajax": {
				"url": "<?= base_url()?>rab/proposal/ajax_data/",
				"data": {
					id: global_id_cabang
				},
				"type": 'POST'
			},
			"scrollX": true,
			"processing": true,
			"serverSide": true,
			"pageLength": 10,
			"paging": true,
			"columns": [
				{ "data": "judul", className: "max-width200" },
				{ "data": "keterangan", className: "max-width200" },
				{
					"data": "total_ringgit", render(data, type, full, meta) {
						return window.apiClient.format.format_ringgit(data, 6);
					}, className: "max-width200",
				},
				{
					"data": "total_rupiah", render(data, type, full, meta) {
						return window.apiClient.format.format_rupiah(data, 6);
					}, className: "max-width200",
				},
				{
					"data": "status", render(data, type, full, meta) {
						return `${(data == 0) ? "Diporses" : (data == 1 ? "Diajukan" : (data == 2 ? "Diterima" : (data == 3 ? "Ditolak" : (data == 4 ? "Dicairkan" : ""))))}`;
					}, className: "nowrap width70",
				},
				{
					"data": "id", render(data, type, full, meta) {
						// cek status
						const btndetail = `
						<button class="btn btn-primary btn-xs" data-id="${data}" data-judul="${full.judul}" data-tanggal_dari="${full.periode_dari}" data-termin="${full.periode_termin}" data-tanggal_sampai="${full.periode_sampai}" data-keterangan="${full.keterangan}" data-ringgit="${full.total_ringgit}" data="${full.id}" data-status="${full.status}" onclick="Ubah(this)">
						<i class="fa fa-edit"></i> Detail
						</button>
						`;

						const btnhapus = `
						<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
						<i class="fa fa-upload"></i> Hapus
						</button>
						`;

						const btnajukan = `
						<button class="btn btn-success btn-xs" onclick="Ajukan(${data})">
						<i class="fa fa-trash"></i> Ajukan
						</button>
						`;

						const btnexcel = `
						<a href="<?= base_url('/rab/proposal/exportexcel?id_cabang=${full.id_cabang}&id_proposal=${full.id}')?>" class="btn btn-success btn-xs">
						<i class="fa fa-file-excel-o"></i> Excel
						</a>
						`;

						let btn = '';

						if (full.status == 0) {
							btn = btndetail + btnajukan + btnhapus + btnexcel;
						} else if (full.status == 1) {
							btn = btndetail + btnexcel;
						} else if (full.status == 2) {
							btn = btndetail + btnexcel;
						} else if (full.status == 3) {
							btn = btndetail + btnhapus + btnexcel;
						} else if (full.status == 4) {
							btn = btndetail + btnexcel;
						}
						return btn;
					}, className: "nowrap max-width170",
				}
			],
			"aoColumnDefs": [
				{ 'bSortable': false, 'aTargets': ["no-sort"] }
			]
		})
	}

	global_dynamic = dynamic;

	// Fungsi simpan
	$('#form').submit((ev) => {
		ev.preventDefault();
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/proposal/insert',
			data: {
				id_cabang: global_id_cabang,
				judul: $('#judul').val(),
				keterangan: $('#keterangan').val(),
				tanggal_dari: $("#tgl-dari").val(),
				tanggal_sampai: $("#tgl-sampai").val(),
				termin: $("#termin").val(),
			}
		}).done((data) => {
			$.doneMessage('Berhasil ditambahkan.', 'proposal')
			$('#judul').val('')
			$('#keterangan').val('')
			dynamic()
		}).fail(($xhr) => {
			$.failMessage('Gagal ditambahkan.', 'proposal')
		}).always(() => {
			$('#myModal').modal('toggle')
		})
	})

	// Clik Tambah
	$('#tambah').on('click', () => {
		// cek apakah sudah ada proposal atau belum
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/proposal/cekTambah',
			data: {
				id: global_id_cabang
			}
		}).done((data) => {
			if (data) {
				// console.log(data);
				if (data.status == 2 && data.proposal == 0) {
					$('#judul').val('')
					$('#keterangan').val('')
					$('#myModalLabel').html('Tambah proposal')
					$('#myModal').modal('toggle')
				} else if (data.proposal > 0) {
					$.warningMessage('Mohon maaf, Proposal sudah ada. Terimakasih', 'Proposal')
				} else {
					$.warningMessage('Mohon maaf, Belum ada RAB yang disetujui. Terimakasih', 'Proposal')
				}
			} else {
				$.failMessage('Gagal mendapatkan data.', 'Proposal')
			}
		}).fail(($xhr) => {
			$.failMessage('Gagal mendapatkan data.', 'Proposal')
		})
	})

	// Fungsi Delete
	$('#OkCheck').click(() => {

		let id = $("#idCheck").val()

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/proposal/delete',
			data: {
				id: id
			}
		}).done((data) => {
			$.doneMessage('Berhasil dihapus.', 'proposal')
			$("#dt_basic").dataTable().fnDestroy()
			dynamic()

		}).fail(($xhr) => {
			$.failMessage('Gagal dihapus.', 'proposal')
		}).
			always(() => {
				$('#ModalCheck').modal('toggle')
			})
	})

	// simpan detail
	$("#btn-ubah").click(function () {
		// validasi judul
		const judul = $("#detail-judul");
		if (judul.val() == "") {
			$.failMessage('Judul Wajib di isi.', ' Proposal')
			judul.focus();
			return;
		}

		// validasi keterangan
		const keterangan = $("#detail-keterangan");
		if (keterangan.val() == "") {
			$.failMessage('Keterangan Wajib di isi.', ' Proposal')
			keterangan.focus();
			return;
		}

		// validasi termin dari
		const tanggal_dari = $("#detail-tgl-dari");
		if (tanggal_dari.val() == "") {
			$.failMessage('Tanggal dari Wajib di isi.', ' Proposal')
			tanggal_dari.focus();
			return;
		}

		// validasi termin sampai
		const tanggal_sampai = $("#detail-tgl-sampai");
		if (tanggal_sampai.val() == "") {
			$.failMessage('Tanggal sampai Wajib di isi.', ' Proposal')
			tanggal_sampai.focus();
			return;
		}

		// validasi termin
		const termin = $("#detail-termin");
		if (termin.val() == "") {
			$.failMessage('Termin Wajib di isi.', ' Proposal')
			termin.focus();
			return;
		}

		// data proposal
		const id_proposal = $("#detail-id");

		// collect data rabs
		const id_rabs = [];
		const ringgit = [];
		const rupiah = [];
		const jumlah_1 = [];
		const jumlah_1_realisasi = [];
		const jumlah_1_sisa = [];
		const rabs_sisa_id_proposal = [];
		const rabs_sisa_id_proposal_rab = [];

		let total_ringgit = 0;
		let total_rupiah = 0;

		$(".check").each(function () {
			if (this.checked) {
				rabs_sisa_id_proposal.push(this.dataset.id_proposal == "" ? 0 : this.dataset.id_proposal);
				rabs_sisa_id_proposal_rab.push(this.dataset.id_proposal_rab == "" ? 0 : this.dataset.id_proposal_rab);
				const id = this.dataset.id;
				const jumlah_1_val = Number(this.dataset.jumlah_1);
				const jumlah_1_realisasi_val = Number($("#input-realisasi-" + id).val());

				const ringgit_rab = parseFloat(this.dataset.ringgit) * jumlah_1_realisasi_val;
				const rupiah_rab = parseFloat(this.dataset.rupiah) * jumlah_1_realisasi_val;

				id_rabs.push(this.dataset.id);

				ringgit.push(ringgit_rab);
				rupiah.push(rupiah_rab);

				total_ringgit += ringgit_rab;
				total_rupiah += rupiah_rab;

				jumlah_1.push(jumlah_1_val);
				jumlah_1_realisasi.push(jumlah_1_realisasi_val);
				jumlah_1_sisa.push(jumlah_1_val - jumlah_1_realisasi_val);
			}
		});

		const rabs = JSON.stringify({
			id_rabs: id_rabs,
			ringgit: ringgit,
			rupiah: rupiah,
			jumlah_1: jumlah_1,
			jumlah_1_realisasi: jumlah_1_realisasi,
			jumlah_1_sisa: jumlah_1_sisa,
			sisa_id_proposal: rabs_sisa_id_proposal,
			sisa_id_proposal_rab: rabs_sisa_id_proposal_rab
		});
		// kirim update

		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/proposal/update',
			data: {
				id_proposal: id_proposal.val(),
				id_cabang: global_id_cabang,
				judul: judul.val(),
				keterangan: keterangan.val(),
				rabs: rabs,
				ringgit: total_ringgit,
				rupiah: total_rupiah,
				tanggal_dari: tanggal_dari.val(),
				tanggal_sampai: tanggal_sampai.val(),
				termin: termin.val(),
			}
		}).done((data) => {
			$.doneMessage('Berhasil diubah.', 'Proposal')
			dynamic();
		}).fail(($xhr) => {
			$.failMessage('Gagal mendapatkan data.', ' Proposal')
		}).always(() => {
			$("#modalDetail").modal("toggle");
		})
	})

	$("#btn-ajukan").click(function () {
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>rab/proposal/ajukan',
			data: {
				id_proposal: $("#ajukan-id").val()
			}
		}).done((data) => {
			$.doneMessage('Proposal berhasil diajukan', 'Proposal')
			global_dynamic();
		}).fail(($xhr) => {
			$.failMessage('Proposal gagal diajukan', 'Proposal')
		}).always(() => {
			$("#modalAjukan").modal("toggle");
		})
	});

})


// Click Hapus
const Hapus = (id) => {
	$("#idCheck").val(id)
	$("#LabelCheck").text('Form Hapus')
	$("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
	$('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (dataset) => {
	let status = dataset.dataset.status;
	// cek status
	$.ajax({
		method: 'post',
		url: '<?= base_url() ?>rab/proposal/getDataDetail',
		data: {
			id_cabang: global_id_cabang,
			id_proposal: dataset.dataset.id,
			status: dataset.dataset.status
		}
	}).done((data) => {
		$("#detail-id").val(dataset.dataset.id);
		$("#detail-judul").val(dataset.dataset.judul);
		$("#detail-keterangan").val(dataset.dataset.keterangan);
		$("#detail-total-saldo").html("RM " + window.apiClient.format.format_ringgit(dataset.dataset.ringgit, 6));
		$("#detail-tgl-dari").val(dataset.dataset.tanggal_dari);
		$("#detail-tgl-sampai").val(dataset.dataset.tanggal_sampai);
		$("#detail-termin").val(dataset.dataset.termin);
		// set component
		window.apiClient.component.hidden("btn-ubah", (status != 0));
		window.apiClient.component.disabled("detail-judul", (status != 0));
		window.apiClient.component.disabled("detail-keterangan", (status != 0));

		let strbody = '';
		let jumlah_total_ringgit = 0;
		data.forEach(e => {
			const jumlah_1_realisasi = (e.jumlah_1_realisasi == 0) ? e.jumlah_1 : e.jumlah_1_realisasi;

			const total_harga_ringgit = (e.jumlah_ringgit) ? e.jumlah_ringgit : e.total_harga_ringgit;
			const total_harga_rupiah = (e.jumlah_rupiah) ? e.jumlah_rupiah : e.total_harga_rupiah;

			const inputan = (e.input == 1) ? `<input type="number" class="form-control input-jumlah-proposal" data-ringgit="${e.harga_ringgit}" data-id="${e.id}" id="input-realisasi-${e.id}" value="${jumlah_1_realisasi}" style="width:70px;" data-max="${e.jumlah_1}">` : e.jumlah_1_realisasi;
			strbody += `
			<tr>
			${status == 0 ? `<td><input type="checkbox" class="check"
			data-id="${e.id}"
			data-ringgit="${e.harga_ringgit}"
			data-rupiah="${e.harga_rupiah}"
			data-total_ringgit="${total_harga_ringgit}"
			data-total_rupiah="${total_harga_rupiah}"
			data-jumlah_1="${e.jumlah_1}"
			data-id_proposal="${e.id_proposal ? e.id_proposal : ''}"
			data-id_proposal_rab="${e.id_proposal_rab ? e.id_proposal_rab : ''}"
			${e.ischeck == 0 ? "" : "checked"}
			id="check-${e.id}"></td>` : ''}
			<td>${e.kode}</td>
			<td>${e.nama}</td>
			<td>${"RM " + window.apiClient.format.format_ringgit(e.harga_ringgit, 6)}</td>
			<td>${"RM " + window.apiClient.format.format_ringgit(e.total_harga_ringgit, 6)}</td>
			<td>${e.jumlah_1}</td>
			<td>${inputan}</td>
			<td>
				<input type="text" class="form-control" disabled id="input-realisasi-total-${e.id}" value="${"RM " + window.apiClient.format.format_ringgit(total_harga_ringgit, 6)}" style="width:100px;" data-max="${e.jumlah_1}">
				<input type="hidden" id="input-realisasi-total-val-${e.id}" value="${total_harga_ringgit}">
			</td>
			</tr>
			`;
			jumlah_total_ringgit += parseFloat(total_harga_ringgit);

		});

		$("#detail-table").html(strbody);
		$("#detail-table-head").html(`
			<tr>
			${status == 0 ? `<th><input type="checkbox" name="semua" id="detail-check-semua" onchange="handleSetAllCheckbox(this)"><label for="detail-check-semua">Semua</label></th>` : ''}
			<th>Kode</th>
			<th>Uraian</th>
			<th>Satuan(RM)</th>
			<th>Total(RM)</th>
			<th>Volume</th>
			<th>Volume Realisasi</th>
			<th>Realisasi Total(RM)</th>
			</tr>
		`);

		cekSaldo();
		if (status != 0) {
			$("#detail-total-saldo").html("RM " + window.apiClient.format.format_ringgit(jumlah_total_ringgit, 6));
		}
		$(".input-jumlah-proposal").on('change', function () {
			let value = Number(this.value);
			const max = this.dataset.max;
			const id = this.dataset.id;

			if (value < 1) {
				this.value = 1;
				value = 1;
			}

			if (value > max) {
				this.value = max;
				value = max;
			}

			const total = value * parseFloat(this.dataset.ringgit);

			$("#input-realisasi-total-" + id).val("RM " + window.apiClient.format.format_ringgit(total, 6));
			$("#input-realisasi-total-val-" + id).val(total);
			cekSaldo();

		});

		$(".check").on('change', function () {
			cekChecked();
		});

		$("#modalDetail").modal("toggle");
	}).fail(($xhr) => {
		$.failMessage('Gagal mendapatkan data.', ' proposal')
	})
}

function handleSetAllCheckbox(data) {
	$(".check").prop("checked", data.checked);
	cekSaldo();
}

function cekChecked() {
	let submitOk = false;
	let checkAll = true;
	$(".check").each(function () {
		if (this.checked) submitOk = true;
		if (!this.checked) checkAll = false;
	});
	$("#detail-check-semua").prop('checked', checkAll);
	cekSaldo();
}

function cekSaldo() {
	let jumlah_total_ringgit = 0;
	let jumlah_total_rupiah = 0;
	$(".check").each(function () {
		if (this.checked) {
			const jumlah_1_realisasi = Number($("#input-realisasi-" + this.dataset.id).val());
			const jumlah_1_ringgit = parseFloat(this.dataset.ringgit);
			const jumlah_1_rupiah = parseFloat(this.dataset.rupiah);
			jumlah_total_ringgit += (jumlah_1_realisasi * jumlah_1_ringgit);
			jumlah_total_rupiah += (jumlah_1_realisasi * jumlah_1_rupiah);

			global_total_ringgit = jumlah_total_ringgit;
			global_total_rupiah = jumlah_total_rupiah;
		}
	});
	$("#detail-total-saldo").html("RM " + window.apiClient.format.format_ringgit(jumlah_total_ringgit, 6));
}

function Ajukan(id) {
	$("#modalAjukan").modal("toggle");
	$("#ajukan-id").val(id);
}

