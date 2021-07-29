$(() => {
    // jumlah siswa
    const jumlah_kelas_7 = $("[name=jumlah_kelas_7]");
    const jumlah_kelas_8 = $("[name=jumlah_kelas_8]");
    const jumlah_kelas_9 = $("[name=jumlah_kelas_9]");
    const total_jumlah_siswa = $("[name=total_jumlah_siswa]");
    jumlah_kelas_7.keyup(function () {
        sumSiswa();
    });
    jumlah_kelas_8.keyup(function () {
        sumSiswa();
    });
    jumlah_kelas_9.keyup(function () {
        sumSiswa();
    });
    function sumSiswa() {
        total_jumlah_siswa.val(Number(jumlah_kelas_7.val()) + Number(jumlah_kelas_8.val()) + Number(jumlah_kelas_9.val()));
    }

    // jumlah guru
    const guru_bina = $("[name=jumlah_guru_bina]");
    const guru_pamong = $("[name=jumlah_guru_pamong]");
    const total_jumlah_guru = $("[name=total_jumlah_guru]");
    guru_bina.keyup(function () {
        sumGuru();
    });
    guru_pamong.keyup(function () {
        sumGuru();
    });

    function sumGuru() {
        total_jumlah_guru.val(Number(guru_bina.val()) + Number(guru_pamong.val()));
    }

    // simpan
    $('#form').submit(function (evt) {
        evt.preventDefault();

        var formData = new FormData(this);
        let id = $('#form input[name=id]').val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>dashboard/simpan',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.code == 0) {
                    $.doneMessage('Berhasil Disimpan.', 'Dashboard')
                } else {
                    $.failMessage('Gagal Disimpan. ' + 'Dashboard')
                }
            },
            error: function (data) {
                $.failMessage('Gagal Disimpan.', 'Dashboard')
            }
        });

    });

});