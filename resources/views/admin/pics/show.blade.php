@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pic.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pic.fields.id') }}
                        </th>
                        <td>
                            {{ $pic->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pic.fields.name') }}
                        </th>
                        <td>
                            {{ $pic->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pic.fields.contact') }}
                        </th>
                        <td>
                            {{ $pic->contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pic.fields.email') }}
                        </th>
                        <td>
                            {{ $pic->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pic.fields.position') }}
                        </th>
                        <td>
                            {{ $pic->position }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pic.fields.fb') }}
                        </th>
                        <td>
                            {{ $pic->fb }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pics.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection