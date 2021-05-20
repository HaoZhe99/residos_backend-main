@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bankName.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bank-names.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bankName.fields.id') }}
                        </th>
                        <td>
                            {{ $bankName->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankName.fields.country') }}
                        </th>
                        <td>
                            {{ $bankName->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankName.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $bankName->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankName.fields.swift_code') }}
                        </th>
                        <td>
                            {{ $bankName->swift_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankName.fields.bank_code') }}
                        </th>
                        <td>
                            {{ $bankName->bank_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bank-names.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection