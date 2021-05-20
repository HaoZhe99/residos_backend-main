@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Water Utility Setting
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.water-utility-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.waterUtilitySetting.fields.id') }}
                        </th>
                        <td>
                            {{ $waterUtilitySetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            amount_per_consumption
                        </th>
                        <td>
                            {{ $waterUtilitySetting->amount_per_consumption }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Project Code
                        </th>
                        <td>
                            {{ $waterUtilitySetting->project_code->project_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.water-utility-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection