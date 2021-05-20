@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contentListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.content-listings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.contentListing.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $type)
                        <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.contentListing.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.contentListing.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" required>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('pinned') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="pinned" value="0">
                    <input class="form-check-input" type="checkbox" name="pinned" id="pinned" value="1" {{ old('pinned', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="pinned">{{ trans('cruds.contentListing.fields.pinned') }}</label>
                </div>
                @if($errors->has('pinned'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pinned') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.pinned_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="language">{{ trans('cruds.contentListing.fields.language') }}</label>
                <input class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" type="text" name="language" id="language" value="{{ old('language', '') }}" required>
                @if($errors->has('language'))
                    <div class="invalid-feedback">
                        {{ $errors->first('language') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by">{{ trans('cruds.contentListing.fields.created_by') }}</label>
                <input class="form-control {{ $errors->has('created_by') ? 'is-invalid' : '' }}" type="text" name="created_by" id="created_by" value="{{ old('created_by', '') }}">
                @if($errors->has('created_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('created_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="send_to">{{ trans('cruds.contentListing.fields.send_to') }}</label>
                <input class="form-control {{ $errors->has('send_to') ? 'is-invalid' : '' }}" type="text" name="send_to" id="send_to" value="{{ old('send_to', '') }}">
                @if($errors->has('send_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('send_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.send_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.contentListing.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="url">{{ trans('cruds.contentListing.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', '') }}">
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_group">{{ trans('cruds.contentListing.fields.user_group') }}</label>
                <input class="form-control {{ $errors->has('user_group') ? 'is-invalid' : '' }}" type="text" name="user_group" id="user_group" value="{{ old('user_group', '') }}">
                @if($errors->has('user_group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.user_group_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expired_date">{{ trans('cruds.contentListing.fields.expired_date') }}</label>
                <input class="form-control {{ $errors->has('expired_date') ? 'is-invalid' : '' }}" type="text" name="expired_date" id="expired_date" value="{{ old('expired_date', '') }}">
                @if($errors->has('expired_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('expired_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.expired_date_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ trans('cruds.contentListing.fields.is_active') }}</label>
                </div>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentListing.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.contentListing.fields.project_code') }}</label>
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
                <span class="help-block">{{ trans('cruds.contentListing.fields.project_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="users">user</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users" multiple>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ in_array($id, old('users', [])) ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('users'))
                    <div class="invalid-feedback">
                        {{ $errors->first('users') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.user_helper') }}</span> --}}
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
    url: '{{ route('admin.content-listings.storeMedia') }}',
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
@if(isset($contentListing) && $contentListing->image)
      var files = {!! json_encode($contentListing->image) !!}
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