@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.contentListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.content-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.id') }}
                        </th>
                        <td>
                            {{ $contentListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.type') }}
                        </th>
                        <td>
                            {{ $contentListing->type->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.title') }}
                        </th>
                        <td>
                            {{ $contentListing->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.description') }}
                        </th>
                        <td>
                            {{ $contentListing->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.pinned') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $contentListing->pinned ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.language') }}
                        </th>
                        <td>
                            {{ $contentListing->language }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.created_by') }}
                        </th>
                        <td>
                            {{ $contentListing->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.send_to') }}
                        </th>
                        <td>
                            {{ $contentListing->send_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.image') }}
                        </th>
                        <td>
                            @foreach($contentListing->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.url') }}
                        </th>
                        <td>
                            {{ $contentListing->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.user_group') }}
                        </th>
                        <td>
                            {{ $contentListing->user_group }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.expired_date') }}
                        </th>
                        <td>
                            {{ $contentListing->expired_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.is_active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $contentListing->is_active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contentListing.fields.project_code') }}
                        </th>
                        <td>
                            {{ $contentListing->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAlert.fields.user') }}
                        </th>
                        <td>
                            @foreach($userAlert->users as $key => $user)
                                <span class="label label-info">{{ $user->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.content-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection