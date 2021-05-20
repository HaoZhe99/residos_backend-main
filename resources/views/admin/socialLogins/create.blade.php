@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.socialLogin.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.social-logins.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.socialLogin.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialLogin.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.socialLogin.fields.user_id') }}</label>
                <input class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" type="text" name="user_id" id="user_id" value="{{ old('user_id', '') }}">
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialLogin.fields.user_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="secret">{{ trans('cruds.socialLogin.fields.secret') }}</label>
                <input class="form-control {{ $errors->has('secret') ? 'is-invalid' : '' }}" type="text" name="secret" id="secret" value="{{ old('secret', '') }}">
                @if($errors->has('secret'))
                    <div class="invalid-feedback">
                        {{ $errors->first('secret') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialLogin.fields.secret_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="redirect">{{ trans('cruds.socialLogin.fields.redirect') }}</label>
                <input class="form-control {{ $errors->has('redirect') ? 'is-invalid' : '' }}" type="text" name="redirect" id="redirect" value="{{ old('redirect', '') }}">
                @if($errors->has('redirect'))
                    <div class="invalid-feedback">
                        {{ $errors->first('redirect') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialLogin.fields.redirect_helper') }}</span>
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