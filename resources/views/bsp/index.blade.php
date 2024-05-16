@extends('master.index')
@section('title',App\Helpers\GetLang::locale('bsp.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('bsp.title')}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('bsp.update',['Rec_Cnt'=>$editBspCate->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="BspCategoryID"
                                       class="form-label">{{App\Helpers\GetLang::locale('bsp.id')}}</label>
                                <input type="text"
                                       class="form-control @error('BspCategoryID') is-invalid @enderror"
                                       readonly
                                       name="BspCategoryID"
                                       id="BspCategoryID"
                                       maxlength="10"
                                       value="{{$editBspCate->BSPCat_ID}}"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="BspCategoryNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('bsp.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('BspCategoryNameL') is-invalid @enderror"
                                       name="BspCategoryNameL"
                                       id="BspCategoryNameL"
                                       maxlength="180"
                                       value="{{$editBspCate->BSPCat_NameL}}"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="BspCategoryNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('bsp.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('BspCategoryNameE') is-invalid @enderror"
                                       name="BspCategoryNameE"
                                       id="BspCategoryNameE"
                                       maxlength="80"
                                       value="{{$editBspCate->BSPCat_NameE}}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="BspCategoryStop" name="BspCategoryStop" value="{{$editBspCate->Stoped}}" @if($editBspCate->Stoped === 1) checked @endif>
                                    <label class="form-check-label" for="BspCategoryStop">{{trans('cate.stopped',[],session()->get('locale'))}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{route('bsp.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="BspCategoryID"
                                       class="form-label">{{App\Helpers\GetLang::locale('bsp.id')}}</label>
                                <input type="text"
                                       class="form-control"
                                       name="BspCategoryID"
                                       id="BspCategoryID"
                                       maxlength="10"
                                       required>
                            </div>
                            <div class="col-md-5">
                                <label for="BspCategoryNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('bsp.name_e')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('BspCategoryNameL') is-invalid @enderror"
                                       name="BspCategoryNameL"
                                       id="BspCategoryNameL"
                                       maxlength="180"
                                       required>
                            </div>

                            <div class="col-md-5">
                                <label for="BspCategoryNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('bsp.name_l')}}</label>
                                <input type="text" class="form-control  @error('BspCategoryNameE') is-invalid @enderror"
                                       name="BspCategoryNameE"
                                       id="BspCategoryNameE"
                                       maxlength="180"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{trans('donor.submit_btn',[],session()->get('locale'))}}</button>
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
            'data'=>$bspCate,
            // 'headers'=>['ລະຫັດ','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ'],
            'headers' => [
                trans('bsp.id', [], session()->get('locale')),
                trans('bsp.name_l', [], session()->get('locale')),
                trans('bsp.name_e', [], session()->get('locale')),
                trans('bsp.stopped', [], session()->get('locale')),
            ],
            'tableId'=>'donorTable',
            'displayKey' => ['BSPCat_ID','BSPCat_NameL','BSPCat_NameE', 'Stoped'],
            'deleteRoute' => 'bsp.destroy',
            'editRoute' => 'bsp.index'
    ])
    </div>
@endsection
