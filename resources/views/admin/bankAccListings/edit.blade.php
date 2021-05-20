@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.bankAccListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bank-acc-listings.update", [$bankAccListing->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="bank_account">{{ trans('cruds.bankAccListing.fields.bank_account') }}</label>
                <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}" type="text" name="bank_account" id="bank_account" value="{{ old('bank_account', $bankAccListing->bank_account) }}" required>
                @if($errors->has('bank_account'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankAccListing.fields.bank_account_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.bankAccListing.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $bankAccListing->status) }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankAccListing.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $bankAccListing->is_active || old('is_active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ trans('cruds.bankAccListing.fields.is_active') }}</label>
                </div>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankAccListing.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="balance">{{ trans('cruds.bankAccListing.fields.balance') }}</label>
                <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="number" name="balance" id="balance" value="{{ old('balance', $bankAccListing->balance) }}" step="0.01">
                @if($errors->has('balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankAccListing.fields.balance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_name_id">{{ trans('cruds.bankAccListing.fields.bank_name') }}</label>
                <select class="form-control select2 {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" name="bank_name_id" id="bank_name_id">
                    @foreach($bank_names as $id => $bank_name)
                        <option value="{{ $id }}" {{ (old('bank_name_id') ? old('bank_name_id') : $bankAccListing->bank_name->id ?? '') == $id ? 'selected' : '' }}>{{ $bank_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankAccListing.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_codes">{{ trans('cruds.bankAccListing.fields.project_code') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('project_codes') ? 'is-invalid' : '' }}" name="project_codes[]" id="project_codes" multiple>
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ (in_array($id, old('project_codes', [])) || $bankAccListing->project_codes->contains($id)) ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_codes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_codes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankAccListing.fields.project_code_helper') }}</span>
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