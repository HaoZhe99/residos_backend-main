@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bankAccListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bank-acc-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.id') }}
                        </th>
                        <td>
                            {{ $bankAccListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.bank_account') }}
                        </th>
                        <td>
                            {{ $bankAccListing->bank_account }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.status') }}
                        </th>
                        <td>
                            {{ $bankAccListing->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.is_active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $bankAccListing->is_active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.balance') }}
                        </th>
                        <td>
                            {{ $bankAccListing->balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $bankAccListing->bank_name->bank_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankAccListing.fields.project_code') }}
                        </th>
                        <td>
                            @foreach($bankAccListing->project_codes as $key => $project_code)
                                <span class="label label-info">{{ $project_code->project_code }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bank-acc-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection