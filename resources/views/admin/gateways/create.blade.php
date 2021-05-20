@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.gateway.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.gateways.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.gateway.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateway.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_active">{{ trans('cruds.gateway.fields.last_active') }}</label>
                <input class="form-control {{ $errors->has('last_active') ? 'is-invalid' : '' }}" type="text" name="last_active" id="last_active" value="{{ old('last_active', '') }}">
                @if($errors->has('last_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateway.fields.last_active_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('in_enable') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="in_enable" value="0">
                    <input class="form-check-input" type="checkbox" name="in_enable" id="in_enable" value="1" {{ old('in_enable', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="in_enable">{{ trans('cruds.gateway.fields.in_enable') }}</label>
                </div>
                @if($errors->has('in_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_enable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateway.fields.in_enable_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="guard">{{ trans('cruds.gateway.fields.guard') }}</label>
                <input class="form-control {{ $errors->has('guard') ? 'is-invalid' : '' }}" type="text" name="guard" id="guard" value="{{ old('guard', '') }}" required>
                @if($errors->has('guard'))
                    <div class="invalid-feedback">
                        {{ $errors->first('guard') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateway.fields.guard_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="location_code_id">{{ trans('cruds.gateway.fields.location_code') }}</label>
                <select class="form-control select2 {{ $errors->has('location_code') ? 'is-invalid' : '' }}" name="location_code_id" id="location_code_id">
                    @foreach($location_codes as $id => $location_code)
                        <option value="{{ $id }}" {{ old('location_code_id') == $id ? 'selected' : '' }}>{{ $location_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('location_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateway.fields.location_code_helper') }}</span>
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