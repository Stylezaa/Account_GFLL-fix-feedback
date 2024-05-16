@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.css')}}">
@endpush

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="{{$tableId}}">
            <thead>
            <tr>
                @foreach($headers as $key => $item)
                    <th class="text-nowrap">{{$item}}</th>
                @endforeach
                <th class="text-nowrap">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $value)
                <tr>
                    @foreach($displayKey as $item)
                        <td class="text-nowrap">{{ data_get($value, $item) }}</td>
                    @endforeach
                    <td class="text-nowrap" style="text-align: end">
                        <div class="btn-group">
                            <form method="GET" action="{{route($deleteRoute,['Rec_Cnt' =>$value->Rec_Cnt])}} "
                                  class="browser-default-validation delete_form">
                                <input type="hidden" name="Rec_Cnt" value="{{ $value->Rec_Cnt }}">
                                <button type="submit" class="btn rounded-pill btn-outline-danger btn-xs delete-btn"><i
                                        class="fa fa-trash-alt me-1"></i>
                                    {{trans('buttoncontrol.delete_btn',[],session()->get('locale'))}}</button>
                            </form>
                            {{-- <a href="{{route($deleteRoute,['Rec_Cnt' =>$value->Rec_Cnt])}} " class="btn rounded-pill btn-outline-danger btn-xs" data-confirm-delete="true">
                                <i class="bx bx-trash me-1"></i>
                                {{trans('buttoncontrol.delete_btn',[],session()->get('locale'))}}
                            </a> --}}
                            <form method="GET" action="{{route($editRoute,['Rec_Cnt' =>$value->Rec_Cnt])}} "
                                  class="browser-default-validation">
                                <input type="hidden" name="Rec_Cnt" value="{{ $value->Rec_Cnt }}">
                                <input type="hidden" name="action" value="edit">
                                <button type="submit" class="btn rounded-pill btn-outline-warning btn-xs"><i
                                        class="fa fa-pencil-alt me-1"></i>
                                {{trans('buttoncontrol.edit_btn',[],session()->get('locale'))}}
                            </form>
                            {{-- <a href="{{route($editRoute,['action'=>'edit','Rec_Cnt'=>$value->Rec_Cnt]) }}" class="btn rounded-pill btn-outline-warning btn-xs">
                                <i class="bx bx-edit-alt me-1"></i>
                                {{trans('buttoncontrol.edit_btn',[],session()->get('locale'))}}
                            </a> --}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script defer>
        $('#{!!$tableId!!}').dataTable({
            // responsive: true,
            searching: true,
            paginate: true,
            ordering: true,
            select: false,
            // sort: true,
            language: {
                emptyTable: "{!! trans('datatable.emptyTable',[],session()->get('locale')); !!}",
                info: "{!! trans('datatable.info',[],session()->get('locale')); !!}",
                infoEmpty: "{!! trans('datatable.infoEmpty',[],session()->get('locale')); !!}",
                infoFiltered: "{!! trans('datatable.infoFiltered',[],session()->get('locale')); !!}",
                infoThousands: "{!! trans('datatable.infoThousands',[],session()->get('locale')); !!}",
                lengthMenu: "{!! trans('datatable.lengthMenu',[],session()->get('locale')); !!}",
                loadingRecords: "{!! trans('datatable.loadingRecords',[],session()->get('locale')); !!}",
                processing: "{!! trans('datatable.processing',[],session()->get('locale')); !!}",
                search: "{!! trans('datatable.search',[],session()->get('locale')); !!}",
                zeroRecords: '{!! trans('datatable.zeroRecords',[],session()->get('locale')); !!}',
                thousands: "{!! trans('datatable.thousands',[],session()->get('locale')); !!}",
                paginate: {
                    first: "{!! trans('datatable.paginate.first',[],session()->get('locale')); !!}",
                    last: "{!! trans('datatable.paginate.last',[],session()->get('locale')); !!}",
                    next: "{!! trans('datatable.paginate.next',[],session()->get('locale')); !!}",
                    previous: "{!! trans('datatable.paginate.previous',[],session()->get('locale')); !!}"
                },
                aria: {}
            },
            dom: "<'row'<'col-sm-12 col-md-4 d-flex justify-content-start'l>" +
                "<'col-sm-12 col-md-4 mt-2 justify-content-center btn-small'B>" +
                "<'col-sm-12 col-md-4 d-flex d-flex justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {extend: 'copyHtml5', className: 'btn btn-primary text-white'},
                {extend: 'excelHtml5', className: 'btn btn-primary text-white'},
                {extend: 'csvHtml5', className: 'btn btn-primary text-white'},
                {extend: 'pdfHtml5', className: 'btn btn-primary text-white'}
            ],
            style: {
                height: '50px'
            }
        });
    </script>
@endpush
