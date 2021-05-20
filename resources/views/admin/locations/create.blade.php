@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.location.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.locations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="location_code">{{ trans('cruds.location.fields.location_code') }}</label>
                <input class="form-control {{ $errors->has('location_code') ? 'is-invalid' : '' }}" type="text" name="location_code" id="location_code" value="{{ old('location_code', '') }}">
                @if($errors->has('location_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.location_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="location">{{ trans('cruds.location.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', '') }}" required>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('in_enable') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="in_enable" value="0">
                    <input class="form-check-input" type="checkbox" name="in_enable" id="in_enable" value="1" {{ old('in_enable', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="in_enable">{{ trans('cruds.location.fields.in_enable') }}</label>
                </div>
                @if($errors->has('in_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_enable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.in_enable_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.location.fields.project_code') }}</label>
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
                <span class="help-block">{{ trans('cruds.location.fields.project_code_helper') }}</span>
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