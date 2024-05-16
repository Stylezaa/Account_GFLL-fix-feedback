@if (session()->has('status'))
    <script type="text/javascript">
        swal({
            title: "<?php echo session()->get('status'); ?>",
            text: "ຜົນໄດ້ຮັບ",
            //                timer: 2000,
            type: 'success',
            confirmButtonColor: "#00a65a",
            confirmButtonText: "ຕົກລົງ",
            closeOnConfirm: false,
            showConfirmButton: true
        });
    </script>
@elseif(session()->has('statusW'))
    <script type="text/javascript">
        swal({
            title: "<?php echo session()->get('statusW'); ?>",
            text: "ຜົນໄດ້ຮັບ",
            //                timer: 2000,
            type: 'warning',
            confirmButtonColor: "#00a65a",
            confirmButtonText: "ຕົກລົງ",
            closeOnConfirm: false,
            showConfirmButton: true
        });
    </script>
@elseif(session()->has('statusD'))
    <script type="text/javascript">
        swal({
            title: "<?php echo session()->get('statusD'); ?>",
            text: "ຜົນໄດ້ຮັບ",
            //                timer: 2000,
            type: 'error',
            confirmButtonColor: "#00a65a",
            confirmButtonText: "ຕົກລົງ",
            closeOnConfirm: false,
            showConfirmButton: true
        });
    </script>
@elseif(session()->has('statusS'))
    <script type="text/javascript">
        swal({
            title: "<?php echo session()->get('statusS'); ?>",
            text: "ຜົນໄດ້ຮັບ",
            timer: 1000,
            type: 'success',
            confirmButtonColor: "#00a65a",
            confirmButtonText: "ຕົກລົງ",
            closeOnConfirm: false,
            showConfirmButton: true
        });
    </script>
@elseif(session()->has('statusI'))
    <script type="text/javascript">
        swal({
            title: "<?php echo session()->get('statusI'); ?>",
            text: "ຜົນໄດ້ຮັບ",
            //            timer: 1500,
            type: 'info',
            confirmButtonColor: "#00a65a",
            confirmButtonText: "ຕົກລົງ",
            closeOnConfirm: false,
            showConfirmButton: true
        });
    </script>
@endif

{{-- Alert Before Delete DATA --}}
<script type="text/javascript">
    $('button.delete-btn').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        swal({
                title: "ເຈົ້າຕ້ອງການລົບຂໍ້ມູນນີ້ແທ້ບໍ່ ?",
                text: "ຜົນໄດ້ຮັບ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00a65a", //DD6B55
                confirmButtonText: "ລົບຂໍ້ມູນ",
                cancelButtonText: "ຍົກເລີກ",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: "ກຳລັງລົບຂໍ້ມູນ...!\n(ກວດສອບຂໍ້ມູນກ່ອນລົບ)",
                        text: "ຜົນໄດ້ຮັບ",
                        type: 'info',
                        confirmButtonColor: "#00a65a",
                        confirmButtonText: "ຕົກລົງ",
                        closeOnConfirm: false,
                        showConfirmButton: true
                    });
                    setTimeout(function() {
                        self.parents(".delete_form").submit();
                    }, 1000); //2 second delay (2000 milliseconds = 2 seconds)
                } else {
                    // swal("ຍົກເລີກການລົບຂໍ້ມູນແລ້ວ !","ຜົນໄດ້ຮັບ", "error");
                    swal({
                        title: "ຍົກເລີກການລົບຂໍ້ມູນແລ້ວ !",
                        text: "ຜົນໄດ້ຮັບ",
                        timer: 1000,
                        type: 'error',
                        confirmButtonColor: "#00a65a",
                        confirmButtonText: "ຕົກລົງ",
                        closeOnConfirm: false,
                        showConfirmButton: true
                    });
                }
            });
    });
</script>