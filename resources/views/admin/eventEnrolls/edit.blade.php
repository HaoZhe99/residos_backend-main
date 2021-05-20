@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.eventEnroll.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.event-enrolls.update", [$eventEnroll->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.eventEnroll.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\EventEnroll::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $eventEnroll->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventEnroll.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="username_id">{{ trans('cruds.eventEnroll.fields.username') }}</label>
                <select class="form-control select2 {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username_id" id="username_id">
                    @foreach($usernames as $id => $username)
                        <option value="{{ $id }}" {{ (old('username_id') ? old('username_id') : $eventEnroll->username->id ?? '') == $id ? 'selected' : '' }}>{{ $username }}</option>
                    @endforeach
                </select>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventEnroll.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="event_code_id">{{ trans('cruds.eventEnroll.fields.event_code') }}</label>
                <select class="form-control select2 {{ $errors->has('event_code') ? 'is-invalid' : '' }}" name="event_code_id" id="event_code_id" required>
                    @foreach($event_codes as $id => $event_code)
                        <option value="{{ $id }}" {{ (old('event_code_id') ? old('event_code_id') : $eventEnroll->event_code->id ?? '') == $id ? 'selected' : '' }}>{{ $event_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('event_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventEnroll.fields.event_code_helper') }}</span>
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