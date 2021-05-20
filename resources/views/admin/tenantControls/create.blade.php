@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Tenant
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tenant-controls.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="tenant_id">tenant</label>
                <select class="form-control select2 {{ $errors->has('tenant') ? 'is-invalid' : '' }}" name="tenant_id" id="tenant_id" required>
                    @foreach($tenants as $id => $tenant)
                        <option value="{{ $id }}" {{ old('tenant_id') == $id ? 'selected' : '' }}>{{ $tenant }}</option>
                    @endforeach
                </select>
                @if($errors->has('tenant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tenant') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.tenantControl.fields.tenant_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="rent_id">Unit</label>
                <select class="form-control select2 {{ $errors->has('rent') ? 'is-invalid' : '' }}" name="rent_id" id="rent_id" required>
                    @foreach($rents as $id => $rent)
                        <option value="{{ $id }}" {{ old('rent_id') == $id ? 'selected' : '' }}>{{ $rent }}</option>
                    @endforeach
                </select>
                @if($errors->has('rent'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rent') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.tenantControl.fields.unit_owner_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required">status</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\TenantControl::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.tenantControl.fields.status_helper') }}</span> --}}
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