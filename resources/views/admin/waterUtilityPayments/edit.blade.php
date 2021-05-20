@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Water Utility Payment
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.water-utility-payments.update", [$waterUtilityPayment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="unit_owner_id">unit_owner</label>
                <select class="form-control select2 {{ $errors->has('unit_owner') ? 'is-invalid' : '' }}" name="unit_owner_id" id="unit_owner_id" required>
                    @foreach($unit_owners as $id => $unit_owner)
                        <option value="{{ $id }}" {{ (old('unit_owner_id') ? old('unit_owner_id') : $waterUtilityPayment->unit_owner->id ?? '') == $id ? 'selected' : '' }}>{{ $unit_owner }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit_owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_owner') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.unit_owner_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="name">name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $waterUtilityPayment->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.name_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="last_date">last_date</label>
                <input class="form-control date {{ $errors->has('last_date') ? 'is-invalid' : '' }}" type="text" name="last_date" id="last_date" value="{{ old('last_date', $waterUtilityPayment->last_date) }}">
                @if($errors->has('last_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_date') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.last_date_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="last_meter">last_meter</label>
                <input class="form-control {{ $errors->has('last_meter') ? 'is-invalid' : '' }}" type="number" name="last_meter" id="last_meter" value="{{ old('last_meter', $waterUtilityPayment->last_meter) }}" step="1" required>
                @if($errors->has('last_meter'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_meter') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.last_meter_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="this_meter">this_meter</label>
                <input class="form-control {{ $errors->has('this_meter') ? 'is-invalid' : '' }}" type="number" name="this_meter" id="this_meter" value="{{ old('this_meter', $waterUtilityPayment->this_meter) }}" step="1" required>
                @if($errors->has('this_meter'))
                    <div class="invalid-feedback">
                        {{ $errors->first('this_meter') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.this_meter_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="prev_consume">prev_consume</label>
                <input class="form-control {{ $errors->has('prev_consume') ? 'is-invalid' : '' }}" type="number" name="prev_consume" id="prev_consume" value="{{ old('prev_consume', $waterUtilityPayment->prev_consume) }}" step="1" required>
                @if($errors->has('prev_consume'))
                    <div class="invalid-feedback">
                        {{ $errors->first('prev_consume') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.prev_consume_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="this_consume">this_consume</label>
                <input class="form-control {{ $errors->has('this_consume') ? 'is-invalid' : '' }}" type="number" name="this_consume" id="this_consume" value="{{ old('this_consume', $waterUtilityPayment->this_consume) }}" step="1" required>
                @if($errors->has('this_consume'))
                    <div class="invalid-feedback">
                        {{ $errors->first('this_consume') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.this_consume_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="variance">variance</label>
                <input class="form-control {{ $errors->has('variance') ? 'is-invalid' : '' }}" type="number" name="variance" id="variance" value="{{ old('variance', $waterUtilityPayment->variance) }}" step="1" required>
                @if($errors->has('variance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('variance') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.variance_helper') }}</span> --}}
            </div>
            {{-- <div class="form-group">
                <label class="required" for="amount">amount</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $waterUtilityPayment->amount) }}" step="1" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">status</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WaterUtilityPayment::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $waterUtilityPayment->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="receipt">receipt</label>
                <div class="needsclick dropzone {{ $errors->has('receipt') ? 'is-invalid' : '' }}" id="receipt-dropzone">
                </div>
                @if($errors->has('receipt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('receipt') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.waterUtilityPayment.fields.receipt_helper') }}</span>
            </div> --}}
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
    Dropzone.options.receiptDropzone = {
    url: '{{ route('admin.water-utility-payments.storeMedia') }}',
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
      $('form').find('input[name="receipt"]').remove()
      $('form').append('<input type="hidden" name="receipt" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="receipt"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($waterUtilityPayment) && $waterUtilityPayment->receipt)
      var file = {!! json_encode($waterUtilityPayment->receipt) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="receipt" value="' + file.file_name + '">')
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