@extends('master.index')
@section('title', App\Helpers\GetLang::locale('office.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">ລົງບັນຊີສະສາງເງິນລ່ວງໜ້າ</span>
            <a href="{{ route('VoucherAdvanceClear.addva', ['action' => 'more', 'key' => null]) }}"
                class="btn btn-primary float-end">ລົງບັນຊີໃໝ່
                &nbsp;<i class="fa fa-plus-circle"></i></a>
        </h4>
    </div>

    <div class="card p-3">
        <form method="GET" action="{{ route('VoucherAdvanceClear.index') }}">
            <div class="row mt-5 mb-5">
                <div class="col col-md-3">
                    <div class="input-group">
                        <label for="startDate" class="form-label m-3">ເລີ້ມຈາກວັນທີ່</label>
                        <input type="date" class="form-control input-mini rounded" value="{{ $startDate }}"
                            id="startDate" name="startDate" />
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="input-group">
                        <label for="startDate" class="form-label m-3">ຫາວັນທີ່</label>
                        <input type="date" class="form-control input-mini rounded" value="{{ $presentDate }}"
                            id="presentDate" name="presentDate" />
                    </div>
                </div>
                <div class="col col-md-3">
                    <button class="btn btn-primary mt-1 text-white" type="submit">
                        <i class="fa fa-keyboard"></i>&nbsp;
                        ຄົ້ນຫາຂໍ້ມູນ
                    </button>
                </div>
            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="voucherTable" style="width: 130%">
                <thead>
                    <tr>
                        <th class="text-nowrap">ຈັດການ</th>
                        <th class="text-nowrap">ເລກລົງບັນຊີ</th>
                        <th class="text-nowrap">ເລກແຊັກ</th>
                        <th class="text-nowrap text-center">ລົງວັນທີ່</th>
                        <th class="text-nowrap">ເນື້ອໃນການລົງບັນຊີ</th>
                        <th class="text-nowrap text-right">ຈຳນວນເງິນ</th>
                        <th class="text-nowrap ">ສະກຸນເງິນ</th>
                        <th class="text-nowrap text-right">ອັດຕາແລກປ່ຽນ</th>
                        <th class="text-nowrap text-right">ໜີ້ເງິນກີບ</th>
                        <th class="text-nowrap text-right">ມີເງິນກີບ</th>
                        <th class="text-nowrap text-right">ໜີເງິນໂດລ່າ</th>
                        <th class="text-nowrap text-right">ມີເງິນໂດລ່າ</th>
                        <th class="text-nowrap">ລົບຂໍ້ມູນ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $key => $value)
                        <tr>
                            <td class="text-nowrap">
                                <a href="{{ route('VoucherAdvanceClear.update', ['key' => $value->Vch_AutoNo]) }}"
                                    class="btn @if ($value->Close_accnt === 1) disabled @endif   btn-outline-warning btn-xs">
                                    <i class="bx bx-edit-alt me-1"></i>
                                    {{-- {{trans('buttoncontrol.edit_btn',[],session()->get('locale'))}} --}}
                                </a>
                                <a href="{{ route('print.showVoucherGeneral', ['level' => $value->LevelID, 'implementCD' => $value->ImplementCD, 'voucherNo' => $value->Vch_AutoNo, 'type' => 'clear_advance', 'path' => 'VoucherAdvanceClear']) }}"
                                    class="btn @if ($value->Close_accnt === 1) disabled @endif btn-outline-primary btn-xs"
                                    target="_blank">
                                    <i class="bx bx-printer me-1"></i>
                                    {{-- {{trans('buttoncontrol.delete_btn',[],session()->get('locale'))}} --}}
                                </a>
                            </td>
                            <td class="text-nowrap">{{ $value->Vch_AutoNo }}</td>
                            <td class="text-nowrap">{{ $value->ChequeNo }}</td>
                            <td class="text-nowrap">{{ App\Helpers\Utils::laoDateFormat($value->VoucherDt) }}</td>
                            <td class="text-nowrap">{{ $value->DescriptionL }}
                                {{-- <br/>
                            <small class="text-green">{{$value->DescriptionE}}</small> --}}
                            </td>
                            <td class="text-nowrap text-right">{{ number_format($value->Voucher_Amt, 2) }}</td>
                            <td class="text-nowrap text-center">{{ $value->Currency }}</td>
                            <td class="text-nowrap text-right">{{ number_format($value->Rate, 2) }}</td>
                            <td class="text-nowrap text-right">{{ number_format($value->Amt_LAK_Dr, 2) }}</td>
                            <td class="text-nowrap text-right">{{ number_Format($value->Amt_LAK_Cr, 2) }}</td>
                            <td class="text-nowrap text-right">{{ number_format($value->Amt_USD_Dr, 2) }}</td>
                            <td class="text-nowrap text-right">{{ number_format($value->Amt_USD_Cr, 2) }}</td>
                            <td class="text-nowrap">
                                <button
                                    class="btn @if ($value->Close_accnt === 1) disabled @endif btn-outline-danger btn-xs"
                                    data-voucher="{{ $value->Vch_AutoNo }}" data-confirm-delete="true" id="btn-del">
                                    <i class="bx bx-trash me-1"></i>
                                    {{-- {{trans('buttoncontrol.delete_btn',[],session()->get('locale'))}} --}}
                                </button>
                            </td>
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
