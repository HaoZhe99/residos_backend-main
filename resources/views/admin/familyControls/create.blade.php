@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Family Control
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.family-controls.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="family_id">family</label>
                <select class="form-control select2 {{ $errors->has('family') ? 'is-invalid' : '' }}" name="family_id" id="family_id" required>
                    @foreach($families as $id => $family)
                        <option value="{{ $id }}" {{ old('family_id') == $id ? 'selected' : '' }}>{{ $family }}</option>
                    @endforeach
                </select>
                @if($errors->has('family'))
                    <div class="invalid-feedback">
                        {{ $errors->first('family') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.familyControl.fields.family_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="unit_owner_id">unit owner</label>
                <select class="form-control select2 {{ $errors->has('unit_owner') ? 'is-invalid' : '' }}" name="unit_owner_id" id="unit_owner_id" required>
                    @foreach($unit_owners as $id => $unit_owner)
                        <option value="{{ $id }}" {{ old('unit_owner_id') == $id ? 'selected' : '' }}>{{ $unit_owner }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit_owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_owner') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.familyControl.fields.unit_owner_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required">activity logs</label>
                <select class="form-control {{ $errors->has('activity_logs') ? 'is-invalid' : '' }}" name="activity_logs" id="activity_logs" required>
                    <option value disabled {{ old('activity_logs', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FamilyControl::ACTIVITY_LOGS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('activity_logs', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('activity_logs'))
                    <div class="invalid-feedback">
                        {{ $errors->first('activity_logs') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.familyControl.fields.activity_logs_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('from_family') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="from_family" value="0">
                    <input class="form-check-input" type="checkbox" name="from_family" id="from_family" value="1" {{ old('from_family', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="from_family">from family</label>
                </div>
                @if($errors->has('from_family'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from_family') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.familyControl.fields.from_family_helper') }}</span> --}}
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