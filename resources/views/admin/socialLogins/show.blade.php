@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.socialLogin.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.social-logins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.socialLogin.fields.id') }}
                        </th>
                        <td>
                            {{ $socialLogin->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialLogin.fields.name') }}
                        </th>
                        <td>
                            {{ $socialLogin->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialLogin.fields.user_id') }}
                        </th>
                        <td>
                            {{ $socialLogin->user_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialLogin.fields.secret') }}
                        </th>
                        <td>
                            {{ $socialLogin->secret }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialLogin.fields.redirect') }}
                        </th>
                        <td>
                            {{ $socialLogin->redirect }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.social-logins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection