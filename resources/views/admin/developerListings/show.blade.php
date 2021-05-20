@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.developerListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.developer-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.id') }}
                        </th>
                        <td>
                            {{ $developerListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.company_name') }}
                        </th>
                        <td>
                            {{ $developerListing->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.contact') }}
                        </th>
                        <td>
                            {{ $developerListing->contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.address') }}
                        </th>
                        <td>
                            {{ $developerListing->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.email') }}
                        </th>
                        <td>
                            {{ $developerListing->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.website') }}
                        </th>
                        <td>
                            {{ $developerListing->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.fb') }}
                        </th>
                        <td>
                            {{ $developerListing->fb }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.linked_in') }}
                        </th>
                        <td>
                            {{ $developerListing->linked_in }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.developerListing.fields.pic') }}
                        </th>
                        <td>
                            {{ $developerListing->pic->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.developer-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection