@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.defectListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.defect-listings.update", [$defectListing->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="case_code">{{ trans('cruds.defectListing.fields.case_code') }}</label>
                <input class="form-control {{ $errors->has('case_code') ? 'is-invalid' : '' }}" type="text" name="case_code" id="case_code" value="{{ old('case_code', $defectListing->case_code) }}" required>
                @if($errors->has('case_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.case_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="category_id">{{ trans('cruds.defectListing.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $defectListing->category->id ?? '') == $id ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.defectListing.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $defectListing->description) }}" required>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.defectListing.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.defectListing.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $defectListing->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.defectListing.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $defectListing->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.defectListing.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $defectListing->remark) }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="incharge_person">{{ trans('cruds.defectListing.fields.incharge_person') }}</label>
                <input class="form-control {{ $errors->has('incharge_person') ? 'is-invalid' : '' }}" type="text" name="incharge_person" id="incharge_person" value="{{ old('incharge_person', $defectListing->incharge_person) }}">
                @if($errors->has('incharge_person'))
                    <div class="invalid-feedback">
                        {{ $errors->first('incharge_person') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.incharge_person_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contractor">{{ trans('cruds.defectListing.fields.contractor') }}</label>
                <input class="form-control {{ $errors->has('contractor') ? 'is-invalid' : '' }}" type="text" name="contractor" id="contractor" value="{{ old('contractor', $defectListing->contractor) }}">
                @if($errors->has('contractor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contractor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.contractor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_control_id">{{ trans('cruds.defectListing.fields.status_control') }}</label>
                <select class="form-control select2 {{ $errors->has('status_control') ? 'is-invalid' : '' }}" name="status_control_id" id="status_control_id">
                    @foreach($status_controls as $id => $status_control)
                        <option value="{{ $id }}" {{ (old('status_control_id') ? old('status_control_id') : $defectListing->status_control->id ?? '') == $id ? 'selected' : '' }}>{{ $status_control }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_control'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status_control') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.status_control_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.defectListing.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id" required>
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ (old('project_code_id') ? old('project_code_id') : $defectListing->project_code->id ?? '') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.defectListing.fields.project_code_helper') }}</span>
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
    url: '{{ route('admin.defect-listings.storeMedia') }}',
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
@if(isset($defectListing) && $defectListing->image)
      var files = {!! json_encode($defectListing->image) !!}
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