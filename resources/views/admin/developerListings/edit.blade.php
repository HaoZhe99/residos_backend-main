@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.developerListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.developer-listings.update", [$developerListing->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="company_name">{{ trans('cruds.developerListing.fields.company_name') }}</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $developerListing->company_name) }}" required>
                @if($errors->has('company_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.company_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact">{{ trans('cruds.developerListing.fields.contact') }}</label>
                <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text" name="contact" id="contact" value="{{ old('contact', $developerListing->contact) }}">
                @if($errors->has('contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.developerListing.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $developerListing->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.developerListing.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $developerListing->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="website">{{ trans('cruds.developerListing.fields.website') }}</label>
                <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', $developerListing->website) }}">
                @if($errors->has('website'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.website_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fb">{{ trans('cruds.developerListing.fields.fb') }}</label>
                <input class="form-control {{ $errors->has('fb') ? 'is-invalid' : '' }}" type="text" name="fb" id="fb" value="{{ old('fb', $developerListing->fb) }}">
                @if($errors->has('fb'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fb') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.fb_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="linked_in">{{ trans('cruds.developerListing.fields.linked_in') }}</label>
                <input class="form-control {{ $errors->has('linked_in') ? 'is-invalid' : '' }}" type="text" name="linked_in" id="linked_in" value="{{ old('linked_in', $developerListing->linked_in) }}">
                @if($errors->has('linked_in'))
                    <div class="invalid-feedback">
                        {{ $errors->first('linked_in') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.linked_in_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pic_id">{{ trans('cruds.developerListing.fields.pic') }}</label>
                <select class="form-control select2 {{ $errors->has('pic') ? 'is-invalid' : '' }}" name="pic_id" id="pic_id" required>
                    @foreach($pics as $id => $pic)
                        <option value="{{ $id }}" {{ (old('pic_id') ? old('pic_id') : $developerListing->pic->id ?? '') == $id ? 'selected' : '' }}>{{ $pic }}</option>
                    @endforeach
                </select>
                @if($errors->has('pic'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pic') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.developerListing.fields.pic_helper') }}</span>
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