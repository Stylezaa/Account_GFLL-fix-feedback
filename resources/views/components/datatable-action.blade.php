@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.css') }}">

    <style>
        .card {
            max-height: 800px;
            /* Set the desired height for the card */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        /* Make the table header sticky */
        #{{ $tableId }} thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            /* Ensure the header is above other elements */
            background-color: white;
            /* Optional: Set background color */
        }
    </style>
@endpush


<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="{{ $tableId }}">
            <thead>
                <tr>
                    @foreach ($headers as $key => $item)
                        <th class="text-nowrap">{{ $item }}</th>
                    @endforeach
                    <th class="text-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        @foreach ($displayKey as $item)
                            <td class="text-nowrap">{{ data_get($value, $item) }}</td>
                        @endforeach
                        <td class="text-nowrap" style="text-align: end">
                            <div class="btn-group">
                                <button type="button" class="btn rounded-pill btn-outline-danger btn-xs delete-btn"
                                    data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                    data-record-id="{{ $value->Rec_Cnt }}">
                                    <i class="fa fa-trash-alt me-1"></i>
                                    {{ trans('buttoncontrol.delete_btn', [], session()->get('locale')) }}
                                </button>

                                {{-- <form method="GET" action="{{ route($deleteRoute, ['Rec_Cnt' => $value->Rec_Cnt]) }} "
                                    class="browser-default-validation delete_form">
                                    <input type="hidden" name="Rec_Cnt" value="{{ $value->Rec_Cnt }}">
                                    <button type="submit"
                                        class="btn rounded-pill btn-outline-danger btn-xs delete-btn"><i
                                            class="fa fa-trash-alt me-1"></i>
                                        {{ trans('buttoncontrol.delete_btn', [], session()->get('locale')) }}</button>


                                </form> --}}
                                {{-- <a href="{{route($deleteRoute,['Rec_Cnt' =>$value->Rec_Cnt])}} " class="btn rounded-pill btn-outline-danger btn-xs" data-confirm-delete="true">
                                <i class="bx bx-trash me-1"></i>
                                {{trans('buttoncontrol.delete_btn',[],session()->get('locale'))}}
                            </a> --}}
                                <button type="button" class="btn rounded-pill btn-outline-warning btn-xs edit-btn"
                                    data-rec-cnt="{{ $value->Rec_Cnt }}">
                                    <i class="fa fa-pencil-alt me-1"></i>
                                    {{ trans('buttoncontrol.edit_btn', [], session()->get('locale')) }}
                                </button>
                                {{-- <form method="GET" action="{{ route($editRoute, ['Rec_Cnt' => $value->Rec_Cnt]) }}"
                                    class="browser-default-validation">
                                    <input type="hidden" name="Rec_Cnt" value="{{ $value->Rec_Cnt }}">
                                    <input type="hidden" name="action" value="edit">
                                    <button type="submit" class="btn rounded-pill btn-outline-warning btn-xs"><i
                                            class="fa fa-pencil-alt me-1"></i>
                                        {{ trans('buttoncontrol.edit_btn', [], session()->get('locale')) }}
                                </form> --}}
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

<div class="modal modal-xl fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-center">{{ trans('buttoncontrol.delete_msg', [], session()->get('locale')) }}</h3>
                <br />
                <form id="deleteForm" method="GET" action="{{ route($deleteRoute, ['Rec_Cnt' => ':id']) }}"
                    class="browser-default-validation delete_form">
                    <input type="hidden" name="Rec_Cnt" value="">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-danger text-white me-4" id="confirmDeleteBtn"
                            style="width: 100px; height: 40px; font-size: 15px; font-weight: 500; line-height: 1.5; border-radius: 0.3rem;">
                            {{ trans('buttoncontrol.delete_btn', [], session()->get('locale')) }}</button>
                        <button type="button" class="btn btn-secondary text-white"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <!--    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>-->
    <script src="{{ asset('js/datatables.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                var recordId = $(this).data('rec-cnt');
                var currentPage = getCurrentPageFromHash();
                var baseUrl = "{{ route($editRoute) }}";
                var url = baseUrl + "?Rec_Cnt=" + recordId + "&action=edit#" + currentPage;
                window.location.href = url;
            });

            function getCurrentPageFromHash() {
                var hash = window.location.hash;
                return hash ? parseInt(hash.substring(1)) : 0;
            }
        });
    </script>

    <script defer>
        $(document).ready(function() {
            // Function to get the current page from the URL hash
            function getCurrentPageFromHash() {
                var hash = window.location.hash;
                return hash ? parseInt(hash.substring(1)) : 0;
            }

            var initialPage = getCurrentPageFromHash(); // Set the initial page here
            var amountOfRecords = 10;

            var table = $('#{!! $tableId !!}').DataTable({
                // responsive: true,
                searching: true,
                paginate: true,
                // Set the initial page to the default page
                pageLength: amountOfRecords,
                page: initialPage,
                displayStart: initialPage * amountOfRecords,
                ordering: true,
                select: false,
                // sort: true,
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
                // Customize the DOM structure for pagination
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

            // table.fnPageChange(2,true); //change page to 2 and redraw the table
            // Update the URL hash whenever the page changes
            table.on('page.dt', function(e, settings) {
                var page = settings._iDisplayStart / settings._iDisplayLength;
                window.location.hash = '#' + page;
            });
        });
    </script>


    <script defer>
        $(document).ready(function() {
            var deleteForm;

            $('.delete-btn').on('click', function() {
                var recordId = $(this).data('record-id');
                $('#deleteForm input[name="Rec_Cnt"]').val(recordId);
                $('#deleteConfirmationModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function() {
                var recordId = $('#deleteForm input[name="Rec_Cnt"]').val();
                if (recordId) {
                    $('#deleteForm').attr('action', $('#deleteForm').attr('action').replace(
                        ':id',
                        recordId));
                    $('#deleteForm').submit();
                    $('#deleteConfirmationModal').modal('hide');
                }
            });
        });
    </script>
@endpush
