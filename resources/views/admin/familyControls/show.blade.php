@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show Family Control
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.family-controls.index') }}">
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
                            {{ $familyControl->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            family
                        </th>
                        <td>
                            {{ $familyControl->family->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            unit owner
                        </th>
                        <td>
                            {{ $familyControl->unit_owner->unit_owner ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            activity logs
                        </th>
                        <td>
                            {{ App\Models\FamilyControl::ACTIVITY_LOGS_SELECT[$familyControl->activity_logs] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            from family
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $familyControl->from_family ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.family-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection