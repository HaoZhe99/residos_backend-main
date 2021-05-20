@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.facilityBook.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.facility-books.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.id') }}
                        </th>
                        <td>
                            {{ $facilityBook->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.date') }}
                        </th>
                        <td>
                            {{ $facilityBook->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.time') }}
                        </th>
                        <td>
                            {{ $facilityBook->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.status') }}
                        </th>
                        <td>
                            {{ $facilityBook->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.username') }}
                        </th>
                        <td>
                            {{ $facilityBook->username->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.project_code') }}
                        </th>
                        <td>
                            {{ $facilityBook->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityBook.fields.facility_code') }}
                        </th>
                        <td>
                            {{ $facilityBook->facility_code->facility_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.facility-books.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection