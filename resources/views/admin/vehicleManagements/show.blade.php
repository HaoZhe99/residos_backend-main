@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vehicleManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.car_plate') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->car_plate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.is_verify') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vehicleManagement->is_verify ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.is_season_park') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vehicleManagement->is_season_park ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.is_resident') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $vehicleManagement->is_resident ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.color') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.driver') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->driver }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.user') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.carpark_location') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->carpark_location->location ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Brand
                        </th>
                        <td>
                            {{ $vehicleManagement->brand->brand ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleManagement.fields.model') }}
                        </th>
                        <td>
                            {{ $vehicleManagement->model->model ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection