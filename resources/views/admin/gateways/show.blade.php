@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.gateway.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gateways.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.gateway.fields.id') }}
                        </th>
                        <td>
                            {{ $gateway->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateway.fields.name') }}
                        </th>
                        <td>
                            {{ $gateway->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateway.fields.last_active') }}
                        </th>
                        <td>
                            {{ $gateway->last_active }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateway.fields.in_enable') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $gateway->in_enable ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateway.fields.guard') }}
                        </th>
                        <td>
                            {{ $gateway->guard }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateway.fields.location_code') }}
                        </th>
                        <td>
                            {{ $gateway->location_code->location_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gateways.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection