@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.visitorControl.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.visitor-controls.update", [$visitorControl->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="username_id">{{ trans('cruds.visitorControl.fields.username') }}</label>
                <select class="form-control select2 {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username_id" id="username_id" required>
                    @foreach($usernames as $id => $username)
                        <option value="{{ $id }}" {{ (old('username_id') ? old('username_id') : $visitorControl->username->id ?? '') == $id ? 'selected' : '' }}>{{ $username }}</option>
                    @endforeach
                </select>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.visitorControl.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="add_by_id">{{ trans('cruds.visitorControl.fields.add_by') }}</label>
                <select class="form-control select2 {{ $errors->has('add_by') ? 'is-invalid' : '' }}" name="add_by_id" id="add_by_id" required>
                    @foreach($add_bies as $id => $add_by)
                        <option value="{{ $id }}" {{ (old('add_by_id') ? old('add_by_id') : $visitorControl->add_by->id ?? '') == $id ? 'selected' : '' }}>{{ $add_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('add_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('add_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.visitorControl.fields.add_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.visitorControl.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VisitorControl::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $visitorControl->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.visitorControl.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('favourite') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="favourite" value="0">
                    <input class="form-check-input" type="checkbox" name="favourite" id="favourite" value="1" {{ $visitorControl->favourite || old('favourite', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="favourite">{{ trans('cruds.visitorControl.fields.favourite') }}</label>
                </div>
                @if($errors->has('favourite'))
                    <div class="invalid-feedback">
                        {{ $errors->first('favourite') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.visitorControl.fields.favourite_helper') }}</span>
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