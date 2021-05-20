@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bankName.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bank-names.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="country">{{ trans('cruds.bankName.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}" required>
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankName.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bank_name">{{ trans('cruds.bankName.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', '') }}" required>
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankName.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="swift_code">{{ trans('cruds.bankName.fields.swift_code') }}</label>
                <input class="form-control {{ $errors->has('swift_code') ? 'is-invalid' : '' }}" type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', '') }}">
                @if($errors->has('swift_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('swift_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankName.fields.swift_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_code">{{ trans('cruds.bankName.fields.bank_code') }}</label>
                <input class="form-control {{ $errors->has('bank_code') ? 'is-invalid' : '' }}" type="text" name="bank_code" id="bank_code" value="{{ old('bank_code', '') }}">
                @if($errors->has('bank_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankName.fields.bank_code_helper') }}</span>
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