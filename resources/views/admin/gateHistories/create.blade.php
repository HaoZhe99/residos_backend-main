@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.gateHistory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.gate-histories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="gate_code">{{ trans('cruds.gateHistory.fields.gate_code') }}</label>
                <input class="form-control {{ $errors->has('gate_code') ? 'is-invalid' : '' }}" type="text" name="gate_code" id="gate_code" value="{{ old('gate_code', '') }}" required>
                @if($errors->has('gate_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateHistory.fields.gate_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.gateHistory.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateHistory.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="username_id">{{ trans('cruds.gateHistory.fields.username') }}</label>
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
                <span class="help-block">{{ trans('cruds.gateHistory.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gateway_id">gateway</label>
                <select class="form-control select2 {{ $errors->has('gateway') ? 'is-invalid' : '' }}" name="gateway_id" id="gateway_id" required>
                    @foreach($gateways as $id => $gateway)
                        <option value="{{ $id }}" {{ old('gateway_id') == $id ? 'selected' : '' }}>{{ $gateway }}</option>
                    @endforeach
                </select>
                @if($errors->has('gateway'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gateway') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.history.fields.gateway_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="qr_id">Qr</label>
                <select class="form-control select2 {{ $errors->has('qr') ? 'is-invalid' : '' }}" name="qr_id" id="qr_id">
                    @foreach($qrs as $id => $qr)
                        <option value="{{ $id }}" {{ old('qr_id') == $id ? 'selected' : '' }}>{{ $qr }}</option>
                    @endforeach
                </select>
                @if($errors->has('qr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qr') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.history.fields.qr_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id">
                    @foreach($units as $id => $unit)
                        <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>{{ $unit }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.history.fields.unit_helper') }}</span> --}}
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