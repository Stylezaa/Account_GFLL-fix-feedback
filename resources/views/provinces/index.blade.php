@extends('master.index')
@section('title',App\Helpers\GetLang::locale('province.province'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{trans('province.province',[],session()->get('locale'))}}</span>
        </h4>
    </div>
    <!-- Browser Default -->
    <div class="card">
        <div class="card-body">

            <div class="card">
              <div class="card-body">
                @if (Request::query('action') == 'edit')
                  <form method="POST" action="{{ url('/province/update') }}" class="browser-default-validation">
                    {{ csrf_field() }}
                    <div class="row g-3 text-white">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provinceid">{{trans('province.province_id',[],session()->get('locale'))}}</label>
                          <div class="col-sm-9">
                            <input type="text" id="collapsible-provinceid" name="provinceid" value="{{$editprovince->ProvinceID}}" class="form-control" placeholder="" fdprocessedid="6z12lh" maxlength="2">
                            <input type="text" id="collapsible-Rec_Cnt" name="Rec_Cnt" value="{{$editprovince->Rec_Cnt}}" class="form-control" hidden>
                          </div>
                          @if($errors->has('provinceid'))
                            <span class="help-block">
                            <strong
                                class="text-danger Sans-Cond-ot">{!!$errors->first('provinceid')!!}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provincesym">{{trans('province.province_sym',[],session()->get('locale'))}}</label>
                          <div class="col-sm-4">
                            <input type="text" id="collapsible-provincesym" name="provincesym" value="{{$editprovince->ProvinceSym}}" class="form-control" placeholder=""  fdprocessedid="oz9r" maxlength="3">
                          </div>
                          <div class="col-md-4">
                              <div class="form-check form-switch" style="margin-top: 10px">
                                  <input class="form-check-input" type="checkbox" id="provinceStop" name="provinceStop" value="{{$editprovince->Stoped}}" @if($editprovince->Stoped === 1) checked @endif>
                                  <label class="form-check-label col-form-label" for="provinceStop">{{trans('province.stopped',[],session()->get('locale'))}}</label>
                              </div>
                          </div>
                          @if($errors->has('provincesym'))
                            <span class="help-block">
                            <strong
                                class="text-danger Sans-Cond-ot">{!!$errors->first('provincesym')!!}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provincenamel">{{trans('province.province_name_la',[],session()->get('locale'))}}</label>
                          <div class="col-sm-9">
                            <input type="text" id="collapsible-provincenamel" name="provincenamel" value="{{$editprovince->ProvinceNameL}}" class="form-control" placeholder="" fdprocessedid="529jt" maxlength="50">
                          </div>
                          @if($errors->has('provincenamel'))
                            <span class="help-block">
                            <strong
                                class="text-danger Sans-Cond-ot">{!!$errors->first('provincenamel')!!}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provincenamee">{{trans('province.province_name_en',[],session()->get('locale'))}}</label>
                            <div class="col-sm-9">
                              <input type="text" id="collapsible-provincenamee" name="provincenamee" value="{{$editprovince->ProvinceNameE}}" class="form-control" placeholder="" fdprocessedid="ykyhk" maxlength="50">
                            </div>
                            @if($errors->has('provincenamee'))
                              <span class="help-block">
                              <strong
                                  class="text-danger Sans-Cond-ot">{!!$errors->first('provincenamee')!!}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-6">
                          <div class="row justify-content-end">
                            <div class="col-sm-9">
                              <button type="submit" class="btn btn-primary" >
                                <span class="tf-icons bx bx-save "></span> {{trans('buttoncontrol.submit_btn',[],session()->get('locale'))}}
                              </button>
                              <a href="{{ url('/province') }}" class="btn btn-secondary"><i class="fa fa-times-circle"></i> &nbsp; {{trans('buttoncontrol.cancle_btn',[],session()->get('locale'))}}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                @else
                <form  method="POST" action="{{ url('/province/insert') }}" class="browser-default-validation">
                  {{ csrf_field() }}
                    <div class="row g-3 text-white">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provinceid">{{trans('province.province_id',[],session()->get('locale'))}}</label>
                          <div class="col-sm-9">
                            <input type="text" id="collapsible-provinceid" name="provinceid" class="form-control" placeholder="" fdprocessedid="6z12lh" maxlength="2">
                          </div>
                            @if($errors->has('provinceid'))
                              <span class="help-block">
                              <strong
                                  class="text-danger Sans-Cond-ot">{!!$errors->first('provinceid')!!}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provincesym">{{trans('province.province_sym',[],session()->get('locale'))}}</label>
                          <div class="col-sm-9">
                            <input type="text" id="collapsible-provincesym" name="provincesym" class="form-control" placeholder=""  fdprocessedid="oz9r" maxlength="3">
                          </div>
                          @if($errors->has('provincesym'))
                            <span class="help-block">
                            <strong
                                class="text-danger Sans-Cond-ot">{!!$errors->first('provincesym')!!}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provincenamel">{{trans('province.province_name_la',[],session()->get('locale'))}}</label>
                          <div class="col-sm-9">
                            <input type="text" id="collapsible-provincenamel" name="provincenamel" class="form-control" placeholder="" fdprocessedid="529jt" maxlength="50">
                          </div>
                          @if($errors->has('provincenamel'))
                            <span class="help-block">
                            <strong
                                class="text-danger Sans-Cond-ot">{!!$errors->first('provincenamel')!!}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-end" for="collapsible-provincenamee">{{trans('province.province_name_en',[],session()->get('locale'))}}</label>
                            <div class="col-sm-9">
                              <input type="text" id="collapsible-provincenamee" name="provincenamee" class="form-control" placeholder="" fdprocessedid="ykyhk" maxlength="50">
                            </div>
                            @if($errors->has('provincenamee'))
                              <span class="help-block">
                              <strong
                                  class="text-danger Sans-Cond-ot">{!!$errors->first('provincenamee')!!}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="row mt-1">
                        <div class="col-md-6">
                          <div class="row justify-content-end">
                            <div class="col-sm-9">
                              <button type="submit" class="btn btn-primary" >
                                <span class="tf-icons bx bx-save "></span> {{trans('buttoncontrol.submit_btn',[],session()->get('locale'))}}
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                @endif
              </div>
            </div>
            <div class="col-md mt-5">
              @include('components.datatable-action',[
                  'data'=>$provinces,
                  'headers'=>['ລະຫັດ','ຊື່ຫຍໍ້','ຊື່ພາສາລາວ','ຊື່ພາສາອັງກິດ','ສະຖານະ'],
                  'tableId'=>'provinceTable',
                  'displayKey' => ['ProvinceID','ProvinceSym','ProvinceNameL','ProvinceNameE','Stoped'],
                  'deleteRoute' => 'province.destroy',
                  'editRoute' => 'province.index'
              ])
              </div>
    </div>
@endsection
