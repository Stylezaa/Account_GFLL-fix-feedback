@extends('master.index')
@section('title', App\Helpers\GetLang::locale('cate.title'))
@section('content')
    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ App\Helpers\GetLang::locale('cate.title') }}</span>
        </h4>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Browser Default -->
    <div class="col-md mb-5 mb-4 mb-md-0">
        <div class="card">
            <div class="card-body">
                @if (isset(Request::query()['action']))
                    <form method="POST" action="{{ route('cate.update', ['Rec_Cnt' => $editCategory->Rec_Cnt]) }}"
                        class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="CategoryID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_id') }}</label>
                                <input type="text" class="form-control" readonly name="CategoryID" id="CategoryID"
                                    maxlength="10" value="{{ $editCategory->CategoryID }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="CategorySym"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_sym') }}</label>
                                <input type="text" class="form-control  @error('CategorySym') is-invalid @enderror"
                                    name="CategorySym" id="CategorySym" maxlength="10"
                                    value="{{ $editCategory->CategorySym }}" required>
                            </div>

                            <div class="col-md-8">
                                <label for="CategoryNameL"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_name_l') }}</label>
                                <input type="text" class="form-control  @error('CategoryNameL') is-invalid @enderror"
                                    name="CategoryNameL" id="CategoryNameL" maxlength="180"
                                    value="{{ $editCategory->CategoryNameL }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <label for="donor_name_e"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_name_e') }}</label>
                                <input type="text" class="form-control  @error('CategoryNameE') is-invalid @enderror"
                                    name="CategoryNameE" id="CategoryNameE" maxlength="80"
                                    value="{{ $editCategory->CategoryNameE }}" required>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="CategoryStop" name="CategoryStop"
                                        value="{{ $editCategory->Stoped }}"
                                        @if ($editCategory->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                        for="CategoryStop">{{ trans('cate.stopped', [], session()->get('locale')) }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary text-white me-2" name="action"
                                    value="edit">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{ trans('buttoncontrol.edit_btn', [], session()->get('locale')) }}
                                </button>

                                <button type="submit" class="btn btn-success text-white" name="action" value="create">
                                    <i class="fa fa-plus"></i> &nbsp;
                                    {{ trans('buttoncontrol.btn_new_submit', [], session()->get('locale')) }}
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{ route('cate.store') }}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="CategoryID"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_id') }}</label>
                                <input type="text" class="form-control" name="CategoryID" id="CategoryID" maxlength="10"
                                    required>
                            </div>
                            <div class="col-md-2">
                                <label for="CategorySym"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_sym') }}</label>
                                <input type="text" class="form-control  @error('CategorySym') is-invalid @enderror"
                                    name="CategorySym" id="CategorySym" maxlength="10" required>
                            </div>
                            <div class="col-md-8">
                                <label for="CategoryNameL"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_name_e') }}</label>
                                <input type="text"
                                    class="form-control
                                        @error('CategoryNameL') is-invalid @enderror"
                                    name="CategoryNameL" id="CategoryNameL" maxlength="180" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="CategoryNameE"
                                    class="form-label">{{ App\Helpers\GetLang::locale('cate.cate_name_l') }}</label>
                                <input type="text" class="form-control  @error('CategoryNameE') is-invalid @enderror"
                                    name="CategoryNameE" id="CategoryNameE" maxlength="180" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{ trans('buttoncontrol.add_btn', [], session()->get('locale')) }}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Browser Default -->
    <div class="col-md mt-5">
        @include('components.datatable-action', [
            'data' => $categories,
            'headers' => [
                trans('cate.cate_id', [], session()->get('locale')),
                trans('cate.cate_sym', [], session()->get('locale')),
                trans('cate.cate_name_l', [], session()->get('locale')),
                trans('cate.cate_name_e', [], session()->get('locale')),
                trans('cate.stopped', [], session()->get('locale')),
            ],
            'tableId' => 'donorTable',
            'displayKey' => ['CategoryID', 'CategorySym', 'CategoryNameL', 'CategoryNameE', 'Stoped'],
            'deleteRoute' => 'cate.destroy',
            'editRoute' => 'cate.index',
        ])
    </div>
@endsection
