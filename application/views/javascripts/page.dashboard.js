$(() => {
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
                if (data) {
                    $.doneMessage('Berhasil Disimpan.', 'Dashboard')
                } else {
                    $.failMessage('Gagal Disimpan.', 'Dashboard')
                }
            },
            error: function (data) {
                $.failMessage('Gagal Disimpan.', 'Dashboard')
            }
        });

    });

    $(".text-ringgit").each(function (el) {
        const text = $(this);
        text.text("RM " + window.apiClient.format.format_ringgit(text.text()));
    })
    $(".text-rupiah").each(function (el) {
        const text = $(this);
        text.text("Rp " + window.apiClient.format.format_rupiah(text.text()));
    })

});