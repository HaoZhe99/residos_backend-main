@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Payment Method
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payment-settings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="method">method</label>
                <input class="form-control {{ $errors->has('method') ? 'is-invalid' : '' }}" type="text" name="method" id="method" value="{{ old('method', '') }}" required>
                @if($errors->has('method'))
                    <div class="invalid-feedback">
                        {{ $errors->first('method') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.paymentMethod.fields.method_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="status">status</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}" required>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.paymentMethod.fields.status_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="description">description</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" required>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.paymentMethod.fields.description_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('in_enable') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="in_enable" value="0">
                    <input class="form-check-input" type="checkbox" name="in_enable" id="in_enable" value="1" {{ old('in_enable', 0) == 1 || old('in_enable') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="in_enable">In Enable</label>
                </div>
                @if($errors->has('in_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_enable') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.paymentMethod.fields.in_enable_helper') }}</span> --}}
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