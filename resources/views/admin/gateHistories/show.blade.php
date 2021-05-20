@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.gateHistory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gate-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.gateHistory.fields.id') }}
                        </th>
                        <td>
                            {{ $gateHistory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateHistory.fields.gate_code') }}
                        </th>
                        <td>
                            {{ $gateHistory->gate_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateHistory.fields.type') }}
                        </th>
                        <td>
                            {{ $gateHistory->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateHistory.fields.username') }}
                        </th>
                        <td>
                            {{ $gateHistory->username->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            gateway
                        </th>
                        <td>
                            {{ $history->gateway->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Qr
                        </th>
                        <td>
                            {{ $history->qr->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Unit
                        </th>
                        <td>
                            {{ $history->unit->unit_owner ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gate-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection