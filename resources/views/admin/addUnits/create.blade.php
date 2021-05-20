@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.addUnit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.add-units.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="block_id">Block</label>
                <select class="form-control select2 {{ $errors->has('block') ? 'is-invalid' : '' }}" name="block_id" id="block_id" required>
                    @foreach($blocks as $id => $block)
                        <option value="{{ $id }}" {{ old('block_id') == $id ? 'selected' : '' }}>{{ $block }}</option>
                    @endforeach
                </select>
                @if($errors->has('block'))
                    <div class="invalid-feedback">
                        {{ $errors->first('block') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.addUnit.fields.block_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="floor">Floor</label>
                <input class="form-control {{ $errors->has('floor') ? 'is-invalid' : '' }}" type="number" name="floor" id="floor" value="{{ old('floor', '') }}" step="1" required>
                @if($errors->has('floor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('floor') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.addUnit.fields.floor_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" required>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.addUnit.fields.unit_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="square">Square</label>
                <input class="form-control {{ $errors->has('square') ? 'is-invalid' : '' }}" type="number" name="square" id="square" value="{{ old('square', '') }}" step="0.01" required>
                @if($errors->has('square'))
                    <div class="invalid-feedback">
                        {{ $errors->first('square') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.addUnit.fields.square_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="meter">Meter</label>
                <input class="form-control {{ $errors->has('meter') ? 'is-invalid' : '' }}" type="text" name="meter" id="meter" value="{{ old('meter', '') }}" required>
                @if($errors->has('meter'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meter') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.addUnit.fields.meter_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.unitMangement.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id" required>
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ old('project_code_id') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.project_code_helper') }}</span>
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