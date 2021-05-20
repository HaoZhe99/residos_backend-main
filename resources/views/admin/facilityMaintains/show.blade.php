@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.facilityMaintain.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.facility-maintains.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityMaintain.fields.id') }}
                        </th>
                        <td>
                            {{ $facilityMaintain->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityMaintain.fields.remark') }}
                        </th>
                        <td>
                            {{ $facilityMaintain->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityMaintain.fields.username') }}
                        </th>
                        <td>
                            {{ $facilityMaintain->username->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityMaintain.fields.facility_code') }}
                        </th>
                        <td>
                            {{ $facilityMaintain->facility_code->facility_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.facility-maintains.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection