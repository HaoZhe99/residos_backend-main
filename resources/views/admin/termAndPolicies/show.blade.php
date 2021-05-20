@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Term And Policy
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.term-and-policies.index') }}">
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
                            {{ $termAndPolicy->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            title_zh
                        </th>
                        <td>
                            {{ $termAndPolicy->title_zh }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            title_en
                        </th>
                        <td>
                            {{ $termAndPolicy->title_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            title_ms
                        </th>
                        <td>
                            {{ $termAndPolicy->title_ms }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            details_zh
                        </th>
                        <td>
                            {!! $termAndPolicy->details_zh !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            details_en
                        </th>
                        <td>
                            {!! $termAndPolicy->details_en !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            details_ms
                        </th>
                        <td>
                            {!! $termAndPolicy->details_ms !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            type
                        </th>
                        <td>
                            {{ App\Models\TermAndPolicy::TYPE_SELECT[$termAndPolicy->type] ?? '' }}
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
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.term-and-policies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection