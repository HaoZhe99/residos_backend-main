@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eBillListing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.e-bill-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.id') }}
                        </th>
                        <td>
                            {{ $eBillListing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\EBillListing::TYPE_SELECT[$eBillListing->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Payment Method
                        </th>
                        <td>
                            {{ $eBillListing->payment_method->method }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.amount') }}
                        </th>
                        <td>
                            {{ $eBillListing->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.expired_date') }}
                        </th>
                        <td>
                            {{ $eBillListing->expired_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.remark') }}
                        </th>
                        <td>
                            {{ $eBillListing->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.project') }}
                        </th>
                        <td>
                            {{ $eBillListing->project->project_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.unit') }}
                        </th>
                        <td>
                            {{ $eBillListing->unit->unit_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.bank_acc') }}
                        </th>
                        <td>
                            {{ $eBillListing->bank_acc->bank_account ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.username') }}
                        </th>
                        <td>
                            {{ $eBillListing->username->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.receipt') }}
                        </th>
                        <td>
                            @if($eBillListing->receipt)
                                <a href="{{ $eBillListing->receipt->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eBillListing.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\EBillListing::STATUS_SELECT[$eBillListing->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.e-bill-listings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection