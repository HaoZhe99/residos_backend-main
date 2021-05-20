@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.projectListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.project-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.id') }}
                        </th>
                        <td>
                            {{ $projectListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.project_code') }}
                        </th>
                        <td>
                            {{ $projectListing->project_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.name') }}
                        </th>
                        <td>
                            {{ $projectListing->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.type') }}
                        </th>
                        <td>
                            {{ $projectListing->type->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.address') }}
                        </th>
                        <td>
                            {{ $projectListing->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.developer') }}
                        </th>
                        <td>
                            {{ $projectListing->developer->company_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.tenure') }}
                        </th>
                        <td>
                            {{ App\Models\ProjectListing::TENURE_SELECT[$projectListing->tenure] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.completion_date') }}
                        </th>
                        <td>
                            {{ $projectListing->completion_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\ProjectListing::TYPE_SELECT[$projectListing->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.sales_gallery') }}
                        </th>
                        <td>
                            {{ $projectListing->sales_gallery }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.website') }}
                        </th>
                        <td>
                            {{ $projectListing->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.fb') }}
                        </th>
                        <td>
                            {{ $projectListing->fb }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.block') }}
                        </th>
                        <td>
                            {{ $projectListing->block }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.unit') }}
                        </th>
                        <td>
                            {{ $projectListing->unit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.is_new') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $projectListing->is_new ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.area') }}
                        </th>
                        <td>
                            {{ $projectListing->area->area ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.pic') }}
                        </th>
                        <td>
                            {{ $projectListing->pic->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.projectListing.fields.create_by') }}
                        </th>
                        <td>
                            {{ $projectListing->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.project-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection