@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.statusControl.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.status-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.statusControl.fields.id') }}
                        </th>
                        <td>
                            {{ $statusControl->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.statusControl.fields.status') }}
                        </th>
                        <td>
                            {{ $statusControl->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.statusControl.fields.desctiption') }}
                        </th>
                        <td>
                            {{ $statusControl->desctiption }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.statusControl.fields.in_enable') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $statusControl->in_enable ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.statusControl.fields.project_code') }}
                        </th>
                        <td>
                            {{ $statusControl->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.status-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection