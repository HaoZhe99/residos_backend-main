@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.advanceSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.advance-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.advanceSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $advanceSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advanceSetting.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\AdvanceSetting::TYPE_SELECT[$advanceSetting->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advanceSetting.fields.key') }}
                        </th>
                        <td>
                            {{ $advanceSetting->key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advanceSetting.fields.status') }}
                        </th>
                        <td>
                            {{ $advanceSetting->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advanceSetting.fields.project_code') }}
                        </th>
                        <td>
                            {{ $advanceSetting->project_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advanceSetting.fields.amount') }}
                        </th>
                        <td>
                            {{ $advanceSetting->amount }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.advance-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection