<div class="col-md-3">
    <div class="form-group {{ $errors->has('ProvinceID') ? ' has-error' : '' }}">
        <label>ແຂວງເກີດ:</label>
        {!! Form::select(
            'ProvinceID',
            App\Models\provinceModel::orderBy('ProvinceID')->pluck('ProvinceNameL', 'ProvinceID'),
            $filterValue->ProvinceID ?? null,
            [
                'class' => 'form-select',
                'id' => 'ProvinceA',
                'placeholder' => '--ກະລຸນາເລືອກແຂວງ',
            ],
        ) !!}
        
        @if ($errors->has('ProvinceID'))
            <span class="help-block">
                <strong class="text-danger Sans-Cond-ot">{!! $errors->first('ProvinceID') !!}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-md-3">
    <div class="form-group {{ $errors->has('DistrictID') ? ' has-error' : '' }}">
        <label>ເມືອງເກີດ:</label>
       
        {!! Form::select(
            'DistrictID',
            App\Models\DistrictModel::join('KSProvinces', 'KSProvinces.ProvinceID', '=', 'KSDistricts.ProvinceID')->pluck(
                'DistrictNameL',
                'DistrictID',
            ),
            $filterValue->DistrictID ?? null,
            ['class' => 'form-select', 'id' => 'DistrictID', 'placeholder' => '--ກະລຸນາເລືອກເມືອງ'],
        ) !!}
        @if ($errors->has('DistrictID'))
            <span class="help-block">
                <strong class="text-danger Sans-Cond-ot">{!! $errors->first('dist_born') !!}</strong>
            </span>
        @endif
    </div>
</div>

