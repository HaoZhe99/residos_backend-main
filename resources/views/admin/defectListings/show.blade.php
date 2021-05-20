@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.defectListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.defect-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.id') }}
                        </th>
                        <td>
                            {{ $defectListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.case_code') }}
                        </th>
                        <td>
                            {{ $defectListing->case_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.category') }}
                        </th>
                        <td>
                            {{ $defectListing->category->defect_cateogry ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.description') }}
                        </th>
                        <td>
                            {{ $defectListing->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.image') }}
                        </th>
                        <td>
                            @foreach($defectListing->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.date') }}
                        </th>
                        <td>
                            {{ $defectListing->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.time') }}
                        </th>
                        <td>
                            {{ $defectListing->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.remark') }}
                        </th>
                        <td>
                            {{ $defectListing->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.incharge_person') }}
                        </th>
                        <td>
                            {{ $defectListing->incharge_person }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.contractor') }}
                        </th>
                        <td>
                            {{ $defectListing->contractor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.status_control') }}
                        </th>
                        <td>
                            {{ $defectListing->status_control->status ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.defectListing.fields.project_code') }}
                        </th>
                        <td>
                            {{ $defectListing->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.defect-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection