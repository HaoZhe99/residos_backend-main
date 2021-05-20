@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.noticeBoard.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.notice-boards.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title_zh">title_zh</label>
                <input class="form-control {{ $errors->has('title_zh') ? 'is-invalid' : '' }}" type="text" name="title_zh" id="title_zh" value="{{ old('title_zh', '') }}" required>
                @if($errors->has('title_zh'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_zh') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.title_zh_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="title_en">title_en</label>
                <input class="form-control {{ $errors->has('title_en') ? 'is-invalid' : '' }}" type="text" name="title_en" id="title_en" value="{{ old('title_en', '') }}" required>
                @if($errors->has('title_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_en') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.title_en_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="title_ms">title_ms</label>
                <input class="form-control {{ $errors->has('title_ms') ? 'is-invalid' : '' }}" type="text" name="title_ms" id="title_ms" value="{{ old('title_ms', '') }}" required>
                @if($errors->has('title_ms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_ms') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.title_ms_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="content_zh">content_zh</label>
                <textarea class="form-control ckeditor {{ $errors->has('content_zh') ? 'is-invalid' : '' }}" name="content_zh" id="content_zh">{!! old('content_zh') !!}</textarea>
                @if($errors->has('content_zh'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content_zh') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.content_zh_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="content_en">content_en</label>
                <textarea class="form-control ckeditor {{ $errors->has('content_en') ? 'is-invalid' : '' }}" name="content_en" id="content_en">{!! old('content_en') !!}</textarea>
                @if($errors->has('content_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content_en') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.content_en_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="content_ms">content_ms</label>
                <textarea class="form-control ckeditor {{ $errors->has('content_ms') ? 'is-invalid' : '' }}" name="content_ms" id="content_ms">{!! old('content_ms') !!}</textarea>
                @if($errors->has('content_ms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content_ms') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.content_ms_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="post_at">post_at</label>
                <input class="form-control datetime {{ $errors->has('post_at') ? 'is-invalid' : '' }}" type="text" name="post_at" id="post_at" value="{{ old('post_at') }}" required>
                @if($errors->has('post_at'))
                    <div class="invalid-feedback">
                        {{ $errors->first('post_at') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.post_at_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="post_to">post_to</label>
                <input class="form-control {{ $errors->has('post_to') ? 'is-invalid' : '' }}" type="text" name="post_to" id="post_to" value="{{ old('post_to', '') }}" required>
                @if($errors->has('post_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('post_to') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.post_to_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="pinned">pinned</label>
                <input class="form-control {{ $errors->has('pinned') ? 'is-invalid' : '' }}" type="number" name="pinned" id="pinned" value="{{ old('pinned', '0') }}" step="1">
                @if($errors->has('pinned'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pinned') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.pinned_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="status">status</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.status_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="post_by">post_by</label>
                <input class="form-control {{ $errors->has('post_by') ? 'is-invalid' : '' }}" type="text" name="post_by" id="post_by" value="{{ old('post_by', '') }}">
                @if($errors->has('post_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('post_by') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.post_by_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="image">image</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.noticeBoard.fields.image_helper') }}</span> --}}
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/admin/notice-boards/ckmedia', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $noticeBoard->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.notice-boards.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($noticeBoard) && $noticeBoard->image)
      var file = {!! json_encode($noticeBoard->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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