@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.transaction.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.transactions.update", [$transaction->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="bill_code">{{ trans('cruds.transaction.fields.bill_code') }}</label>
                <input class="form-control {{ $errors->has('bill_code') ? 'is-invalid' : '' }}" type="text" name="bill_code" id="bill_code" value="{{ old('bill_code', $transaction->bill_code) }}" required>
                @if($errors->has('bill_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.bill_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit">{{ trans('cruds.transaction.fields.credit') }}</label>
                <input class="form-control {{ $errors->has('credit') ? 'is-invalid' : '' }}" type="text" name="credit" id="credit" value="{{ old('credit', $transaction->credit) }}">
                @if($errors->has('credit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.credit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="debit">{{ trans('cruds.transaction.fields.debit') }}</label>
                <input class="form-control {{ $errors->has('debit') ? 'is-invalid' : '' }}" type="text" name="debit" id="debit" value="{{ old('debit', $transaction->debit) }}">
                @if($errors->has('debit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('debit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.debit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_code_id">{{ trans('cruds.transaction.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id">
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ (old('project_code_id') ? old('project_code_id') : $transaction->project_code->id ?? '') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.project_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_acc_id">{{ trans('cruds.transaction.fields.bank_acc') }}</label>
                <select class="form-control select2 {{ $errors->has('bank_acc') ? 'is-invalid' : '' }}" name="bank_acc_id" id="bank_acc_id">
                    @foreach($bank_accs as $id => $bank_acc)
                        <option value="{{ $id }}" {{ (old('bank_acc_id') ? old('bank_acc_id') : $transaction->bank_acc->id ?? '') == $id ? 'selected' : '' }}>{{ $bank_acc }}</option>
                    @endforeach
                </select>
                @if($errors->has('bank_acc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_acc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.bank_acc_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="username_id">{{ trans('cruds.transaction.fields.username') }}</label>
                <select class="form-control select2 {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username_id" id="username_id" required>
                    @foreach($usernames as $id => $username)
                        <option value="{{ $id }}" {{ (old('username_id') ? old('username_id') : $transaction->username->id ?? '') == $id ? 'selected' : '' }}>{{ $username }}</option>
                    @endforeach
                </select>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.username_helper') }}</span>
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