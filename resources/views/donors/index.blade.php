@extends('master.index')
@section('title', App\Helpers\GetLang::locale('donor.donor_title'))
@section('content')

    {{-- Title to show where we are  --}}
    <div class="col col-12 flex-column">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ trans('donor.donor', [], session()->get('locale')) }}</span>
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
                    <form method="POST" action="{{ route('donors.update', ['Rec_Cnt' => $ditDonors->Rec_Cnt]) }}"
                        class="browser-default-validation">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="donor_id"
                                    class="form-label">{{ trans('donor.donor_id', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control" readonly name="donorId" id="donorId"
                                    maxlength="10" value="{{ $ditDonors->DonorID }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="donor_sym"
                                    class="form-label">{{ trans('donor.donor_sym', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    name="donorSym" id="donor_sym" maxlength="10" value="{{ $ditDonors->DonorSym }}"
                                    required>
                            </div>
                            {{-- {{dd($ditDonors)}} --}}
                            <div class="col-md-3">
                                <label for="currency"
                                    class="form-label">{{ trans('donor.currency', [], session()->get('locale')) }}</label>
                                <select class="form-select  @error('email') is-invalid @enderror" name="currency"
                                    id="currency" required>
                                    <option value="LAK" @if ($ditDonors->CurrencyCD === 'LAK') selected @endif>LAK (Lao
                                        Kip)
                                    </option>
                                    <option value="USD" @if ($ditDonors->CurrencyCD === 'USD') selected @endif>USD (United
                                        States Dollar)
                                    </option>
                                    <option value="THB" @if ($ditDonors->CurrencyCD === 'THB') selected @endif>THB (Thai
                                        Bath)
                                    </option>
                                    <option value="CNY" @if ($ditDonors->CurrencyCD === 'CNY') selected @endif>CNY (China
                                        Yuan)
                                    </option>
                                    <option value="VND" @if ($ditDonors->CurrencyCD === 'VND') selected @endif>VND
                                        (Vietnam
                                        Dong)
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch" style="margin-top: 35px">
                                    <input class="form-check-input" type="checkbox" id="donorStop" name="donorStop"
                                        value="{{ $ditDonors->Stoped }}"
                                        @if ($ditDonors->Stoped === 1) checked @endif>
                                    <label class="form-check-label"
                                        for="donorStop">{{ trans('donor.stopped', [], session()->get('locale')) }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="donor_name_l"
                                    class="form-label">{{ trans('donor.donor_name_la', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    name="donorNameL" id="donorNameL" maxlength="80"
                                    value="{{ $ditDonors->DonorNameL }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="donorNameE"
                                    class="form-label">{{ trans('donor.donor_name_en', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    name="donorNameE" id="donorNameE" maxlength="80"
                                    value="{{ $ditDonors->DonorNameE }}" required>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fa fa-save"></i> &nbsp;
                                    {{ trans('donor.submit_btn', [], session()->get('locale')) }}</button>
                            </div>
                        </div> --}}
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
                    <form method="POST" action="{{ url('/donors/store') }}" class="browser-default-validation">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-3 ">
                                <label for="donor_id"
                                    class="form-label">{{ trans('donor.donor_id', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control" name="donorId" id="donorId" maxlength="10"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label for="donor_sym"
                                    class="form-label">{{ trans('donor.donor_sym', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    name="donorSym" id="donor_sym" maxlength="10" required>
                            </div>
                            <div class="col-md-6">
                                <label for="currency"
                                    class="form-label">{{ trans('donor.currency', [], session()->get('locale')) }}</label>
                                <select class="form-select  @error('email') is-invalid @enderror" name="currency"
                                    id="currency" required>
                                    <option value="LAK">LAK (Lao Kip)</option>
                                    <option value="USD">USD (United States Dollar)</option>
                                    <option value="THB">THB (Thai Bath)</option>
                                    <option value="CNY">CNY (China Yuan)</option>
                                    <option value="VND">VND (Vietnam Dong)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="donor_name_l"
                                    class="form-label">{{ trans('donor.donor_name_la', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    name="donorNameL" id="donorNameL" maxlength="80" required>
                            </div>
                            <div class="col-md-6">
                                <label for="donor_name_e"
                                    class="form-label">{{ trans('donor.donor_name_en', [], session()->get('locale')) }}</label>
                                <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                    name="donorNameE" id="donorNameE" maxlength="80" required>
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
            'data' => $donors,
            'headers' => [
                trans('donor.tb_title', [], session()->get('locale')),
                trans('donor.tb_name_la', [], session()->get('locale')),
                trans('donor.tb_name_en', [], session()->get('locale')),
                trans('donor.tb_currency', [], session()->get('locale')),
                trans('donor.tb_status', [], session()->get('locale')),
            ],
            'tableId' => 'donorTable',
            'displayKey' => ['DonorSym', 'DonorNameL', 'DonorNameE', 'CurrencyCD', 'Stoped'],
            'deleteRoute' => 'donors.destroy',
            'editRoute' => 'donors.index',
        ])
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {
            $('#BankModal').modal('hide');
        });

        // click edit button
        $('#edit').click(function() {
            $('#BankModal').modal('show');
        });
    </script>


@endsection
