@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.feedbackListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.feedback-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.id') }}
                        </th>
                        <td>
                            {{ $feedbackListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.category') }}
                        </th>
                        <td>
                            {{ $feedbackListing->category->category ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.title') }}
                        </th>
                        <td>
                            {{ $feedbackListing->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.content') }}
                        </th>
                        <td>
                            {!! $feedbackListing->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.send_to') }}
                        </th>
                        <td>
                            {{ $feedbackListing->send_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.reply') }}
                        </th>
                        <td>
                            {{ $feedbackListing->reply }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.reply_photo') }}
                        </th>
                        <td>
                            @foreach($feedbackListing->reply_photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.project_code') }}
                        </th>
                        <td>
                            {{ $feedbackListing->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.created_by') }}
                        </th>
                        <td>
                            {{ $feedbackListing->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feedbackListing.fields.file') }}
                        </th>
                        <td>
                            @if($feedbackListing->file)
                                <a href="{{ $feedbackListing->file->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $feedbackListing->file->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.feedback-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection