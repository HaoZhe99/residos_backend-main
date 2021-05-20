@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eventListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.event-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.id') }}
                        </th>
                        <td>
                            {{ $eventListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.event_code') }}
                        </th>
                        <td>
                            {{ $eventListing->event_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.catogery') }}
                        </th>
                        <td>
                            {{ $eventListing->catogery->cateogey ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.title') }}
                        </th>
                        <td>
                            {{ $eventListing->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.description') }}
                        </th>
                        <td>
                            {{ $eventListing->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.language') }}
                        </th>
                        <td>
                            {{ $eventListing->language }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.payment') }}
                        </th>
                        <td>
                            {{ $eventListing->payment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.participants') }}
                        </th>
                        <td>
                            {{ $eventListing->participants }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.image') }}
                        </th>
                        <td>
                            @foreach($eventListing->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.organized_by') }}
                        </th>
                        <td>
                            {{ $eventListing->organized_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.type') }}
                        </th>
                        <td>
                            {{ $eventListing->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\EventListing::STATUS_SELECT[$eventListing->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.created_by') }}
                        </th>
                        <td>
                            {{ $eventListing->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventListing.fields.user_group') }}
                        </th>
                        <td>
                            {{ $eventListing->user_group->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.event-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection