@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.smsSetting.title') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sms-settings.update", [$sms_setting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="username">{{ trans('cruds.smsSetting.fields.username') }}</label>
                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', $sms_setting->username) }}" required>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.smsSetting.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="secret_key">{{ trans('cruds.smsSetting.fields.secret_key') }}</label>
                <input class="form-control {{ $errors->has('secret_key') ? 'is-invalid' : '' }}" type="text" name="secret_key" id="secret_key" value="{{ old('secret_key', $sms_setting->secret_key) }}" required>
                @if($errors->has('secret_key'))
                    <div class="invalid-feedback">
                        {{ $errors->first('secret_key') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.smsSetting.fields.secret_key_helper') }}</span>
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