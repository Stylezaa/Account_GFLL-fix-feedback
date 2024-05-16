@extends('master.index')
@section('title',App\Helpers\GetLang::locale('bankNote.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{App\Helpers\GetLang::locale('bankNote.title')}}</span>
        </h4>
    </div>

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if(isset(Request::query()['action']))
                    <form method="POST" action="{{route('bankNote.update',['Rec_Cnt'=>$editBankNote->Rec_Cnt])}}"
                          class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="NoteID"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.id')}}</label>
                                <input type="text" class="form-control"
                                       readonly
                                       name="NoteID"
                                       id="NoteID"
                                       maxlength="10"
                                       value="{{$editBankNote->NoteID}}"
                                       required>
                            </div>
                            <div class="col-md-2">
                                <label for="NoteValue"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.value')}}</label>
                                <input type="text"
                                       class="form-control  @error('NoteValue') is-invalid @enderror"
                                       name="NoteValue"
                                       id="NoteValue"
                                       maxlength="10"
                                       value="{{$editBankNote->NoteValue}}"
                                       required>
                            </div>

                            <div class="col-md-8">
                                <label for="NoteNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.name_e')}}</label>
                                <input type="text"
                                       class="form-control  @error('NoteNameE') is-invalid @enderror"
                                       name="NoteNameE"
                                       id="NoteNameE"
                                       maxlength="180"
                                       value="{{$editBankNote->NoteNameE}}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <label for="NoteNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.name_l')}}</label>
                                <input type="text"
                                       class="form-control  @error('NoteNameL') is-invalid @enderror"
                                       name="NoteNameL"
                                       id="NoteNameL"
                                       maxlength="80"
                                       value="{{$editBankNote->NoteNameL}}"
                                       required>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="BankNoteStop" name="BankNoteStop" value="{{$editBankNote->Stoped}}" @if($editBankNote->Stoped) checked @endif>
                                    <label class="form-check-label" for="BankNoteStop">{{trans('cate.stopped',[],session()->get('locale'))}}</label>
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
                    <form method="POST" action="{{route('bankNote.store')}}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="NoteID"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.id')}}</label>
                                <input type="text"
                                       class="form-control @error('NoteID') is-invalid @enderror"
                                       name="NoteID"
                                       id="NoteID"
                                       maxlength="2"
                                       required>
                            </div>
                            <div class="col-md-2">
                                <label for="NoteValue"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.value')}}</label>
                                <input type="text"
                                       class="form-control  @error('NoteValue') is-invalid @enderror"
                                       name="NoteValue"
                                       id="NoteValue"
                                       maxlength="10"
                                       required>
                            </div>
                            <div class="col-md-4">
                                <label for="NoteNameE"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.name_l')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('NoteNameE') is-invalid @enderror"
                                       name="NoteNameE"
                                       id="NoteNameE"
                                       maxlength="80"
                                       required>
                            </div>
                            <div class="col-md-4">
                                <label for="NoteNameL"
                                       class="form-label">{{App\Helpers\GetLang::locale('bankNote.name_l')}}</label>
                                <input type="text"
                                       class="form-control
                                        @error('NoteNameL') is-invalid @enderror"
                                       name="NoteNameL"
                                       id="NoteNameL"
                                       maxlength="70"
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
            'data'=>$bankNote,
            'headers'=>['ລະຫັດໃບເງິນ','ມູນຄ່າໃບເງິນ','ຊື່ມູນຄ່າໃບເງິນ(ພາສາລາວ)','ຊື່ມູນຄ່າໃບເງິນ(ພາສາອັງກິດ)'],
            'tableId'=>'BankNoteTable',
            'displayKey' => ['NoteID','NoteValue','NoteNameL','NoteNameE'],
            'deleteRoute' => 'bankNote.destroy',
            'editRoute' => 'bankNote.index'
    ])
    </div>
@endsection
