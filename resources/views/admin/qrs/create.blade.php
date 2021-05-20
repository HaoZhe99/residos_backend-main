@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.qr.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.qrs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.qr.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.qr.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.qr.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}" required>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.qr.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="type">{{ trans('cruds.qr.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}">
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.qr.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="expired_at">{{ trans('cruds.qr.fields.expired_at') }}</label>
                <input class="form-control datetime {{ $errors->has('expired_at') ? 'is-invalid' : '' }}" type="text" name="expired_at" id="expired_at" value="{{ old('expired_at') }}" required>
                @if($errors->has('expired_at'))
                    <div class="invalid-feedback">
                        {{ $errors->first('expired_at') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.qr.fields.expired_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="username_id">{{ trans('cruds.qr.fields.username') }}</label>
                <select class="form-control select2 {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username_id" id="username_id">
                    @foreach($usernames as $id => $username)
                        <option value="{{ $id }}" {{ old('username_id') == $id ? 'selected' : '' }}>{{ $username }}</option>
                    @endforeach
                </select>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.qr.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.qr.fields.project_code') }}</label>
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
                <span class="help-block">{{ trans('cruds.qr.fields.project_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_owner_id">{{ trans('cruds.qr.fields.unit_owner') }}</label>
                <select class="form-control select2 {{ $errors->has('unit_owner') ? 'is-invalid' : '' }}" name="unit_owner_id" id="unit_owner_id">
                    @foreach($unit_owners as $id => $unit_owner)
                        <option value="{{ $id }}" {{ old('unit_owner_id') == $id ? 'selected' : '' }}>{{ $unit_owner }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit_owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_owner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.qr.fields.unit_owner_helper') }}</span>
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