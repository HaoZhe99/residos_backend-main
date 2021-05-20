@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.visitorControl.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.visitor-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorControl.fields.id') }}
                        </th>
                        <td>
                            {{ $visitorControl->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorControl.fields.username') }}
                        </th>
                        <td>
                            {{ $visitorControl->username->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorControl.fields.add_by') }}
                        </th>
                        <td>
                            {{ $visitorControl->add_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorControl.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\VisitorControl::STATUS_SELECT[$visitorControl->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visitorControl.fields.favourite') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $visitorControl->favourite ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.visitor-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection