@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carparklocation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.carparklocations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carparklocation.fields.id') }}
                        </th>
                        <td>
                            {{ $carparklocation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carparklocation.fields.location') }}
                        </th>
                        <td>
                            {{ $carparklocation->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carparklocation.fields.is_enable') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $carparklocation->is_enable ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carparklocation.fields.location_code') }}
                        </th>
                        <td>
                            {{ $carparklocation->location_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carparklocation.fields.project_code') }}
                        </th>
                        <td>
                            {{ $carparklocation->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.carparklocations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection