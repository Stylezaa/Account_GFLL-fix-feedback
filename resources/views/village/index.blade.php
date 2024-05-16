@extends('master.index')
@section('title',trans('village.title',[],session()->get('locale')))
@section('content')
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{trans('villages.title',[], session()->get('locale'))}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('village.update',['Rec_Cnt'=>$editdistrict->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="DistrictID"
                                       class="form-label">{{trans('villages.district_id',[],session()->get('locale'))}}</label>
                                <input type="text" class="form-control"
                                       readonly
                                       name="DistrictID"
                                       id="DistrictID"
                                       maxlength="10"
                                       value="{{$editdistrict->DistrictID}}"
                                       required>
                            </div>

                            <div class="col-md-8">
                                <label for="ProvinceID" class="form-label">{{trans('villages.province_id',[],session()->get('locale'))}}</label>
                                <select class="form-select  @error('ProvinceID') is-invalid @enderror" name="ProvinceID" id="ProvinceID" required>
                                    @foreach($provines as $key => $item)
                                        <option value="{{$item->ProvinceID}}" {{$editdistrict->ProvinceID==$item->ProvinceID ? 'selected': ''}}>{{$item->ProvinceNameL}} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label for="DistrictNameL"
                                       class="form-label">{{trans('villages.district_name_la',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('DistrictNameL') is-invalid @enderror"
                                       name="DistrictNameL"
                                       id="DistrictNameL"
                                       maxlength="80"
                                       required
                                       value="{{$editdistrict->DistrictNameL}}">
                            </div>

                            <div class="col-md-5">
                                <label for="DistrictNameE"
                                       class="form-label">{{trans('villages.district_name_en',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('DistrictNameE') is-invalid @enderror"
                                       name="DistrictNameE"
                                       id="DistrictNameE"
                                       maxlength="80"
                                       required
                                       value="{{$editdistrict->DistrictNameE}}">
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input @if('villageStop') is-invalid @endif"
                                           type="checkbox"
                                           id="villageStop"
                                           name="villageStop"
                                           value="{{$editdistrict->Stoped}}"
                                           @if($editdistrict->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                           for="villageStop">{{trans('villages.stopped',[],session()->get('locale'))}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button type="submit"
                                        class="btn btn-primary">{{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                                        <a href="{{ url('/village') }}" class="btn btn-secondary"><i class="fa fa-times-circle"></i> &nbsp; {{trans('buttoncontrol.cancle_btn',[],session()->get('locale'))}}</a>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{route('village.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="VillageID"
                                       class="form-label">{{trans('villages.village_id',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control"
                                       name="VillageID"
                                       id="VillageID"
                                       maxlength="10"
                                       required>
                            </div>
                            {{-- <div class="col-md-8">
                                <label for="DistrictID" class="form-label">{{trans('villages.province_id',[],session()->get('locale'))}}</label>
                                <select class="form-select  @error('DistrictID') is-invalid @enderror" name="DistrictID" id="DistrictID" required>
                                    <option>ເລືອກແຂວງ</option>
                                @foreach($provines as $key => $item)
                                        <option value="{{$item->ProvinceID}}">{{$item->ProvinceNameL}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            @include('village.filter', ['filterValue' => $filterValue])
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="VillageNameL"
                                       class="form-label">{{trans('villages.village_name_la',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('VillageNameL') is-invalid @enderror"
                                       name="VillageNameL"
                                       id="VillageNameL"
                                       maxlength="180"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label for="VillageNameE"
                                       class="form-label">{{trans('villages.village_name_en',[],session()->get('locale'))}}</label>
                                <input type="text"
                                       class="form-control  @error('VillageNameE') is-invalid @enderror"
                                       name="VillageNameE"
                                       id="VillageNameE"
                                       maxlength="180"
                                       required>
                            </div>
                        </div>


                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button
                                    type="submit"
                                    class="btn btn-primary">{{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!-- Browser Default -->
    <div class="col-md mt-5">
        @include('components.datatable-action',[
            'data'=>$village,
            'headers'=>['ລະຫັດ','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ','ຊື່ເມືອງ(ລາວ)','ຊື່ເມືອງ(ອັງກິດ)','ສະຖານະ'],
            'tableId'=>'villageTable',
            'displayKey' => ['VillageID','VillageNameL','VillageNameE','DistrictNameL','DistrictNameE','Stoped'],
            'deleteRoute' => 'village.destroy',
            'editRoute' => 'village.index'
        ])
    </div>
@endsection
@push('script')
{{-- <script>
alert('I\'m coming from child')
</script> --}}
<script >
    var filterValue = {!! json_encode($filterValue) !!};
    var alldistrict = {!! DB::table('KSDistricts')->join('KSProvinces', 'KSProvinces.ProvinceID', '=', 'KSDistricts.ProvinceID')->select('KSDistricts.DistrictID', 'KSDistricts.DistrictNameL', 'KSDistricts.ProvinceID')->get() !!};
    $(document).ready(function() {
        let ProvinceID = $("select[name='ProvinceID']").val();
        let dist_born = $("select[name='DistrictID']").val();
        $('select#DistrictID').html(
            '<option value="">--ເລືອກເມືອງ--</option>' +
            alldistrict
            .filter(s => s.province_name == ProvinceID)
            .map(element => {
                return `<option value='${element.DistrictID}' ${element.DistrictID===filterValue.DistrictID ? 'selected' : ''} >${element.DistrictNameL}</option>`
            })
            .join('')
        )
    })

    $(document).ready(function() {
        // if branch changed, change list of stations
        $('select#ProvinceA').on('change', function(e) {
            // console.log($(this).val());
            $('select#DistrictID').html(
                '<option value="">--ເລືອກເມືອງ--</option>' +
                alldistrict
                .filter(s => s.ProvinceID == $(this).val())
                .map(element => {
                    return `<option value='${element.DistrictID}' ${element.DistrictID==filterValue.DistrictID ? 'selected' : ''} >${element.DistrictNameL}</option>`
                })
                .join('')
            )

        })
    })
    $(document).ready(function() {
        // if branch changed, change list of stations
        function fetch_dist_data(page,query = '',dist_id)
        {
            $.ajax({
            url:"{{ route('village.actionLoad') }}",
            method:'GET',
            data:{query:query,page:page,dist_id:dist_id},
            dataType:'json',
            success:function(data)
            {
                $('tbody').html(data.table_data);
                $('#total_records').text(data.total_data);
            }
        })
        }
        $('select#DistrictID').on('change', function(e) {
            console.log($(this).val());
            var query = $(this).val();
            let dist_id  = $("select[name='DistrictID']").val();
            fetch_dist_data(1,query,dist_id);
            // let formData = {
            //     query: $(this).val(),
            // };
            // let formAction = "{{ route('village.actionLoad') }}"; //"{{ route('village.getvillage') }}"; // form handler url

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-Token': "{{ csrf_token() }}"
            //     }
            // });

            // $.ajax({
            //     type: 'GET',
            //     url: formAction,
            //     data: formData,
            //     dataType: 'json',
            //     cache: false,

            //     beforeSend: function () {
            //         console.log(formData);
            //     },
            //     success: function (data) {
            //         console.log('status: ' + data.status);
            //         if (data.status === 'success') {
            //            console.log(data.village)
            //         }else{
            //             // $('#emprname').val(data.emprname);
                        
            //         }
            //     },
            //     error(data) {
            //         console.log('error: ' + data);
            //     }
            // }).done(function () {
            //     console.log('Done!');
            // })
            //     .fail(function () {
            //         console.log('Failed!');
            //     });

        })
    })

</script>
@endpush

