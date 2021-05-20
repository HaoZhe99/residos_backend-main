@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.projectListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.project-listings.update", [$projectListing->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="project_code">{{ trans('cruds.projectListing.fields.project_code') }}</label>
                <input class="form-control {{ $errors->has('project_code') ? 'is-invalid' : '' }}" type="text" name="project_code" id="project_code" value="{{ old('project_code', $projectListing->project_code) }}" required>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.project_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.projectListing.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $projectListing->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.projectListing.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $type)
                        <option value="{{ $id }}" {{ (old('type_id') ? old('type_id') : $projectListing->type->id ?? '') == $id ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.projectListing.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $projectListing->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="developer_id">{{ trans('cruds.projectListing.fields.developer') }}</label>
                <select class="form-control select2 {{ $errors->has('developer') ? 'is-invalid' : '' }}" name="developer_id" id="developer_id" required>
                    @foreach($developers as $id => $developer)
                        <option value="{{ $id }}" {{ (old('developer_id') ? old('developer_id') : $projectListing->developer->id ?? '') == $id ? 'selected' : '' }}>{{ $developer }}</option>
                    @endforeach
                </select>
                @if($errors->has('developer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('developer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.developer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.projectListing.fields.tenure') }}</label>
                <select class="form-control {{ $errors->has('tenure') ? 'is-invalid' : '' }}" name="tenure" id="tenure" >
                    <option value disabled {{ old('tenure', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ProjectListing::TENURE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tenure', $projectListing->tenure) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('tenure'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tenure') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.tenure_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="completion_date">{{ trans('cruds.projectListing.fields.completion_date') }}</label>
                <input class="form-control {{ $errors->has('completion_date') ? 'is-invalid' : '' }}" type="text" name="completion_date" id="completion_date" value="{{ old('completion_date', $projectListing->completion_date) }}" required>
                @if($errors->has('completion_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('completion_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.completion_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sales_gallery">{{ trans('cruds.projectListing.fields.sales_gallery') }}</label>
                <input class="form-control {{ $errors->has('sales_gallery') ? 'is-invalid' : '' }}" type="text" name="sales_gallery" id="sales_gallery" value="{{ old('sales_gallery', $projectListing->sales_gallery) }}">
                @if($errors->has('sales_gallery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sales_gallery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.sales_gallery_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.projectListing.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ProjectListing::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $projectListing->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="website">{{ trans('cruds.projectListing.fields.website') }}</label>
                <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', $projectListing->website) }}">
                @if($errors->has('website'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.website_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fb">{{ trans('cruds.projectListing.fields.fb') }}</label>
                <input class="form-control {{ $errors->has('fb') ? 'is-invalid' : '' }}" type="text" name="fb" id="fb" value="{{ old('fb', $projectListing->fb) }}">
                @if($errors->has('fb'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fb') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.fb_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="block">{{ trans('cruds.projectListing.fields.block') }}</label>
                <input class="form-control {{ $errors->has('block') ? 'is-invalid' : '' }}" type="number" name="block" id="block" value="{{ old('block', $projectListing->block) }}" step="1">
                @if($errors->has('block'))
                    <div class="invalid-feedback">
                        {{ $errors->first('block') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.block_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit">{{ trans('cruds.projectListing.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="number" name="unit" id="unit" value="{{ old('unit', $projectListing->unit) }}" step="1">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_new') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_new" value="0">
                    <input class="form-check-input" type="checkbox" name="is_new" id="is_new" value="1" {{ $projectListing->is_new || old('is_new', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_new">{{ trans('cruds.projectListing.fields.is_new') }}</label>
                </div>
                @if($errors->has('is_new'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_new') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.is_new_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="area_id">{{ trans('cruds.projectListing.fields.area') }}</label>
                <select class="form-control select2 {{ $errors->has('area') ? 'is-invalid' : '' }}" name="area_id" id="area_id">
                    @foreach($areas as $id => $area)
                        <option value="{{ $id }}" {{ (old('area_id') ? old('area_id') : $projectListing->area->id ?? '') == $id ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
                @if($errors->has('area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.area_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pic_id">{{ trans('cruds.projectListing.fields.pic') }}</label>
                <select class="form-control select2 {{ $errors->has('pic') ? 'is-invalid' : '' }}" name="pic_id" id="pic_id">
                    @foreach($pics as $id => $pic)
                        <option value="{{ $id }}" {{ (old('pic_id') ? old('pic_id') : $projectListing->pic->id ?? '') == $id ? 'selected' : '' }}>{{ $pic }}</option>
                    @endforeach
                </select>
                @if($errors->has('pic'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pic') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.pic_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="create_by">{{ trans('cruds.projectListing.fields.create_by') }}</label>
                <select class="form-control select2 {{ $errors->has('create_by') ? 'is-invalid' : '' }}" name="create_by" id="create_by" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('create_by') ? old('create_by') : $projectListing->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('create_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('create_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.projectListing.fields.create_by_helper') }}</span>
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