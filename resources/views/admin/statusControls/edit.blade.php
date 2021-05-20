@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.statusControl.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.status-controls.update", [$statusControl->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.statusControl.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $statusControl->status) }}" required>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.statusControl.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="desctiption">{{ trans('cruds.statusControl.fields.desctiption') }}</label>
                <input class="form-control {{ $errors->has('desctiption') ? 'is-invalid' : '' }}" type="text" name="desctiption" id="desctiption" value="{{ old('desctiption', $statusControl->desctiption) }}" required>
                @if($errors->has('desctiption'))
                    <div class="invalid-feedback">
                        {{ $errors->first('desctiption') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.statusControl.fields.desctiption_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('in_enable') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="in_enable" value="0">
                    <input class="form-check-input" type="checkbox" name="in_enable" id="in_enable" value="1" {{ $statusControl->in_enable || old('in_enable', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="in_enable">{{ trans('cruds.statusControl.fields.in_enable') }}</label>
                </div>
                @if($errors->has('in_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_enable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.statusControl.fields.in_enable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_code_id">{{ trans('cruds.statusControl.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id">
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ (old('project_code_id') ? old('project_code_id') : $statusControl->project_code->id ?? '') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.statusControl.fields.project_code_helper') }}</span>
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