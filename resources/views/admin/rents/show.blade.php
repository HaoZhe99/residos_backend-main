@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.id') }}
                        </th>
                        <td>
                            {{ $rent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Tenant
                        </th>
                        <td>
                            {{ $rent->tenant->name ?? '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.rent.fields.tenant') }}
                        </th>
                        <td>
                            {{ $rent->tenant }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.rent') }}
                        </th>
                        <td>
                            {{ $rent->rent_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.day_of_month') }}
                        </th>
                        <td>
                            {{ App\Models\Rent::DAY_OF_MONTH_SELECT[$rent->day_of_month] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.leases') }}
                        </th>
                        <td>
                            {{ $rent->leases ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.start_rent_day') }}
                        </th>
                        <td>
                            {{ $rent->start_rent_day ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.end_rent_day') }}
                        </th>
                        <td>
                            {{ $rent->end_rent_day ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.bank_acc') }}
                        </th>
                        <td>
                            {{ $rent->bank_acc ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.ststus') }}
                        </th>
                        <td>
                            {{ App\Models\Rent::STSTUS_SELECT[$rent->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Rent::TYPE_SELECT[$rent->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.slot_limit') }}
                        </th>
                        <td>
                            {{ $rent->slot_limit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.room_size') }}
                        </th>
                        <td>
                            {{ $rent->room_size }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.remark') }}
                        </th>
                        <td>
                            {{ $rent->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.amenities') }}
                        </th>
                        <td>
                            @foreach($rent->amenities as $key => $amenities)
                                {{-- <span class="label label-info">{{ $amenities->type }}</span> --}}
                                <span class="badge badge-info">{{ $amenities->type }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.unit_owner') }}
                        </th>
                        <td>
                            {{ $rent->unit_owner->owner->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.unit_code') }}
                        </th>
                        <td>
                            {{ $rent->unit_owner->unit_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rent.fields.image') }}
                        </th>
                        <td>
                            @foreach($rent->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
