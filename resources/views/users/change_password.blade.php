@extends('master.index')
@section('title', App\Helpers\GetLang::locale('user.title'))
@section('content')
    <div class="card mb-4">

        <div class="card-header pb-0">
            <h4>ປ່ຽນລະຫັດຜ່ານ</h4>
        </div>

        <div class="card-body">
            <form method="post" id="formUpdatePassword">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group ">
                            <span class="text-danger">*</span>
                            <b>ລະຫັດຜ່ານປັດຈຸບັນ</b>
                            <div class="input-group mb-3">
                                <input id="current_password" name="current_password" type="password" required
                                    class="form-control" />
                                <span class="input-group-text" style="cursor: pointer">
                                    <span class="fa fa-fw fa-eye field_icon toggle-current-password"></span>
                                </span>
                            </div>
                            <span id="alert_error_current_password_is_not_correct" class="text-danger"
                                style="display: none;">
                                ລະຫັດຜ່ານປັດຈຸບັນບໍ່ຖືກຕ້ອງ, ກະລຸນາລອງໃໝ່ອີກຄັ້ງ!
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group ">
                            <span class="text-danger">*</span>
                            <b>ລະຫັດຜ່ານໃໝ່</b>
                            <div class="input-group mb-3">
                                <input id="new_password" name="new_password" type="password" required
                                    class="form-control" />
                                <span class="input-group-text toggle-new-password" style="cursor: pointer">
                                    <span id="icon-togle-new-password" class="fa fa-fw fa-eye field_icon"></span>
                                </span>
                            </div>
                            <span id="alert_error_check_length_password" class="text-danger" style="display: none;">
                                ລະຫັດຜ່ານຂອງຕ້ອງມີຢ່າງຫນ້ອຍ 8 ໂຕ!
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group ">
                            <span class="text-danger">*</span>
                            <b>ຍືນຍັນລະຫັດຜ່ານໃໝ່</b>
                            <div class="input-group mb-3">
                                <input id="confirm_new_password" name="confirm_new_password" type="password" required
                                    class="form-control" />
                                <span class="input-group-text toggle-new-password" style="cursor: pointer">
                                    <span id="icon-togle-confirm-new-password" class="fa fa-fw fa-eye field_icon"></span>
                                </span>
                            </div>
                            <span id="alert_error_check_password_not_match" class="text-danger" style="display: none;">
                                ລະຫັດຜ່ານບໍ່ຕົງກັນ!
                            </span>
                        </div>
                    </div>
                </div>

                <div style="float: right; display: flex">
                    <div class="row">
                        <div class="col">
                            <span id="alert_success_update_password" class="text-success" style="display: none;">
                                ສໍາເລັດ.
                            </span>

                            <span id="alert_error_update_password" class="text-danger" style="display: none;">
                                ບໍ່ສໍາເລັດ.
                            </span>
                            <button id="button_update_password" type="submit"
                                class="btn btn-primary my-2">ປ່ຽນລະຫັດຜ່ານ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {

            $("#button_update_password").attr("disabled", true)

            $('#confirm_new_password').on('input', function() {
                if (
                    $('#formUpdatePassword input[name="new_password"]').val() === $(
                        '#formUpdatePassword input[name="confirm_new_password"]').val()
                ) {

                    if ($('#formUpdatePassword input[name="new_password"]').val().length >= 8) {
                        $('#alert_error_check_password_not_match').css("display", "none");
                        $("#button_update_password").attr("disabled", false)
                    } else {
                        $('#alert_error_check_password_not_match').css("display", "none");
                        $("#button_update_password").attr("disabled", true)
                    }

                } else {

                    $('#alert_error_check_password_not_match').css("display", "");
                    $("#button_update_password").attr("disabled", true)

                }
            });

            $('#new_password').on('input', function() {
                if (
                    $('#formUpdatePassword input[name="new_password"]').val().length >= 8
                ) {

                    $('#alert_error_check_length_password').css("display", "none");

                } else if (
                    $('#formUpdatePassword input[name="new_password"]').val().length === 0
                ) {

                    $('#alert_error_check_length_password').css("display", "none");

                } else {

                    $('#alert_error_check_length_password').css("display", "");

                }
            });

            $('#formUpdatePassword').on('submit', function(e) {

                e.preventDefault()

                if (
                    $('#formUpdatePassword input[name="current_password"]').val() &&
                    $('#formUpdatePassword input[name="new_password"]').val() &&
                    $('#formUpdatePassword input[name="confirm_new_password"]').val() &&
                    $('#formUpdatePassword input[name="new_password"]').val().length >= 8 &&
                    $('#formUpdatePassword input[name="new_password"]').val() === $(
                        '#formUpdatePassword input[name="confirm_new_password"]').val()
                ) {
                    $("#button_update_password").attr("disabled", true)
                    $('#alert_error_update_password').css("display", "none");
                    $('#alert_success_update_password').css("display", "none");

                    $('#alert_error_current_password_is_not_correct').css("display", "none");
                    $('#alert_error_check_password_not_match').css("display", "none");
                    $('#alert_error_check_length_password').css("display", "none");

                    fetch(
                            `/users/change-password`, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    current_password: $(
                                            '#formUpdatePassword input[name="current_password"]')
                                        .val() || '',
                                    new_password: $(
                                            '#formUpdatePassword input[name="new_password"]')
                                        .val() || '',
                                    confirm_new_password: $(
                                        '#formUpdatePassword input[name="confirm_new_password"]'
                                    ).val() || '',
                                })
                            }
                        )
                        .then(res => res.json())
                        .then(res => {
                            if (res.status == 200 && res.message === "ok") {

                                $('#alert_error_update_password').css("display", "none");
                                $('#alert_success_update_password').css("display", "");
                                $('#alert_error_current_password_is_not_correct').css("display",
                                    "none");
                                $('#alert_error_check_password_not_match').css("display", "none");
                                $('#alert_error_check_length_password').css("display", "none");

                                setTimeout(function() {
                                    window.location.reload();
                                }, 1500);

                            } else if (res.status == 400 && res.message ===
                                "current_password_is_not_correct") {

                                $('#alert_error_update_password').css("display", "none");
                                $('#alert_success_update_password').css("display", "none");
                                $('#alert_error_current_password_is_not_correct').css("display", "");
                                $('#alert_error_check_password_not_match').css("display", "none");
                                $('#alert_error_check_length_password').css("display", "none");
                                $("#button_update_password").attr("disabled", false)

                            } else {

                                $("#button_update_password").attr("disabled", false)
                                $('#alert_error_update_password').css("display", "");
                                $('#alert_success_update_password').css("display", "none");
                                $('#alert_error_current_password_is_not_correct').css("display",
                                    "none");
                                $('#alert_error_check_password_not_match').css("display", "none");
                                $('#alert_error_check_length_password').css("display", "none");

                            }

                        })
                        .catch(err => {
                            $("#button_update_password").attr("disabled", false)
                            $('#alert_error_update_password').css("display", "");
                            $('#alert_success_update_password').css("display", "none");
                            $('#alert_error_current_password_is_not_correct').css("display", "none");
                            $('#alert_error_check_password_not_match').css("display", "none");
                            $('#alert_error_check_length_password').css("display", "none");
                        })

                } else {
                    $("#button_update_password").attr("disabled", false)
                    $('#alert_error_update_password').css("display", "");
                    $('#alert_success_update_password').css("display", "none");
                    $('#alert_error_current_password_is_not_correct').css("display", "none");
                    $('#alert_error_check_password_not_match').css("display", "none");
                    $('#alert_error_check_length_password').css("display", "none");
                }
            })

            $("body").on('click', '.toggle-current-password', function() {

                $(this).toggleClass("fa-eye fa-eye-slash");

                var input = $("#current_password");

                if (input.attr("type") === "password") {

                    input.attr("type", "text");

                } else {

                    input.attr("type", "password");

                }

            });

            $("body").on('click', '.toggle-new-password', function() {

                $('#icon-togle-new-password').toggleClass("fa-eye fa-eye-slash");
                $('#icon-togle-confirm-new-password').toggleClass("fa-eye fa-eye-slash");

                var input = $("#new_password");
                var input_confirm = $("#confirm_new_password");

                if (input.attr("type") === "password") {

                    input.attr("type", "text");
                    input_confirm.attr("type", "text");

                } else {

                    input.attr("type", "password");
                    input_confirm.attr("type", "password");

                }

            });

        })
    </script>
@endsection
