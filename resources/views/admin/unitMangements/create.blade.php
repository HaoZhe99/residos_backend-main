@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.unitMangement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.unit-mangements.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="unit_code">{{ trans('cruds.unitMangement.fields.unit_code') }}</label>
                <input class="form-control {{ $errors->has('unit_code') ? 'is-invalid' : '' }}" type="text" name="unit_code" id="unit_code" value="{{ old('unit_code', '') }}">
                @if($errors->has('unit_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.unit_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="floor_size">{{ trans('cruds.unitMangement.fields.floor_size') }}</label>
                <input class="form-control {{ $errors->has('floor_size') ? 'is-invalid' : '' }}" type="text" name="floor_size" id="floor_size" value="{{ old('floor_size', '') }}" required>
                @if($errors->has('floor_size'))
                    <div class="invalid-feedback">
                        {{ $errors->first('floor_size') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.floor_size_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bed_room">{{ trans('cruds.unitMangement.fields.bed_room') }}</label>
                <input class="form-control {{ $errors->has('bed_room') ? 'is-invalid' : '' }}" type="text" name="bed_room" id="bed_room" value="{{ old('bed_room', '') }}" required>
                @if($errors->has('bed_room'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bed_room') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.bed_room_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="toilet">{{ trans('cruds.unitMangement.fields.toilet') }}</label>
                <input class="form-control {{ $errors->has('toilet') ? 'is-invalid' : '' }}" type="text" name="toilet" id="toilet" value="{{ old('toilet', '') }}" required>
                @if($errors->has('toilet'))
                    <div class="invalid-feedback">
                        {{ $errors->first('toilet') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.toilet_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="floor_level">{{ trans('cruds.unitMangement.fields.floor_level') }}</label>
                <input class="form-control {{ $errors->has('floor_level') ? 'is-invalid' : '' }}" type="text" name="floor_level" id="floor_level" value="{{ old('floor_level', '') }}">
                @if($errors->has('floor_level'))
                    <div class="invalid-feedback">
                        {{ $errors->first('floor_level') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.floor_level_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label for="carpark_slot">{{ trans('cruds.unitMangement.fields.carpark_slot') }}</label>
                <input class="form-control {{ $errors->has('carpark_slot') ? 'is-invalid' : '' }}" type="text" name="carpark_slot" id="carpark_slot" value="{{ old('carpark_slot', '') }}">
                @if($errors->has('carpark_slot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('carpark_slot') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.carpark_slot_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('bumi_lot') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="bumi_lot" value="0">
                    <input class="form-check-input" type="checkbox" name="bumi_lot" id="bumi_lot" value="1" {{ old('bumi_lot', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="bumi_lot">{{ trans('cruds.unitMangement.fields.bumi_lot') }}</label>
                </div>
                @if($errors->has('bumi_lot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bumi_lot') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.bumi_lot_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="block">{{ trans('cruds.unitMangement.fields.block') }}</label>
                <input class="form-control {{ $errors->has('block') ? 'is-invalid' : '' }}" type="text" name="block" id="block" value="{{ old('block', '') }}">
                @if($errors->has('block'))
                    <div class="invalid-feedback">
                        {{ $errors->first('block') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.block_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label>{{ trans('cruds.unitMangement.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\UnitManagement::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('balcony') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="balcony" value="0">
                    <input class="form-check-input" type="checkbox" name="balcony" id="balcony" value="1" {{ old('balcony', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="balcony">{{ trans('cruds.unitMangement.fields.balcony') }}</label>
                </div>
                @if($errors->has('balcony'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balcony') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.balcony_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="project_code_id">{{ trans('cruds.unitMangement.fields.project_code') }}</label>
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
                <span class="help-block">{{ trans('cruds.unitMangement.fields.project_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_id">{{ trans('cruds.unitMangement.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                    @foreach($units as $id => $unit)
                        <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>{{ $unit }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="owner_id">{{ trans('cruds.unitMangement.fields.owner') }}</label>
                <select class="form-control select2 {{ $errors->has('owner') ? 'is-invalid' : '' }}" name="owner_id" id="owner_id">
                    @foreach($owners as $id => $owner)
                        <option value="{{ $id }}" {{ old('owner_id') == $id ? 'selected' : '' }}>{{ $owner }}</option>
                    @endforeach
                </select>
                @if($errors->has('owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('owner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="spa">SPA</label>
                <div class="needsclick dropzone {{ $errors->has('spa') ? 'is-invalid' : '' }}" id="spa-dropzone">
                </div>
                @if($errors->has('spa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('spa') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitMangement.fields.spa_helper') }}</span>
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
    Dropzone.options.spaDropzone = {
    url: '{{ route('admin.unit-mangements.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="spa"]').remove()
      $('form').append('<input type="hidden" name="spa" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="spa"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($unitMangement) && $unitMangement->spa)
      var file = {!! json_encode($unitMangement->spa) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="spa" value="' + file.file_name + '">')
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