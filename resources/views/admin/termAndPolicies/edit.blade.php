@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Term And Policy
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.term-and-policies.update", [$termAndPolicy->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title_zh">title_zh</label>
                <input class="form-control {{ $errors->has('title_zh') ? 'is-invalid' : '' }}" type="text" name="title_zh" id="title_zh" value="{{ old('title_zh', $termAndPolicy->title_zh) }}" required>
                @if($errors->has('title_zh'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_zh') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.title_zh_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="title_en">title_en</label>
                <input class="form-control {{ $errors->has('title_en') ? 'is-invalid' : '' }}" type="text" name="title_en" id="title_en" value="{{ old('title_en', $termAndPolicy->title_en) }}" required>
                @if($errors->has('title_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_en') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.title_en_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="title_ms">title_ms</label>
                <input class="form-control {{ $errors->has('title_ms') ? 'is-invalid' : '' }}" type="text" name="title_ms" id="title_ms" value="{{ old('title_ms', $termAndPolicy->title_ms) }}" required>
                @if($errors->has('title_ms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_ms') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.title_ms_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="details_zh">details_zh</label>
                <textarea class="form-control ckeditor {{ $errors->has('details_zh') ? 'is-invalid' : '' }}" name="details_zh" id="details_zh">{!! old('details_zh', $termAndPolicy->details_zh) !!}</textarea>
                @if($errors->has('details_zh'))
                    <div class="invalid-feedback">
                        {{ $errors->first('details_zh') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.details_zh_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="details_en">details_en</label>
                <textarea class="form-control ckeditor {{ $errors->has('details_en') ? 'is-invalid' : '' }}" name="details_en" id="details_en">{!! old('details_en', $termAndPolicy->details_en) !!}</textarea>
                @if($errors->has('details_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('details_en') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.details_en_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="details_ms">details_ms</label>
                <textarea class="form-control ckeditor {{ $errors->has('details_ms') ? 'is-invalid' : '' }}" name="details_ms" id="details_ms">{!! old('details_ms', $termAndPolicy->details_ms) !!}</textarea>
                @if($errors->has('details_ms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('details_ms') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.details_ms_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required">type</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\TermAndPolicy::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $termAndPolicy->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.termAndPolicy.fields.type_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.unitMangement.fields.project_code') }}</label>
                <select class="form-control select2 {{ $errors->has('project_code') ? 'is-invalid' : '' }}" name="project_code_id" id="project_code_id" required>
                    @foreach($project_codes as $id => $project_code)
                        <option value="{{ $id }}" {{ (old('project_code_id') ? old('project_code_id') : $unitMangement->project_code->id ?? '') == $id ? 'selected' : '' }}>{{ $project_code }}</option>
                    @endforeach
                </select>
                @if($errors->has('project_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.project_code_helper') }}</span>
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
                xhr.open('POST', '/admin/term-and-policies/ckmedia', true);
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
                data.append('crud_id', '{{ $termAndPolicy->id ?? 0 }}');
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

@endsection