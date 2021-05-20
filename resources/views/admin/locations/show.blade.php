@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.location.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.locations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.id') }}
                        </th>
                        <td>
                            {{ $location->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.location_code') }}
                        </th>
                        <td>
                            {{ $location->location_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.location') }}
                        </th>
                        <td>
                            {{ $location->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.in_enable') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $location->in_enable ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.location.fields.project_code') }}
                        </th>
                        <td>
                            {{ $location->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.locations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection