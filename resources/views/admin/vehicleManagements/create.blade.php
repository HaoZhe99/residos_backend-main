@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.vehicleManagement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vehicle-managements.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="car_plate">{{ trans('cruds.vehicleManagement.fields.car_plate') }}</label>
                <input class="form-control {{ $errors->has('car_plate') ? 'is-invalid' : '' }}" type="text" name="car_plate" id="car_plate" value="{{ old('car_plate', '') }}" required>
                @if($errors->has('car_plate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('car_plate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.car_plate_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_verify') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_verify" value="0">
                    <input class="form-check-input" type="checkbox" name="x" id="is_verify" value="1" {{ old('is_verify', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_verify">{{ trans('cruds.vehicleManagement.fields.is_verify') }}</label>
                </div>
                @if($errors->has('is_verify'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_verify') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.is_verify_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_season_park') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_season_park" value="0">
                    <input class="form-check-input" type="checkbox" name="is_season_park" id="is_season_park" value="1" {{ old('is_season_park', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_season_park">{{ trans('cruds.vehicleManagement.fields.is_season_park') }}</label>
                </div>
                @if($errors->has('is_season_park'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_season_park') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.is_season_park_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_resident') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_resident" value="0">
                    <input class="form-check-input" type="checkbox" name="is_resident" id="is_resident" value="1" {{ old('is_resident', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_resident">{{ trans('cruds.vehicleManagement.fields.is_resident') }}</label>
                </div>
                @if($errors->has('is_resident'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_resident') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.is_resident_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="color">{{ trans('cruds.vehicleManagement.fields.color') }}</label>
                <input class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" type="text" name="color" id="color" value="{{ old('color', '') }}">
                @if($errors->has('color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('color') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="driver">{{ trans('cruds.vehicleManagement.fields.driver') }}</label>
                <input class="form-control {{ $errors->has('driver') ? 'is-invalid' : '' }}" type="text" name="driver" id="driver" value="{{ old('driver', '') }}">
                @if($errors->has('driver'))
                    <div class="invalid-feedback">
                        {{ $errors->first('driver') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.driver_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.vehicleManagement.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="carpark_location_id">{{ trans('cruds.vehicleManagement.fields.carpark_location') }}</label>
                <select class="form-control select2 {{ $errors->has('carpark_location') ? 'is-invalid' : '' }}" name="carpark_location_id" id="carpark_location_id">
                    @foreach($carpark_locations as $id => $carpark_location)
                        <option value="{{ $id }}" {{ old('carpark_location_id') == $id ? 'selected' : '' }}>{{ $carpark_location }}</option>
                    @endforeach
                </select>
                @if($errors->has('carpark_location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('carpark_location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.carpark_location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select class="form-control select2 {{ $errors->has('brand_id') ? 'is-invalid' : '' }}" name="brand_id" id="brand_id">
                    @foreach($brands as $id => $brand)
                        <option value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
                @if($errors->has('brand_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('brand_id') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.vehicleManagement.fields.model_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="model_id">{{ trans('cruds.vehicleManagement.fields.model') }}</label>
                <select class="form-control select2 {{ $errors->has('model') ? 'is-invalid' : '' }}" name="model_id" id="model_id">
                    @foreach($models as $id => $model)
                        <option value="{{ $id }}" {{ old('model_id') == $id ? 'selected' : '' }}>{{ $model }}</option>
                    @endforeach
                </select>
                @if($errors->has('model'))
                    <div class="invalid-feedback">
                        {{ $errors->first('model') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleManagement.fields.model_helper') }}</span>
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