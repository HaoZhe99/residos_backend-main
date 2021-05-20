@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.facilityBook.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.facility-books.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.facilityBook.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityBook.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="time">{{ trans('cruds.facilityBook.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time') }}" required>
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityBook.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.facilityBook.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}" required>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityBook.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="username_id">{{ trans('cruds.facilityBook.fields.username') }}</label>
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
                <span class="help-block">{{ trans('cruds.facilityBook.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.facilityBook.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id" required>
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ old('project_code_id') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.facilityBook.fields.project_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="facility_code_id">{{ trans('cruds.facilityBook.fields.facility_code') }}</label>
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
                <span class="help-block">{{ trans('cruds.facilityBook.fields.facility_code_helper') }}</span>
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