@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.facilityMaintain.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.facility-maintains.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="remark">{{ trans('cruds.facilityMaintain.fields.remark') }}</label>
                <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark">{{ old('remark') }}</textarea>
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityMaintain.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="username_id">{{ trans('cruds.facilityMaintain.fields.username') }}</label>
                <select class="form-control select2 {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username_id" id="username_id" required>
                    @foreach($usernames as $id => $username)
                        <option value="{{ $id }}" {{ old('username_id') == $id ? 'selected' : '' }}>{{ $username }}</option>
                    @endforeach
                </select>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityMaintain.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="facility_code_id">{{ trans('cruds.facilityMaintain.fields.facility_code') }}</label>
                <select class="form-control select2 {{ $errors->has('facility_code') ? 'is-invalid' : '' }}" name="facility_code_id" id="facility_code_id" required>
                    @foreach($facility_codes as $id => $facility_code)
                        <option value="{{ $id }}" {{ old('facility_code_id') == $id ? 'selected' : '' }}>{{ $facility_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('facility_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facility_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityMaintain.fields.facility_code_helper') }}</span>
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