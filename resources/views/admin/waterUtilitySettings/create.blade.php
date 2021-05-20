@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Water Utility Setting
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.water-utility-settings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="amount_per_consumption">amount_per_consumption</label>
                <input class="form-control {{ $errors->has('amount_per_consumption') ? 'is-invalid' : '' }}" type="number" name="amount_per_consumption" id="amount_per_consumption" value="{{ old('amount_per_consumption', '') }}" step="0.01" required>
                @if($errors->has('amount_per_consumption'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount_per_consumption') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilitySetting.fields.amount_per_consumption_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">Project Code</label>
                <select class="form-control select2 {{ $errors->has('unit_owner') ? 'is-invalid' : '' }}" name="project_id" id="project_code_id" required>
                    @foreach($project_code as $id => $project_code)
                        <option value="{{ $id }}" {{ old('project_code_id') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code_id') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.unit_owner_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection