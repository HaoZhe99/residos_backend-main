@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.area.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.areas.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="country">{{ trans('cruds.area.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}" required>
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.area.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="states">{{ trans('cruds.area.fields.states') }}</label>
                <input class="form-control {{ $errors->has('states') ? 'is-invalid' : '' }}" type="text" name="states" id="states" value="{{ old('states', '') }}" required>
                @if($errors->has('states'))
                    <div class="invalid-feedback">
                        {{ $errors->first('states') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.area.fields.states_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="area">{{ trans('cruds.area.fields.area') }}</label>
                <input class="form-control {{ $errors->has('area') ? 'is-invalid' : '' }}" type="text" name="area" id="area" value="{{ old('area', '') }}" required>
                @if($errors->has('area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.area.fields.area_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="postcode">{{ trans('cruds.area.fields.postcode') }}</label>
                <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="number" name="postcode" id="postcode" value="{{ old('postcode', '') }}" step="1" required>
                @if($errors->has('postcode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('postcode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.area.fields.postcode_helper') }}</span>
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