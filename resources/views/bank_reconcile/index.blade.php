@extends('master.index')
@section('title', 'ສົມທຽບບັນຊີທະນາຄານ')
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">ສົມທຽບບັນຊີທະນາຄານ</span>
            <a href="{{ route('bank-reconcile.createPage') }}"
                class="btn btn-primary float-end">{{ \App\Helpers\GetLang::locale('voucher.new') }}
                &nbsp;<i class="fa fa-plus-circle"></i></a>
        </h4>
    </div>

    <div class="card p-3">
        <form method="GET" action="{{ route('voucher.index') }}">
            <div class="row mt-5 mb-5">
                <div class="col col-md-3">
                    <div class="input-group">
                        <label for="startDate"
                            class="form-label m-3">{{ \App\Helpers\GetLang::locale('voucher.from_date') }}</label>
                        <input type="date" class="form-control input-mini rounded" value="{{ $startDate }}"
                            id="startDate" name="startDate" />
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="input-group">
                        <label for="startDate"
                            class="form-label m-3">{{ \App\Helpers\GetLang::locale('voucher.to_date') }}</label>
                        <input type="date" class="form-control input-mini rounded" value="{{ $presentDate }}"
                            id="presentDate" name="presentDate" />
                    </div>
                </div>
                <div class="col col-md-3">
                    <button class="btn btn-primary mt-1 text-white" type="submit">
                        <i class="fa fa-keyboard"></i>&nbsp;
                        {{ \App\Helpers\GetLang::locale('voucher.search') }}
                    </button>
                </div>
            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped disabled nowrap" id="voucherTable" style="width: 130%">
                <thead class="gap-0">
                    <tr>
                        <th class="text-nowrap">{{ \App\Helpers\GetLang::locale('voucher.action') }}</th>
                        <th class="text-nowrap fit-width">ຂັ້ນ</th>
                        <th class="text-nowrap">ເລກທີລະບົບ</th>
                        <th class="text-nowrap">ເລກທີໃບສົມທຽບ</th>
                        <th class="text-nowrap">ວັນທີສົມທຽບ</th>
                        <th class="text-nowrap">ເລກທີໃບຕິດຕາມ</th>
                        <th class="text-nowrap">ລະຫັດບັນຊີ</th>
                        <th class="text-nowrap">ວັນທີຍົກມາ</th>
                        <th class="text-nowrap">ຍອດຍົກມາ</th>
                        <th class="text-nowrap">ຮັບເຂົ້າ</th>
                        <th class="text-nowrap">ຈ່າຍອອກ</th>
                        <th class="text-nowrap">ຍອດເຫຼືອບັນຊີ</th>
                        <th class="text-nowrap">ຍອດຍົກສໍາຮອງ</th>
                        <th class="text-nowrap">ເງິນທທີ່ບໍ່ທັນໄດ້ເຂົ້າບັນຊີ</th>
                        <th class="text-nowrap">ເຊັກທີ່ຍັງບໍ່ທັນໄດ້ຖອນ</th>
                        <th class="text-nowrap">ຍອດເຫຼືອບັນຊີ</th>
                        <th class="text-nowrap">ຜູ້ເຄື່ອນໄຫວ</th>
                        <th class="text-nowrap">ວັນທີ່ເຄື່ອນໄຫວ</th>
                        <th class="text-nowrap">ຄອບພິວເຕີເຄື່ອນໄຫວ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bankReconciless as $key => $value)
                        <tr>
                            <td width="100px" class="ma-0">
                                <div class="btn-group ma-0">
                                    <a href="/"
                                        class="btn @if ($value->Close_accnt === 1) disabled @endif   btn-outline-warning btn-xs">
                                        <i class="bx bx-edit-alt me-1"></i>
                                        {{-- {{trans('buttoncontrol.edit_btn',[],session()->get('locale'))}} --}}
                                    </a>

                                    <a href="/"
                                        class="btn @if ($value->Close_accnt === 1) disabled @endif btn-outline-primary btn-xs"
                                        target="_blank">
                                        <i class="bx bx-printer me-1"></i>
                                        {{-- {{trans('buttoncontrol.delete_btn',[],session()->get('locale'))}} --}}
                                    </a>
                                </div>
                            </td>
                            <td class="text-nowrap fit-width">{{ $value->VoucherNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BRCC_No }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BRCCDt }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BRCCDt }}</td>
                            <td class="text-nowrap fit-width">{{ $value->AccountCD }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BBk_open }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BBk_open }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BBK_Recpt }}</td>
                            <td class="text-nowrap fit-width">{{ $value->BBK_Pay }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap fit-width">{{ $value->Vch_AutoNo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}">
    @endpush

    @push('script')
        <script src="{{ asset('js/datatables.js') }}"></script>
        <script>
            const url = '{{ env('MIX_APP_URL') }}:{{ env('MIX_APP_PORT') }}';
            $('#voucherTable').dataTable({
                searching: true,
                paginate: true,
                ordering: true,
                select: false,
                language: {
                    emptyTable: "{!! trans('datatable.emptyTable', [], session()->get('locale')) !!}",
                    info: "{!! trans('datatable.info', [], session()->get('locale')) !!}",
                    infoEmpty: "{!! trans('datatable.infoEmpty', [], session()->get('locale')) !!}",
                    infoFiltered: "{!! trans('datatable.infoFiltered', [], session()->get('locale')) !!}",
                    infoThousands: "{!! trans('datatable.infoThousands', [], session()->get('locale')) !!}",
                    lengthMenu: "{!! trans('datatable.lengthMenu', [], session()->get('locale')) !!}",
                    loadingRecords: "{!! trans('datatable.loadingRecords', [], session()->get('locale')) !!}",
                    processing: "{!! trans('datatable.processing', [], session()->get('locale')) !!}",
                    search: "{!! trans('datatable.search', [], session()->get('locale')) !!}",
                    zeroRecords: '{!! trans('datatable.zeroRecords', [], session()->get('locale')) !!}',
                    thousands: "{!! trans('datatable.thousands', [], session()->get('locale')) !!}",
                    paginate: {
                        first: "{!! trans('datatable.paginate.first', [], session()->get('locale')) !!}",
                        last: "{!! trans('datatable.paginate.last', [], session()->get('locale')) !!}",
                        next: "{!! trans('datatable.paginate.next', [], session()->get('locale')) !!}",
                        previous: "{!! trans('datatable.paginate.previous', [], session()->get('locale')) !!}"
                    },
                    aria: {}
                },
                dom: "<'row'<'col-sm-12 col-md-4 d-flex justify-content-start'l>" +
                    "<'col-sm-12 col-md-4 mt-2 justify-content-center btn-small'B>" +
                    "<'col-sm-12 col-md-4 d-flex d-flex justify-content-end'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                        extend: 'copyHtml5',
                        className: 'btn btn-primary text-white'
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-primary text-white'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'btn btn-primary text-white'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-primary text-white'
                    }
                ],
                style: {
                    height: '50px'
                }
            });
            $(document).on('click', '#btn-del', function(e) {
                const keyId = $(this).attr('data-voucher');
                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ!',
                    text: 'ທ່ານຕ້ອງການລົບແທ້ບໍ່?',
                    icon: 'warning',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'ຍົກເລີກ',
                    confirmButtonText: 'ຕົກລົງ'
                }).then((rs) => {
                    if (rs.isConfirmed) {
                        axios.get(`${url}/GeneralVoucher/destroy?keyId=${keyId}`).then(() => {
                            Swal.fire({
                                toast: true,
                                position: 'top-right',
                                title: 'ສຳເລັດ',
                                text: 'ການລຶບຂໍ້ມູນສຳເລັດ!',
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                customClass: {
                                    container: 'swalZ-index'
                                }
                            });
                            location.reload();
                        })
                    }
                }).catch(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-right',
                        background: 'red',
                        color: 'white',
                        title: 'ຜິດພາດ!',
                        text: 'ການລຶບຂໍ້ມູນບໍ່ສຳເລັດ!',
                        icon: 'error',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: {
                            container: 'swalZ-index'
                        }
                    })
                })
            })
        </script>
    @endpush
@endsection
