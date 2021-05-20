@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Notification
        <a href="javascript:void(0)" id="addRow" style="float: right;">Add Row</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.notifications.store") }}" enctype="multipart/form-data">
            @csrf
            <div id="Text">
                <div id="key">
                    <div class="form-group">
                        <label class="required" for="title_text">{{ trans('cruds.notification.fields.title_text') }}</label>
                        <a href="javascript:void(0)" id="remove" style="float: right;">Delete</a>
                        <input class="form-control {{ $errors->has('title_text') ? 'is-invalid' : '' }}" type="text" name="title_text[]" id="title_text" value="{{ old('title_text', '') }}">
                        @if($errors->has('title_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title_text') }}
                            </div>
                        @endif
                        {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.title_text_helper') }}</span> --}}
                    </div>
                    <div class="form-group">
                        <label class="required" for="description_text">{{ trans('cruds.notification.fields.description_text') }}</label>
                        <input class="form-control {{ $errors->has('description_text') ? 'is-invalid' : '' }}" type="text" name="description_text[]" id="description_text" value="{{ old('description_text', '') }}">
                        @if($errors->has('description_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description_text') }}
                            </div>
                        @endif
                        {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.description_text_helper') }}</span> --}}
                    </div>
                    <div class="form-group">
                        <label for="language">{{ trans('cruds.notification.fields.language') }}</label>
                        <select class="form-control select2 {{ $errors->has('language_shortkey') ? 'is-invalid' : '' }}" name="language_shortkey[]" id="language_shortkey">
                                <option>Select One Language</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->shortkey }}" {{ old('language_shortkey') ? 'selected' : '' }}>{{ $language->title }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('language'))
                            <div class="invalid-feedback">
                                {{ $errors->first('language') }}
                            </div>
                        @endif
                        {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.language_helper') }}</span> --}}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.notification.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.image_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="url">{{ trans('cruds.notification.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', '') }}">
                @if($errors->has('url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('url') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.url_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="role_id">{{ trans('cruds.notification.fields.roles_id') }}</label>
                <select class="form-control select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}" name="role_id[]" id="role_id" onchange="Select()">
                        <option value="">Select One Roles</option>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ old('role_id') ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('role_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('role_id') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.roles_id_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="role_id">{{ trans('cruds.notification.fields.user_id') }}</label>
                <select class="form-control select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" onchange="Select()">
                        <option value="">Select One User</option>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('role_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('role_id') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.roles_id_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label for="expired_date">{{ trans('cruds.notification.fields.expired_date') }}</label>
                <input class="form-control datetime {{ $errors->has('expired_date') ? 'is-invalid' : '' }}" type="text" name="expired_date" id="expired_date" value="{{ old('expired_date', '') }}">
                @if($errors->has('expired_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('expired_date') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.userAlert.fields.expired_date_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ trans('cruds.notification.fields.is_active') }}</label>
                </div>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contentType.fields.is_active_helper') }}</span>
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
<!-- Roles_id and Users_id -->
<script>
    function Select() {
        var dropdown1=document.getElementById("role_id");
        var dropdown2=document.getElementById("user_id");
        if (dropdown1.value) {
            document.getElementById("role_id").disabled=false;
            document.getElementById("user_id").disabled=true;
        }
        else if (dropdown2.value) {
            document.getElementById("role_id").disabled=true;
            document.getElementById("user_id").disabled=false;
        }else{
            document.getElementById("role_id").disabled=false;
            document.getElementById("user_id").disabled=false;
        }
    }
</script>

<!-- Add Col for the title and description -->
<script>
    $('#Text').delegate('.budget','keyup',function () {
        var tr=$(this).parent().parent();
    });

    $('#addRow').on('click',function () {
        addRow();
    });

    function addRow() {
        var div='<div id="key">' +
                    '<div class="form-group">' +
                        '<label class="required" for="title_text">{{ trans("cruds.notification.fields.title_text") }}</label>' +
                        '<a href="javascript:void(0)" id="remove" style="float: right;">Delete</a>' +
                        '<input class="form-control {{ $errors->has("title_text") ? "is-invalid" : "" }}" type="text" name="title_text[]" id="title_text" value="{{ old("title_text", "") }}">' +
                        '@if($errors->has("title_text"))' +
                            '<div class="invalid-feedback">' +
                                '{{ $errors->first("title_text") }}' +
                            '</div>' +
                        '@endif' +
                        '{{-- <span class="help-block">{{ trans("cruds.userAlert.fields.title_text_helper") }}</span> --}}' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="required" for="description_text">{{ trans("cruds.notification.fields.description_text") }}</label>' +
                        '<input class="form-control {{ $errors->has("description_text") ? "is-invalid" : "" }}" type="text" name="description_text[]" id="description_text" value="{{ old("description_text", "") }}">' +
                        '@if($errors->has("description_text"))' +
                            '<div class="invalid-feedback">' +
                                '{{ $errors->first("description_text") }}' +
                            '</div>' +
                        '@endif' +
                        '{{-- <span class="help-block">{{ trans("cruds.userAlert.fields.description_text_helper") }}</span> --}}' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="language">{{ trans("cruds.notification.fields.language") }}</label>' +
                        '<select class="form-control select2 {{ $errors->has("language_shortkey") ? "is-invalid" : "" }}" name="language_shortkey[]" id="language_shortkey">' +
                            '<option>Select One Language</option>' +
                            '@foreach($languages as $id => $language)' +
                                '<option value="{{ $language->shortkey }}" {{ old("language_shortkey") ? "selected" : "" }}>{{ $language->title }}</option>' +
                            '@endforeach' +
                        '</select>' +
                        '@if($errors->has("language"))' +
                            '<div class="invalid-feedback">' +
                                '{{ $errors->first("language") }}' +
                            '</div>' +
                        '@endif' +
                        '{{-- <span class="help-block">{{ trans("cruds.userAlert.fields.language_helper") }}</span> --}}' +
                    '</div>' +
                '</div>';
        $('#Text').append(div);
    };

    $('body').on('click', '#remove', function () {
        var last=$('#Text #key').length;
        if (last==1) {
            alert("you can not remove last row");
        }
        else {
            $(this).parent().parent().remove();
        }

    });
</script>

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
                    xhr.open('POST', '/admin/notifications/ckmedia', true);
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

                    $('form').append('<input type="hidden" name="ck-media" value="' + response.id + '">');

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
                    data.append('crud_id', '{{ $notifications->id ?? 0 }}');
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
    var uploadedReplyPhotoMap = {}
    Dropzone.options.replyPhotoDropzone = {
        url: '{{ route('admin.notifications.storeMedia') }}',
        maxFilesize: 4, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 4,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
            uploadedReplyPhotoMap[file.name] = response.name
        },
        removedfile: function (file) {
        console.log(file)
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedReplyPhotoMap[file.name]
        }
        $('form').find('input[name="image[]"][value="' + name + '"]').remove()
        },
        init: function () {
            @if(isset($notifications) && $notifications->image)
                var files = {!! json_encode($notifications->image) !!}
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

<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.notifications.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 5,
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
      $('form').find('input[name="image[]"]').remove()
      $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image[]"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
        @if(isset($notifications) && $notifications->file)
            var file = {!! json_encode($notifications->file) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="image[]" value="' + file.file_name + '">')
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