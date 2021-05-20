@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.projectCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.project-categories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="project_category">{{ trans('cruds.projectCategory.fields.project_category') }}</label>
                <input class="form-control {{ $errors->has('project_category') ? 'is-invalid' : '' }}" type="text" name="project_category" id="project_category" value="{{ old('project_category', '') }}" required>
                @if($errors->has('project_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectCategory.fields.project_category_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection