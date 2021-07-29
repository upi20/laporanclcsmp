let id_rab_send = [];

const data_send = new Map();

$(() => {
    // replace total_ringgit
    {
        const element = $("#format_ringgit_total");
        element.text(window.apiClient.format.format_ringgit(element.text(), 6));
    }

    $("#dt_basic").DataTable({
        "pageLength": 1000,
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [0] }
        ],
        "order": [
            [1, 'asc']
        ]
    });
    let base_url = '<?php echo base_url();?>'

    // ubah format
    $(".text-ringgit").each(function (el) {
        const text = $(this);
        text.text(window.apiClient.format.format_ringgit(text.text(), 6));
    })
    $(".text-rupiah").each(function (el) {
        const text = $(this);
        text.text(window.apiClient.format.format_rupiah(text.text(), 6));
    })

    // initialize responsive datatable
    // dynamic(npsn)
    $("#val-npsn").val(npsn)

    function dynamic(npsn = null) {
        $('#dt_basic').DataTable({
            "ajax": {
                "url": "<?= base_url()?>realisasi/ajax_data/",
                "data": {
                    'npsn': npsn
                },
                "type": 'POST'
            },
            "scrollX": true,
            "processing": true,
            "columns": [
                { "data": "kodes" },
                { "data": "nama_aktifitas" },
                {
                    "data": "total_harga_ringgit",
                    render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(full.total_harga_ringgit, 6)
                    }
                },
                {
                    "data": "total_harga_rupiah",
                    render(data, type, full, meta) {
                        return window.apiClient.format.format_rupiah(full.total_harga_rupiah, 6)
                    }
                },
                {
                    "data": "harga_ringgit",
                    render(data, type, full, meta) {
                        return window.apiClient.format.format_ringgit(full.harga_ringgit, 6)
                    }
                },
                {
                    "data": "harga_rupiah",
                    render(data, type, full, meta) {
                        return window.apiClient.format.format_rupiah(full.harga_rupiah, 6)
                    }
                },
                {
                    "data": "sisa_ringgit",
                    render(data, type, full, meta) {
                        let pre = full.sisa_ringgit < 0 ? "-" : "";
                        return pre + window.apiClient.format.format_ringgit(full.sisa_ringgit, 6)
                    }
                },
                {
                    "data": "sisa_rupiah",
                    render(data, type, full, meta) {
                        let pre = full.sisa_rupiah < 0 ? "-" : "";
                        return pre + window.apiClient.format.format_rupiah(full.sisa_rupiah, 6)
                    }
                },
                {
                    "data": "id_realisasi",
                    render(data, type, full, meta) {
                        if (data == null) {
                            return `Belum Direalisasikan`
                        } else {
                            return `Sudah Direalisasikan`
                        }
                    }
                },
                {
                    "data": "id_realisasi",
                    render(data, type, full, meta) {
                        if (data == null) {
                            if (full.total_harga_ringgit > 0) {
                                return `<button style="width: 100%;" class="btn btn-primary btn-xs" onclick="Belanja(${full.id})">
										<i class="fa fa-edit"></i> Belanja
									</button>`
                            } else {
                                return ``
                            }

                        } else {
                            return `<button style="width: 100%;" class="btn btn-success btn-xs" onclick="Detail(${full.id})">
										<i class="fa fa-edit"></i> Detail
									</button>`
                        }
                    }
                }
            ],
            'columnDefs': [{
                'targets': [1, 2],
                /* table column index */
                'orderable': false,
                /* true or false */
            }]
        })
    }

    $('#form').submit(function (evt) {
        evt.preventDefault();

        // membuat data untuk kirim ke kontroler
        $(".check").each(function () {
            if (this.checked) {
                const data = this.dataset;
                const id = data.id_rab;

                // const anggaran_satuan = Number($(`#anggaran-harga-satuan-rm-${id}`).val());
                // const anggaran_volume = Number($(`#anggaran-volume-${id}`).val());
                // const anggaran_rab_rm = Number($(`#anggaran-rab-rm-${id}`).val());
                // const anggaran_rab_rp = Number($(`#anggaran-rab-rp-${id}`).val());

                const realisasi_satuan = Number($(`#realisasi-harga-satuan-rm-${id}`).val());
                const realisasi_volume = Number($(`#realisasi-volume-${id}`).val());
                const realisasi_total_rm = Number($(`#realisasi-total-rm-${id}`).val());
                const realisasi_total_rp = Number($(`#realisasi-total-rp-${id}`).val());

                const selisih_satuan = Number($(`#selisih-satuan-rm-${id}`).val());
                const selisih_volume = Number($(`#selisih-volume-${id}`).val());
                const selisih_total_rm = Number($(`#selisih-rab-rm-${id}`).val());
                const selisih_total_rp = Number($(`#selisih-rab-rp${id}`).val());

                // sisa ringgit Selisih Satuan (RM) * Volume Realisasi
                const sisa_ringgit = selisih_satuan * realisasi_volume;
                // sisa rupiah (sisa ringgit * kurs)
                const sisa_rupiah = sisa_ringgit * kurs;

                data_send.set(id, {
                    // table rabb---
                    // vol realisasi
                    vol_realisasi: realisasi_volume,
                    // vol relisasi sisa
                    vol_realisasi_sisa: selisih_volume,
                    // table realisasis---
                    // real harga
                    // total
                    harga_ringgit: realisasi_total_rm,
                    harga_rupiah: realisasi_total_rp,
                    // satuan
                    real_harga_ringgit: realisasi_satuan,
                    real_harga_rupiah: realisasi_satuan * kurs,

                    // sisa
                    sisa_ringgit: sisa_ringgit,
                    sisa_rupiah: sisa_rupiah,
                    // satuan real

                });


            }
        });

        var formData = new FormData(this);
        let id = $('#form input[name=id]').val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>realisasi/insertUpload',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (gambar) {
                const real_ringgit = $("#belanja-harga-ringgit").val();
                const real_rupiah = $("#belanja-harga-rupiah").val();
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>realisasi/insert',
                    data: {
                        data: JSON.stringify({
                            gambar: gambar.name,
                            nama: $("#belanja-nama-0").val() + $("#belanja-nama-1").val() + $("#belanja-nama-2").val() + $("#belanja-nama-3").val(),
                            tanggal: $("#belanja-tanggal").val(),
                            keterangan: $("#belanja-keterangan").val(),
                            id_cabang: id_cabang,
                            realisasi: Object.fromEntries(data_send),
                            total_ringgit: real_ringgit,
                            total_rupiah: real_rupiah
                        })
                    },
                    success: function (data) {
                        $.doneMessage('Berhasil ditambahkan.', 'Belanja')
                        $('#myModal1').modal('toggle');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function (data) {
                        $.failMessage('Gagal ditambahkan.', 'Belanja')
                        $('#myModal1').modal('toggle');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                });
            },
            error: function (data) {
                $.failMessage('Gagal ditambahkan.', 'Belanja')
                $('#myModal1').modal('toggle');
                location.reload();
            }
        });

    });


    $(".check").on('change', function () {
        setBtnUbah();
    });

    $('#belanja-text-harga-ringgit').on('change', function () {
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>rab/cabang/getkurs',
            data: {
                ringgit: this.value,
            },
        }).done((data) => {
            $("#belanja-harga-ringgit").val(this.value)
            $("#belanja-text-harga-ringgit").val('RM ' + window.apiClient.format.format_ringgit(this.value, 6))
            $("#belanja-harga-rupiah").val(data.rupiah)
            $("#belanja-text-harga-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(data.rupiah, 6))
        }).fail(($xhr) => {
            console.log($xhr)
        })

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

function ubah(data) {
    if ($(data).attr("disabled") == undefined) {
        $("#belanja-text-harga-ringgit").val("");
        let jml_ringgit = 0;
        let jml_rupiah = 0;

        let body_table_html = ``;
        $(".check").each(function () {
            if (this.checked) {
                const datas = this.dataset;
                jml_ringgit += Number(datas.ringgit);
                jml_rupiah += Number(datas.rupiah);

                // mearngkai html untuk body
                body_table_html += `
                                <tr style="font-weight:bold; text-align:center; border-top: 3px solid #000">
                                    <td rowspan='1' colspan='3'>${datas.kode} (${datas.uraian})</td>
                                </tr>
                                <tr>
                                    <td><label for="anggaran-harga-satuan-rm-${datas.id_rab}">Harga Satuan (RM)</label>
                                        <input step="any" readonly type="number" class="form-control" id="anggaran-harga-satuan-rm-${datas.id_rab}"
                                            value="${parseFloat(datas.satuan_ringgit)}" required />
                                    </td>
                                    <td><label for="realisasi-harga-satuan-rm-${datas.id_rab}">Harga Satuan Real (RM)</label>
                                        <input step="any" type="number" class="form-control input-realisasi"
                                        data-id="${datas.id_rab}"
                                        data-tipe="satuan"
                                        id="realisasi-harga-satuan-rm-${datas.id_rab}"
                                            value="${parseFloat(datas.satuan_ringgit)}"
                                            style="border-bottom:2px solid #333"
                                            required />
                                    </td>
                                    <td><label for="selisih-satuan-rm-${datas.id_rab}">Selisih Satuan (RM)</label>
                                        <input step="any" readonly type="number" class="form-control" id="selisih-satuan-rm-${datas.id_rab}"
                                            value="0" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="anggaran-volume-${datas.id_rab}">Volume</label>
                                        <input step="any" type="number" class="form-control" id="anggaran-volume-${datas.id_rab}"
                                            value="${datas.volume}" required  disabled/>
                                    </td>
                                    <td><label for="realisasi-volume-${datas.id_rab}">Volume Realisasi</label>
                                        <input step="0" type="number" class="form-control input-realisasi"
                                        data-id="${datas.id_rab}"
                                        data-tipe="volume"
                                        id="realisasi-volume-${datas.id_rab}"
                                            value="${datas.volume}"
                                            style="border-bottom:2px solid #333"
                                            required />
                                    </td>
                                    <td><label for="selisih-volume-${datas.id_rab}">Volume</label>
                                        <input step="any" readonly type="number" class="form-control" id="selisih-volume-${datas.id_rab}"
                                            value="0" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="anggaran-rab-rm-${datas.id_rab}">Anggaran RAB (RM)</label>
                                        <input step="any" readonly type="number" class="form-control" id="anggaran-rab-rm-${datas.id_rab}"
                                            value="${datas.ringgit}" required />
                                    </td>
                                    <td><label for="realisasi-total-rm-${datas.id_rab}">Total Realisasi (RM)</label>
                                        <input step="any" readonly type="number" class="form-control" id="realisasi-total-rm-${datas.id_rab}"
                                            value="${datas.ringgit}" required />
                                    </td>
                                    <td><label for="selisih-rab-rm-${datas.id_rab}">Selisih Anggaran(RM)</label>
                                        <input step="any" readonly type="number" class="form-control" id="selisih-rab-rm-${datas.id_rab}"
                                            value="0" required />
                                    </td>
                                </tr>
                                <tr style="border-bottom: 3px solid #000">
                                    <td><label for="anggaran-rab-rp-${datas.id_rab}">Anggaran RAB (Rp)</label>
                                        <input step="any" readonly type="number" class="form-control" id="anggaran-rab-rp-${datas.id_rab}"
                                            value="${datas.rupiah}" required />
                                    </td>
                                    <td><label for="realisasi-total-rp-${datas.id_rab}">Total Realisasi (Rp)</label>
                                        <input step="any" readonly type="number" class="form-control" id="realisasi-total-rp-${datas.id_rab}"
                                            value="${datas.rupiah}" required />
                                    </td>
                                    <td><label for="selisih-rab-rp-${datas.id_rab}">Selisih Anggaran(Rp)</label>
                                        <input step="any" readonly type="number" class="form-control" id="selisih-rab-rp-${datas.id_rab}"
                                            value="0" required />
                                    </td>
                                </tr>
                `;
            }
        });

        $("#body-realisasi").html(body_table_html);

        $("#belanja-harga-ringgit").val(jml_ringgit)
        $("#belanja-harga-rupiah").val(jml_rupiah)
        $("#belanja-text-total-ringgit").val('RM ' + window.apiClient.format.format_ringgit(jml_ringgit, 6))
        $("#belanja-text-total-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(jml_rupiah, 6))

        $("#belanja-harga-ringgit").val(jml_ringgit)
        $("#belanja-text-harga-ringgit").val('RM ' + window.apiClient.format.format_ringgit(jml_ringgit, 6))
        $("#belanja-harga-rupiah").val(jml_rupiah)
        $("#belanja-text-harga-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(jml_rupiah, 6))

        $('#myModal1').modal('toggle')
        $(".input-realisasi").change(function () {
            refreshRealisasi(this);
        })
    } else {
        $.failMessage('Belum ada realisasi yang dipilih', 'Dana Sisa');
    }
}

// Click Ubah
const Belanja = (id) => {
    $('#myModalLabel').html('Form Realisasi')
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
        $("#text-nama").val(data.nama_aktifitas)
        $("#text-total-ringgit").val('RM ' + window.apiClient.format.format_ringgit(data.total_harga_ringgit, 6))
        $("#text-total-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(data.total_harga_rupiah, 6))
        $("#kode").val(data.kode)

        $('#myModal').modal('toggle')
    })
        .fail(($data) => {
            $.failMessage('Gagal mendapatkan data.', ' cabang')
        })
}


let base_url = '<?php echo base_url();?>'
const Detail = (id) => {
    $.ajax({
        method: 'post',
        url: '<?= base_url() ?>realisasi/getDetailRealisasi',
        data: {
            id: id
        }
    }).done((data) => {
        let str_html = ``;
        let title = '';
        if (data) {
            data.forEach(e => {
                title = `${e.kode} (${e.title_nama})`;
                str_html += `
                    <tr style="font-weight:bold; text-align:center; border-top: 3px solid #000">
                        <td rowspan="1" colspan="4"><strong>Tanggal:</strong> ${e.tanggal}</td>
                    </tr>
                    <tr>
                        <td rowspan="1" colspan="4"><strong>Uraian:</strong> ${e.nama}</td>
                    </tr>
                    <tr>
                        <td rowspan="1" colspan="4"><strong>Keterangan:</strong> ${e.keterangan}</td>
                    </tr>
                    <tr>
                        <td rowspan="1" colspan="4"><strong>Photo Resit / Nota / Kwitansi:</strong> <a href="${base_url + 'gambar/' + e.gambar}" target="_blank">Download</a></td>
                    </tr>
                    <tr>
                        <td><label>Harga Satuan (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.anggaran_satuan, 6)}">
                        </td>
                        <td><label>Harga Satuan (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.anggaran_satuan, 6)}">
                        </td>
                        <td><label>Harga Satuan Real (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.realisasi_satuan, 6)}">
                        </td>
                        <td><label>Harga Satuan Selisih (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.selisih_satuan, 6)}">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Volume</label>
                            <input class="form-control" readonly type="text" value="${e.anggaran_volume1 != null ? e.anggaran_volume1 : e.anggaran_volume}">
                        </td>
                        <td><label>Volume</label>
                            <input class="form-control" readonly type="text" value="${e.realisasi_volume}">
                        </td>
                        <td><label>Volume Realisasi</label>
                            <input class="form-control" readonly type="text" value="${e.realisasi_volume}">
                        </td>
                        <td><label>Volume Selisih</label>
                            <input class="form-control" readonly type="text" value="${e.selisih_volume1 != null ? e.selisih_volume1 : e.selisih_volume}">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Anggaran RAB (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit((e.anggaran_total_rm1 != null ? e.anggaran_total_rm1 : e.anggaran_total_rm), 6)}">
                        </td>
                        <td><label>Anggaran RAB (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.anggaran_realisasi_rm, 6)}">
                        </td>
                        <td><label>Total Realisasi (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.realisasi_total_rm, 6)}">
                        </td>
                        <td><label>Total Realisasi (RM)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_ringgit(e.selisih_total_rm, 6)}">
                        </td>
                    </tr>
                    <tr style="border-bottom: 3px solid #000">
                        <td><label>Anggaran RAB (Rp)</label>
                            <input class="form-control" readonly type="text" value="${" Rp " + window.apiClient.format.format_rupiah((e.anggaran_total_rp1 != null ? e.anggaran_total_rp1 : e.anggaran_total_rp), 6)}">
                        </td>
                        <td><label>Anggaran RAB (Rp)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_rupiah(e.anggaran_realisasi_rp, 6)}">
                        </td>
                        <td><label>Total Realisasi (Rp)</label>
                            <input class="form-control" readonly type="text" value="${" Rp " + window.apiClient.format.format_rupiah(e.realisasi_total_rp, 6)}">
                        </td>
                        <td><label>Total Selisih (Rp)</label>
                            <input class="form-control" readonly type="text" value="${" RM " + window.apiClient.format.format_rupiah(e.selisih_total_rp, 6)}">
                        </td>
                    </tr>
                `;

            });
        }
        $('#myModalLabelRealisasi').html(`Detail Realisasi | ${title}`);
        $('#detail-realisasi-modal').html(str_html);

        $('#myModalRealisasi').modal('toggle')
    })
        .fail(($data) => {
            $.failMessage('Gagal mendapatkan data.', ' cabang')
        })
}

function refreshRealisasi(data) {
    // menyiapkan variabel
    const id = data.dataset.id;
    const tipe = data.dataset.tipe;

    const anggaran_volume = Number($(`#anggaran-volume-${id}`).val());
    const anggaran_satuan = Number($(`#anggaran-harga-satuan-rm-${id}`).val());

    const realisasi_volume = Number($(`#realisasi-volume-${id}`).val());
    const realisasi_satuan = Number($(`#realisasi-harga-satuan-rm-${id}`).val());

    const anggaran_rm = Number($(`#anggaran-rab-rm-${id}`).val());
    const anggaran_rp = Number($(`#anggaran-rab-rp-${id}`).val());


    let total_rm = 0;
    let val = Number(data.value);
    let max = 0;

    // cek tipe inputan
    if (tipe == "volume") {
        max = anggaran_volume;
        if (val > max) {
            data.value = max;
            val = max;
        }
        if (val < 1) {
            data.value = 1;
            val = 1;
        }
    } else if (tipe == "satuan") {
        max = anggaran_satuan;
        if (val < 0) {
            data.value = 0;
            val = 0;
        }
    }



    // hitung realisasi rm
    if (tipe == "volume") {
        total_rm = realisasi_satuan * data.value;
    } else if (tipe == "satuan") {
        total_rm = realisasi_volume * data.value;
    }

    $(`#realisasi-total-rm-${id}`).val(total_rm)

    // hitung ralisasi rp
    const total_rp = total_rm * kurs;
    $(`#realisasi-total-rp-${id}`).val(total_rp)


    // hitung selisih
    if (tipe == "volume") {
        $(`#selisih-volume-${id}`).val(max - val)
    } else if (tipe == "satuan") {
        $(`#selisih-satuan-rm-${id}`).val(max - val)
    }

    // hitung selisih anggaran rm
    $(`#selisih-rab-rm-${id}`).val(anggaran_rm - total_rm)


    // hitung selisih anggaran rp
    $(`#selisih-rab-rp-${id}`).val(anggaran_rp - total_rp)

    if ($(`#selisih-satuan-rm-${id}`).val() == 0 && $(`#selisih-volume-${id}`).val() == 0) {
        $(`#selisih-rab-rp-${id}`).val(0);
        $(`#selisih-rab-rm-${id}`).val(0);
        $(`#realisasi-total-rp-${id}`).val(anggaran_rp)
        $(`#realisasi-total-rm-${id}`).val(anggaran_rm)
    }

    refreshTotal();
}

function refreshTotal() {
    // get total rab rm dan rp
    let total_rp = 0;
    let total_rm = 0;
    $(".check").each(function () {
        if (this.checked) {
            const data = this.dataset;
            const id = data.id_rab;
            const realisasi_rm = Number($(`#realisasi-total-rm-${id}`).val());
            const realisasi_rp = Number($(`#realisasi-total-rp-${id}`).val());
            total_rm += realisasi_rm;
            total_rp += realisasi_rp;


        }
    })
    $("#belanja-harga-ringgit").val(total_rm)
    $("#belanja-text-harga-ringgit").val('RM ' + window.apiClient.format.format_ringgit(total_rm, 6))
    $("#belanja-harga-rupiah").val(total_rp)
    $("#belanja-text-harga-rupiah").val('Rp ' + window.apiClient.format.format_rupiah(total_rp, 6))
}