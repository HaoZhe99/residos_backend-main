@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.addUnit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.add-units.index') }}">
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
                            {{ $addUnit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Block
                        </th>
                        <td>
                            {{ $addUnit->block->block ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Floor
                        </th>
                        <td>
                            {{ $addUnit->floor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Unit
                        </th>
                        <td>
                            {{ $addUnit->unit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Square
                        </th>
                        <td>
                            {{ $addUnit->square }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Meter
                        </th>
                        <td>
                            {{ $addUnit->meter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitMangement.fields.project_code') }}
                        </th>
                        <td>
                            {{ $addUnit->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.add-units.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection