@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.unitMangement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-mangements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.id') }}
                        </th>
                        <td>
                            {{ $unitMangement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.unit_code') }}
                        </th>
                        <td>
                            {{ $unitMangement->unit_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.floor_size') }}
                        </th>
                        <td>
                            {{ $unitMangement->floor_size }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.bed_room') }}
                        </th>
                        <td>
                            {{ $unitMangement->bed_room }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.toilet') }}
                        </th>
                        <td>
                            {{ $unitMangement->toilet }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.floor_level') }}
                        </th>
                        <td>
                            {{ $unitMangement->floor_level }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.carpark_slot') }}
                        </th>
                        <td>
                            {{ $unitMangement->carpark_slot }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.bumi_lot') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $unitMangement->bumi_lot ? 'checked' : '' }}>
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.block') }}
                        </th>
                        <td>
                            {{ $unitMangement->block }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\UnitManagement::STATUS_SELECT[$unitMangement->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.balcony') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $unitMangement->balcony ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.project_code') }}
                        </th>
                        <td>
                            {{ $unitMangement->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.unit') }}
                        </th>
                        <td>
                            {{ $unitMangement->unit->unit ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.owner') }}
                        </th>
                        <td>
                            {{ $unitMangement->owner->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            SPA
                        </th>
                        <td>
                            @if($unitMangement->spa)
                                <a href="{{ $unitMangement->spa->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-mangements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection