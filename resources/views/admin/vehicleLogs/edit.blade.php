@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.vehicleLog.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vehicle-logs.update", [$vehicleLog->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="car_plate">{{ trans('cruds.vehicleLog.fields.car_plate') }}</label>
                <input class="form-control {{ $errors->has('car_plate') ? 'is-invalid' : '' }}" type="text" name="car_plate" id="car_plate" value="{{ old('car_plate', $vehicleLog->car_plate) }}">
                @if($errors->has('car_plate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('car_plate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleLog.fields.car_plate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="location_id">{{ trans('cruds.vehicleLog.fields.location') }}</label>
                <select class="form-control select2 {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location_id" id="location_id">
                    @foreach($locations as $id => $location)
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $vehicleLog->location->id ?? '') == $id ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleLog.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_in">{{ trans('cruds.vehicleLog.fields.time_in') }}</label>
                <input class="form-control {{ $errors->has('time_in') ? 'is-invalid' : '' }}" type="text" name="time_in" id="time_in" value="{{ old('time_in', $vehicleLog->time_in) }}">
                @if($errors->has('time_in'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_in') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleLog.fields.time_in_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_out">{{ trans('cruds.vehicleLog.fields.time_out') }}</label>
                <input class="form-control {{ $errors->has('time_out') ? 'is-invalid' : '' }}" type="text" name="time_out" id="time_out" value="{{ old('time_out', $vehicleLog->time_out) }}">
                @if($errors->has('time_out'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_out') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleLog.fields.time_out_helper') }}</span>
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