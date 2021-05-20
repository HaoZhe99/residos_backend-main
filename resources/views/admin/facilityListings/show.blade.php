@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.facilityListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.facility-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.id') }}
                        </th>
                        <td>
                            {{ $facilityListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.facility_code') }}
                        </th>
                        <td>
                            {{ $facilityListing->facility_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.name') }}
                        </th>
                        <td>
                            {{ $facilityListing->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.desctiption') }}
                        </th>
                        <td>
                            {!! $facilityListing->desctiption !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.image') }}
                        </th>
                        <td>
                            @if($facilityListing->image)
                                <a href="{{ $facilityListing->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $facilityListing->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\FacilityListing::STATUS_SELECT[$facilityListing->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.open') }}
                        </th>
                        <td>
                            {{ $facilityListing->open }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.closed') }}
                        </th>
                        <td>
                            {{ $facilityListing->closed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.category') }}
                        </th>
                        <td>
                            {{ $facilityListing->category->category ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.facilityListing.fields.project_code') }}
                        </th>
                        <td>
                            {{ $facilityListing->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.facility-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection