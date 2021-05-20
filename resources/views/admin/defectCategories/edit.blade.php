@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.defectCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.defect-categories.update", [$defectCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="defect_cateogry">{{ trans('cruds.defectCategory.fields.defect_cateogry') }}</label>
                <input class="form-control {{ $errors->has('defect_cateogry') ? 'is-invalid' : '' }}" type="text" name="defect_cateogry" id="defect_cateogry" value="{{ old('defect_cateogry', $defectCategory->defect_cateogry) }}" required>
                @if($errors->has('defect_cateogry'))
                    <div class="invalid-feedback">
                        {{ $errors->first('defect_cateogry') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectCategory.fields.defect_cateogry_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('in_enable') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="in_enable" id="in_enable" value="1" {{ $defectCategory->in_enable || old('in_enable', 0) === 1 ? 'checked' : '' }} required>
                    <label class="required form-check-label" for="in_enable">{{ trans('cruds.defectCategory.fields.in_enable') }}</label>
                </div>
                @if($errors->has('in_enable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_enable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectCategory.fields.in_enable_helper') }}</span>
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