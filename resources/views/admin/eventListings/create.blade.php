@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.eventListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.event-listings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="event_code">{{ trans('cruds.eventListing.fields.event_code') }}</label>
                <input class="form-control {{ $errors->has('event_code') ? 'is-invalid' : '' }}" type="text" name="event_code" id="event_code" value="{{ old('event_code', '') }}" required>
                @if($errors->has('event_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.event_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="catogery_id">{{ trans('cruds.eventListing.fields.catogery') }}</label>
                <select class="form-control select2 {{ $errors->has('catogery') ? 'is-invalid' : '' }}" name="catogery_id" id="catogery_id" required>
                    @foreach($catogeries as $id => $catogery)
                        <option value="{{ $id }}" {{ old('catogery_id') == $id ? 'selected' : '' }}>{{ $catogery }}</option>
                    @endforeach
                </select>
                @if($errors->has('catogery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('catogery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.catogery_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.eventListing.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.eventListing.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" required>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="language">{{ trans('cruds.eventListing.fields.language') }}</label>
                <input class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" type="text" name="language" id="language" value="{{ old('language', '') }}" required>
                @if($errors->has('language'))
                    <div class="invalid-feedback">
                        {{ $errors->first('language') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment">{{ trans('cruds.eventListing.fields.payment') }}</label>
                <input class="form-control {{ $errors->has('payment') ? 'is-invalid' : '' }}" type="text" name="payment" id="payment" value="{{ old('payment', '') }}">
                @if($errors->has('payment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.payment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="participants">{{ trans('cruds.eventListing.fields.participants') }}</label>
                <input class="form-control {{ $errors->has('participants') ? 'is-invalid' : '' }}" type="number" name="participants" id="participants" value="{{ old('participants', '') }}" step="1">
                @if($errors->has('participants'))
                    <div class="invalid-feedback">
                        {{ $errors->first('participants') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.participants_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.eventListing.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organized_by">{{ trans('cruds.eventListing.fields.organized_by') }}</label>
                <input class="form-control {{ $errors->has('organized_by') ? 'is-invalid' : '' }}" type="text" name="organized_by" id="organized_by" value="{{ old('organized_by', '') }}">
                @if($errors->has('organized_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organized_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.organized_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="type">{{ trans('cruds.eventListing.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}">
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.eventListing.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\EventListing::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.eventListing.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $created_by)
                        <option value="{{ $id }}" {{ old('created_by_id') == $id ? 'selected' : '' }}>{{ $created_by }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('created_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_group_id">{{ trans('cruds.eventListing.fields.user_group') }}</label>
                <select class="form-control select2 {{ $errors->has('user_group') ? 'is-invalid' : '' }}" name="user_group_id" id="user_group_id">
                    @foreach($user_groups as $id => $user_group)
                        <option value="{{ $id }}" {{ old('user_group_id') == $id ? 'selected' : '' }}>{{ $user_group }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventListing.fields.user_group_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedImageMap = {}
Dropzone.options.imageDropzone = {
    url: '{{ route('admin.event-listings.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
      uploadedImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImageMap[file.name]
      }
      $('form').find('input[name="image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($eventListing) && $eventListing->image)
      var files = {!! json_encode($eventListing->image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="image[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection