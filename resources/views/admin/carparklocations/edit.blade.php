@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.carparklocation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.carparklocations.update", [$carparklocation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="location">{{ trans('cruds.carparklocation.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', $carparklocation->location) }}" required>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carparklocation.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_enable') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_enable" value="0">
                    <input class="form-check-input" type="checkbox" name="is_enable" id="is_enable" value="1" {{ $carparklocation->is_enable || old('is_enable', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_enable">{{ trans('cruds.carparklocation.fields.is_enable') }}</label>
                </div>
                @if($errors->has('is_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_enable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carparklocation.fields.is_enable_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="location_code">{{ trans('cruds.carparklocation.fields.location_code') }}</label>
                <input class="form-control {{ $errors->has('location_code') ? 'is-invalid' : '' }}" type="text" name="location_code" id="location_code" value="{{ old('location_code', $carparklocation->location_code) }}" required>
                @if($errors->has('location_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carparklocation.fields.location_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_code_id">{{ trans('cruds.carparklocation.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id">
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ (old('project_code_id') ? old('project_code_id') : $carparklocation->project_code->id ?? '') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carparklocation.fields.project_code_helper') }}</span>
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