@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.vehicleModel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vehicle-models.update", [$vehicleModel->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="brand_id">{{ trans('cruds.vehicleModel.fields.brand') }}</label>
                <select class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}" name="brand_id" id="brand_id" required>
                    @foreach($brands as $id => $brand)
                        <option value="{{ $id }}" {{ (old('brand_id') ? old('brand_id') : $vehicleModel->brand->id ?? '') == $id ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
                @if($errors->has('brand'))
                    <div class="invalid-feedback">
                        {{ $errors->first('brand') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.brand_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="model">{{ trans('cruds.vehicleModel.fields.model') }}</label>
                <input class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" type="text" name="model" id="model" value="{{ old('model', $vehicleModel->model) }}" required>
                @if($errors->has('model'))
                    <div class="invalid-feedback">
                        {{ $errors->first('model') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.model_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_enable') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_enable" value="0">
                    <input class="form-check-input" type="checkbox" name="is_enable" id="is_enable" value="1" {{ $vehicleModel->is_enable || old('is_enable', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_enable">{{ trans('cruds.vehicleModel.fields.is_enable') }}</label>
                </div>
                @if($errors->has('is_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_enable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.is_enable_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.vehicleModel.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VehicleModel::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $vehicleModel->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="color">{{ trans('cruds.vehicleModel.fields.color') }}</label>
                <input class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" type="text" name="color" id="color" value="{{ old('color', $vehicleModel->color) }}">
                @if($errors->has('color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('color') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="variant">{{ trans('cruds.vehicleModel.fields.variant') }}</label>
                <input class="form-control {{ $errors->has('variant') ? 'is-invalid' : '' }}" type="text" name="variant" id="variant" value="{{ old('variant', $vehicleModel->variant) }}">
                @if($errors->has('variant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('variant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.variant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="series">{{ trans('cruds.vehicleModel.fields.series') }}</label>
                <input class="form-control {{ $errors->has('series') ? 'is-invalid' : '' }}" type="text" name="series" id="series" value="{{ old('series', $vehicleModel->series) }}">
                @if($errors->has('series'))
                    <div class="invalid-feedback">
                        {{ $errors->first('series') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.series_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="release_year">{{ trans('cruds.vehicleModel.fields.release_year') }}</label>
                <input class="form-control {{ $errors->has('release_year') ? 'is-invalid' : '' }}" type="text" name="release_year" id="release_year" value="{{ old('release_year', $vehicleModel->release_year) }}">
                @if($errors->has('release_year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('release_year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.release_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="seat_capacity">{{ trans('cruds.vehicleModel.fields.seat_capacity') }}</label>
                <input class="form-control {{ $errors->has('seat_capacity') ? 'is-invalid' : '' }}" type="number" name="seat_capacity" id="seat_capacity" value="{{ old('seat_capacity', $vehicleModel->seat_capacity) }}" step="1">
                @if($errors->has('seat_capacity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seat_capacity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.seat_capacity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="length">{{ trans('cruds.vehicleModel.fields.length') }}</label>
                <input class="form-control {{ $errors->has('length') ? 'is-invalid' : '' }}" type="text" name="length" id="length" value="{{ old('length', $vehicleModel->length) }}">
                @if($errors->has('length'))
                    <div class="invalid-feedback">
                        {{ $errors->first('length') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.length_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="width">{{ trans('cruds.vehicleModel.fields.width') }}</label>
                <input class="form-control {{ $errors->has('width') ? 'is-invalid' : '' }}" type="text" name="width" id="width" value="{{ old('width', $vehicleModel->width) }}">
                @if($errors->has('width'))
                    <div class="invalid-feedback">
                        {{ $errors->first('width') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.width_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="height">{{ trans('cruds.vehicleModel.fields.height') }}</label>
                <input class="form-control {{ $errors->has('height') ? 'is-invalid' : '' }}" type="text" name="height" id="height" value="{{ old('height', $vehicleModel->height) }}">
                @if($errors->has('height'))
                    <div class="invalid-feedback">
                        {{ $errors->first('height') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.height_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="wheel_base">{{ trans('cruds.vehicleModel.fields.wheel_base') }}</label>
                <input class="form-control {{ $errors->has('wheel_base') ? 'is-invalid' : '' }}" type="text" name="wheel_base" id="wheel_base" value="{{ old('wheel_base', $vehicleModel->wheel_base) }}">
                @if($errors->has('wheel_base'))
                    <div class="invalid-feedback">
                        {{ $errors->first('wheel_base') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.wheel_base_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="kerb_weight">{{ trans('cruds.vehicleModel.fields.kerb_weight') }}</label>
                <input class="form-control {{ $errors->has('kerb_weight') ? 'is-invalid' : '' }}" type="text" name="kerb_weight" id="kerb_weight" value="{{ old('kerb_weight', $vehicleModel->kerb_weight) }}">
                @if($errors->has('kerb_weight'))
                    <div class="invalid-feedback">
                        {{ $errors->first('kerb_weight') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.kerb_weight_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fuel_tank">{{ trans('cruds.vehicleModel.fields.fuel_tank') }}</label>
                <input class="form-control {{ $errors->has('fuel_tank') ? 'is-invalid' : '' }}" type="text" name="fuel_tank" id="fuel_tank" value="{{ old('fuel_tank', $vehicleModel->fuel_tank) }}">
                @if($errors->has('fuel_tank'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fuel_tank') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.fuel_tank_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="front_brake">{{ trans('cruds.vehicleModel.fields.front_brake') }}</label>
                <input class="form-control {{ $errors->has('front_brake') ? 'is-invalid' : '' }}" type="text" name="front_brake" id="front_brake" value="{{ old('front_brake', $vehicleModel->front_brake) }}">
                @if($errors->has('front_brake'))
                    <div class="invalid-feedback">
                        {{ $errors->first('front_brake') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.front_brake_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rear_brake">{{ trans('cruds.vehicleModel.fields.rear_brake') }}</label>
                <input class="form-control {{ $errors->has('rear_brake') ? 'is-invalid' : '' }}" type="text" name="rear_brake" id="rear_brake" value="{{ old('rear_brake', $vehicleModel->rear_brake) }}">
                @if($errors->has('rear_brake'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rear_brake') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.rear_brake_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="front_suspension">{{ trans('cruds.vehicleModel.fields.front_suspension') }}</label>
                <input class="form-control {{ $errors->has('front_suspension') ? 'is-invalid' : '' }}" type="text" name="front_suspension" id="front_suspension" value="{{ old('front_suspension', $vehicleModel->front_suspension) }}">
                @if($errors->has('front_suspension'))
                    <div class="invalid-feedback">
                        {{ $errors->first('front_suspension') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.front_suspension_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rear_suspension">{{ trans('cruds.vehicleModel.fields.rear_suspension') }}</label>
                <input class="form-control {{ $errors->has('rear_suspension') ? 'is-invalid' : '' }}" type="text" name="rear_suspension" id="rear_suspension" value="{{ old('rear_suspension', $vehicleModel->rear_suspension) }}">
                @if($errors->has('rear_suspension'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rear_suspension') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.rear_suspension_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="steering">{{ trans('cruds.vehicleModel.fields.steering') }}</label>
                <input class="form-control {{ $errors->has('steering') ? 'is-invalid' : '' }}" type="text" name="steering" id="steering" value="{{ old('steering', $vehicleModel->steering) }}">
                @if($errors->has('steering'))
                    <div class="invalid-feedback">
                        {{ $errors->first('steering') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.steering_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="engine_cc">{{ trans('cruds.vehicleModel.fields.engine_cc') }}</label>
                <input class="form-control {{ $errors->has('engine_cc') ? 'is-invalid' : '' }}" type="text" name="engine_cc" id="engine_cc" value="{{ old('engine_cc', $vehicleModel->engine_cc) }}">
                @if($errors->has('engine_cc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('engine_cc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.engine_cc_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compression_ratio">{{ trans('cruds.vehicleModel.fields.compression_ratio') }}</label>
                <input class="form-control {{ $errors->has('compression_ratio') ? 'is-invalid' : '' }}" type="text" name="compression_ratio" id="compression_ratio" value="{{ old('compression_ratio', $vehicleModel->compression_ratio) }}">
                @if($errors->has('compression_ratio'))
                    <div class="invalid-feedback">
                        {{ $errors->first('compression_ratio') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.compression_ratio_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peak_power_bhp">{{ trans('cruds.vehicleModel.fields.peak_power_bhp') }}</label>
                <input class="form-control {{ $errors->has('peak_power_bhp') ? 'is-invalid' : '' }}" type="text" name="peak_power_bhp" id="peak_power_bhp" value="{{ old('peak_power_bhp', $vehicleModel->peak_power_bhp) }}">
                @if($errors->has('peak_power_bhp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peak_power_bhp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.peak_power_bhp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="peak_torque_nm">{{ trans('cruds.vehicleModel.fields.peak_torque_nm') }}</label>
                <input class="form-control {{ $errors->has('peak_torque_nm') ? 'is-invalid' : '' }}" type="text" name="peak_torque_nm" id="peak_torque_nm" value="{{ old('peak_torque_nm', $vehicleModel->peak_torque_nm) }}">
                @if($errors->has('peak_torque_nm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('peak_torque_nm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.peak_torque_nm_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="engine_type">{{ trans('cruds.vehicleModel.fields.engine_type') }}</label>
                <input class="form-control {{ $errors->has('engine_type') ? 'is-invalid' : '' }}" type="text" name="engine_type" id="engine_type" value="{{ old('engine_type', $vehicleModel->engine_type) }}">
                @if($errors->has('engine_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('engine_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.engine_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fuel_type">{{ trans('cruds.vehicleModel.fields.fuel_type') }}</label>
                <input class="form-control {{ $errors->has('fuel_type') ? 'is-invalid' : '' }}" type="text" name="fuel_type" id="fuel_type" value="{{ old('fuel_type', $vehicleModel->fuel_type) }}">
                @if($errors->has('fuel_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fuel_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.fuel_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="driven_wheel_drive">{{ trans('cruds.vehicleModel.fields.driven_wheel_drive') }}</label>
                <input class="form-control {{ $errors->has('driven_wheel_drive') ? 'is-invalid' : '' }}" type="text" name="driven_wheel_drive" id="driven_wheel_drive" value="{{ old('driven_wheel_drive', $vehicleModel->driven_wheel_drive) }}">
                @if($errors->has('driven_wheel_drive'))
                    <div class="invalid-feedback">
                        {{ $errors->first('driven_wheel_drive') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleModel.fields.driven_wheel_drive_helper') }}</span>
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