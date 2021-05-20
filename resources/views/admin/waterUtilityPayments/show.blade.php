@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Water Utility Payment
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.water-utility-payments.index') }}">
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
                            {{ $waterUtilityPayment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            unit_owner
                        </th>
                        <td>
                            {{ $waterUtilityPayment->unit_owner->unit_owner ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            name
                        </th>
                        <td>
                            {{ $waterUtilityPayment->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            last_date
                        </th>
                        <td>
                            {{ $waterUtilityPayment->last_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            last_meter
                        </th>
                        <td>
                            {{ $waterUtilityPayment->last_meter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            this_meter
                        </th>
                        <td>
                            {{ $waterUtilityPayment->this_meter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            prev_consume
                        </th>
                        <td>
                            {{ $waterUtilityPayment->prev_consume }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            this_consume
                        </th>
                        <td>
                            {{ $waterUtilityPayment->this_consume }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            variance
                        </th>
                        <td>
                            {{ $waterUtilityPayment->variance }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            amount
                        </th>
                        <td>
                            {{ $waterUtilityPayment->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            status
                        </th>
                        <td>
                            {{ App\Models\WaterUtilityPayment::STATUS_SELECT[$waterUtilityPayment->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            receipt
                        </th>
                        <td>
                            @if($waterUtilityPayment->receipt)
                                <a href="{{ $waterUtilityPayment->receipt->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.water-utility-payments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection