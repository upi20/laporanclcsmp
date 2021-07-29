$(() => {
    function isSubmitting(isSubmit) {
        if (isSubmit) {
            $('#btn-submit').attr("disabled", "");
        } else {
            $('#btn-submit').removeAttr("disabled", "");
        }
    }

    function load(data) {
        const inputan = document.getElementById("input_pengaturan");
        inputan.kepala_sekolah.value = data.kepala_nama;
        inputan.nip_kepala_sekolah.value = data.kepala_nip;
        inputan.pemegang_kas.value = data.kas_nama;
        inputan.nip_pemegang_kas.value = data.kas_nip;
        inputan.kota.value = data.kota;
    }

    window.apiClient.pengaturanLaporan.get()
        .done((data) => {
            load(data);
        });

    $("#input_pengaturan").submit(e => {
        e.preventDefault();
        isSubmitting(true);
        const el = e.target;
        window.apiClient.pengaturanLaporan.set(el.kepala_sekolah.value, el.nip_kepala_sekolah.value, el.pemegang_kas.value, el.nip_pemegang_kas.value, el.kota.value)
            .done((data) => {
                $.doneMessage('Data has been changed', 'Pengatuarn Laporan');
                isSubmitting(false);
            })
            .error(() => {
                $.failMessage('Data has failed to change', 'Pengatuarn Laporan')
                isSubmitting(false);
            });

    })
})
