@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.qr.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.qrs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.id') }}
                        </th>
                        <td>
                            {{ $qr->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.code') }}
                        </th>
                        <td>
                            {{ $qr->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.status') }}
                        </th>
                        <td>
                            {{ $qr->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.type') }}
                        </th>
                        <td>
                            {{ $qr->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.expired_at') }}
                        </th>
                        <td>
                            {{ $qr->expired_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.username') }}
                        </th>
                        <td>
                            {{ $qr->username->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.project_code') }}
                        </th>
                        <td>
                            {{ $qr->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.qr.fields.unit_owner') }}
                        </th>
                        <td>
                            {{ $qr->unit_owner }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.qrs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection