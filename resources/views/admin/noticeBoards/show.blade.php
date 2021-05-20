@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.noticeBoard.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.notice-boards.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $noticeBoard->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            title_zh
                        </th>
                        <td>
                            {{ $noticeBoard->title_zh }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            title_en
                        </th>
                        <td>
                            {{ $noticeBoard->title_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            title_ms
                        </th>
                        <td>
                            {{ $noticeBoard->title_ms }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            content_zh
                        </th>
                        <td>
                            {!! $noticeBoard->content_zh !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            content_en
                        </th>
                        <td>
                            {!! $noticeBoard->content_en !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            content_ms
                        </th>
                        <td>
                            {!! $noticeBoard->content_ms !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            post_at
                        </th>
                        <td>
                            {{ $noticeBoard->post_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            post_to
                        </th>
                        <td>
                            {{ $noticeBoard->post_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            pinned
                        </th>
                        <td>
                            {{ $noticeBoard->pinned }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            status
                        </th>
                        <td>
                            {{ $noticeBoard->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            post_by
                        </th>
                        <td>
                            {{ $noticeBoard->post_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            image
                        </th>
                        <td>
                            @if($noticeBoard->image)
                                <a href="{{ $noticeBoard->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $noticeBoard->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.notice-boards.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection