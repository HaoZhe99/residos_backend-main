@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.addBlock.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.add-blocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.addBlock.fields.id') }}
                        </th>
                        <td>
                            {{ $addBlock->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addBlock.fields.block') }}
                        </th>
                        <td>
                            {{ $addBlock->block }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addBlock.fields.project_code') }}
                        </th>
                        <td>
                            {{ $addBlock->project_code->project_code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.add-blocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection