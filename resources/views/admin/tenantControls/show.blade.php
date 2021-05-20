@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Show Tenant
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tenant-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $tenantControl->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            tenant
                        </th>
                        <td>
                            {{ $tenantControl->tenant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            unit
                        </th>
                        <td>
                            {{ $tenantControl->rent->unit_owner->unit_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            status
                        </th>
                        <td>
                            {{ App\Models\TenantControl::STATUS_SELECT[$tenantControl->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tenant-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection