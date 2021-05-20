@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vehicleModel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-models.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.id') }}
                        </th>
                        <td>
                            {{ $vehicleModel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.brand') }}
                        </th>
                        <td>
                            {{ $vehicleModel->brand->brand ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.model') }}
                        </th>
                        <td>
                            {{ $vehicleModel->model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.is_enable') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vehicleModel->is_enable ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\VehicleModel::TYPE_SELECT[$vehicleModel->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.color') }}
                        </th>
                        <td>
                            {{ $vehicleModel->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.variant') }}
                        </th>
                        <td>
                            {{ $vehicleModel->variant }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.series') }}
                        </th>
                        <td>
                            {{ $vehicleModel->series }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.release_year') }}
                        </th>
                        <td>
                            {{ $vehicleModel->release_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.seat_capacity') }}
                        </th>
                        <td>
                            {{ $vehicleModel->seat_capacity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.length') }}
                        </th>
                        <td>
                            {{ $vehicleModel->length }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.width') }}
                        </th>
                        <td>
                            {{ $vehicleModel->width }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.height') }}
                        </th>
                        <td>
                            {{ $vehicleModel->height }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.wheel_base') }}
                        </th>
                        <td>
                            {{ $vehicleModel->wheel_base }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.kerb_weight') }}
                        </th>
                        <td>
                            {{ $vehicleModel->kerb_weight }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.fuel_tank') }}
                        </th>
                        <td>
                            {{ $vehicleModel->fuel_tank }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.front_brake') }}
                        </th>
                        <td>
                            {{ $vehicleModel->front_brake }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.rear_brake') }}
                        </th>
                        <td>
                            {{ $vehicleModel->rear_brake }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.front_suspension') }}
                        </th>
                        <td>
                            {{ $vehicleModel->front_suspension }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.rear_suspension') }}
                        </th>
                        <td>
                            {{ $vehicleModel->rear_suspension }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.steering') }}
                        </th>
                        <td>
                            {{ $vehicleModel->steering }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.engine_cc') }}
                        </th>
                        <td>
                            {{ $vehicleModel->engine_cc }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.compression_ratio') }}
                        </th>
                        <td>
                            {{ $vehicleModel->compression_ratio }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.peak_power_bhp') }}
                        </th>
                        <td>
                            {{ $vehicleModel->peak_power_bhp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.peak_torque_nm') }}
                        </th>
                        <td>
                            {{ $vehicleModel->peak_torque_nm }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.engine_type') }}
                        </th>
                        <td>
                            {{ $vehicleModel->engine_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.fuel_type') }}
                        </th>
                        <td>
                            {{ $vehicleModel->fuel_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleModel.fields.driven_wheel_drive') }}
                        </th>
                        <td>
                            {{ $vehicleModel->driven_wheel_drive }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-models.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection