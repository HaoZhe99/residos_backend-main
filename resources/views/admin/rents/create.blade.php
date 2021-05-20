@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rent.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.rents.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="tenant_id">Tenant</label>
                <select class="form-control select2 {{ $errors->has('tenant') ? 'is-invalid' : '' }}" name="tenant_id" id="tenant_id">
                    @foreach($tenants as $id => $tenant)
                        <option value="{{ $id }}" {{ old('tenant_id') == $id ? 'selected' : '' }}>{{ $tenant }}</option>
                    @endforeach
                </select>
                @if($errors->has('tenant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tenant') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.rent.fields.owner_helper') }}</span> --}}
            </div>
            {{-- <div class="form-group">
                <label class="required" for="tenant">{{ trans('cruds.rent.fields.tenant') }}</label>
                <input class="form-control {{ $errors->has('tenant') ? 'is-invalid' : '' }}" type="text" name="tenant" id="tenant" value="{{ old('tenant', '') }}" required>
                @if($errors->has('tenant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tenant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.tenant_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.rent.fields.rent') }}</label>
                <input class="form-control {{ $errors->has('rent_fee') ? 'is-invalid' : '' }}" type="number" name="rent_fee" id="rent_fee" value="{{ old('rent_fee', '') }}" step="0.01">
                @if($errors->has('rent_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rent_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.rent_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.rent.fields.day_of_month') }}</label>
                <select class="form-control {{ $errors->has('day_of_month') ? 'is-invalid' : '' }}" name="day_of_month" id="day_of_month" required>
                    <option value disabled {{ old('day_of_month', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Rent::DAY_OF_MONTH_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('day_of_month', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('day_of_month'))
                    <div class="invalid-feedback">
                        {{ $errors->first('day_of_month') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.day_of_month_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.rent.fields.leases') }}</label>
                <input class="form-control {{ $errors->has('leases') ? 'is-invalid' : '' }}" type="number" name="leases" id="leases" value="{{ old('leases') }}">
                @if($errors->has('leases'))
                    <div class="invalid-feedback">
                        {{ $errors->first('leases') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.leases_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.rent.fields.start_rent_day') }}</label>
                <input class="form-control date {{ $errors->has('start_rent_day') ? 'is-invalid' : '' }}" type="text" name="start_rent_day" id="start_rent_day" value="{{ old('start_rent_day') }}">
                @if($errors->has('start_rent_day'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_rent_day') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.start_rent_day_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label>{{ trans('cruds.rent.fields.end_rent_day') }}</label>
                <input class="form-control date {{ $errors->has('end_rent_day') ? 'is-invalid' : '' }}" type="text" name="end_rent_day" id="end_rent_day" value="{{ old('end_rent_day') }}">
                @if($errors->has('end_rent_day'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_rent_day') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.end_rent_day_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label class="required" for="bank_acc_id">{{ trans('cruds.rent.fields.bank_acc') }}</label>
                <input class="form-control {{ $errors->has('bank_acc') ? 'is-invalid' : '' }}" type="text" name="bank_acc" id="bank_acc" value="{{ old('bank_acc', '') }}">
                @if($errors->has('bank_acc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_acc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.bank_acc_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.rent.fields.ststus') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Rent::STSTUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.ststus_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.rent.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Rent::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slot_limit">{{ trans('cruds.rent.fields.slot_limit') }}</label>
                <input class="form-control {{ $errors->has('slot_limit') ? 'is-invalid' : '' }}" type="number" name="slot_limit" id="slot_limit" value="{{ old('slot_limit', '2') }}" step="1" required>
                @if($errors->has('slot_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slot_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.slot_limit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="room_size">{{ trans('cruds.rent.fields.room_size') }}</label>
                <input class="form-control {{ $errors->has('room_size') ? 'is-invalid' : '' }}" type="number" name="room_size" id="room_size" value="{{ old('room_size', '') }}" step="0.01">
                @if($errors->has('room_size'))
                    <div class="invalid-feedback">
                        {{ $errors->first('room_size') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.room_size_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.rent.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', '') }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amenities">{{ trans('cruds.rent.fields.amenities') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('amenities') ? 'is-invalid' : '' }}" name="amenities[]" id="amenities" multiple>
                    @foreach($amenities as $id => $amenities)
                        <option value="{{ $id }}" {{ in_array($id, old('amenities', [])) ? 'selected' : '' }}>{{ $amenities }}</option>
                    @endforeach
                </select>
                @if($errors->has('amenities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amenities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.amenities_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_owner_id">{{ trans('cruds.rent.fields.unit_owner') }}</label>
                <select class="form-control select2 {{ $errors->has('unit_owner') ? 'is-invalid' : '' }}" name="unit_owner_id" id="unit_owner_id" required>
                    @foreach($unit_owners as $id => $unit_owner)
                        <option value="{{ $id }}" {{ old('unit_owner_id') == $id ? 'selected' : '' }}>{{ $unit_owner }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit_owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_owner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.unit_owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.rent.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rent.fields.image_helper') }}</span>
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
    url: '{{ route('admin.rents.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
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
@if(isset($rent) && $rent->image)
      var files = {!! json_encode($rent->image) !!}
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