let global_curren_password_status = false;
let global_new_password_status = false;
$(() => {
    const cekBtn = () => {
        if (global_curren_password_status && global_new_password_status) {
            window.apiClient.component.disabled("btn-submit", false);
        } else {
            window.apiClient.component.disabled("btn-submit");
        }
    }

    $("#current_password").on('change', function () {
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pengaturan/password/cek_password',
            data: {
                current_password: this.value
            },
        }).done((data) => {
            global_curren_password_status = (data);
            if (data) {
                $.doneMessage('Password sebelumnya benar.', ' Ganti Password')
            } else {
                $.failMessage('Password sebelumnya salah.', ' Ganti Password')
            }
            cekBtn();
        }).fail(($xhr) => {
            console.log($xhr)
        })
    })

    $("#password_visibility").on('change', function () {
        let type = "password";
        if (this.checked) {
            type = "text";
        } else {
            type = "password";
        }
        $("#current_password").attr("type", type);
        $("#new_password").attr("type", type);
        $("#new_password_verify").attr("type", type);
    })

    // cek ulangi password
    $("#new_password_verify").on('change', function () {
        if (($("#new_password").val() == this.value) && (this.value != "")) {
            global_new_password_status = true;
            $.doneMessage('Ulangi Password benar.', ' Ganti Password')
        } else {
            global_new_password_status = false;
            $.failMessage('Ulangi Password salah.', ' Ganti Password')
        }
        cekBtn();
    })

    // cek ulangi password
    $("#new_password").on('change', function () {
        global_new_password_status = false;
        $("#new_password_verify").val("");
        cekBtn();
    })

    // submit password
    $("#input_pengaturan").on('submit', function (ev) {
        ev.preventDefault();
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pengaturan/password/update_password',
            data: {
                new_password: $("#new_password").val()
            },
        }).done((data) => {
            if (data) {
                $.doneMessage('Password password berhasil diganti', ' Ganti Password')
            } else {
                $.failMessage('Password password gagal diganti', ' Ganti Password')
            }
            $("#current_password").val("");
            $("#new_password").val("");
            $("#new_password_verify").val("");
            window.apiClient.component.disabled("btn-submit");
        }).fail(($xhr) => {
            console.log($xhr)
        })
    })
})
