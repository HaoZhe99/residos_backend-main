@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.eBillListing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.e-bill-listings.update", [$eBillListing->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.eBillListing.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }} required>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\EBillListing::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $eBillListing->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_method_id">Payment Method</label>
                <select class="form-control select2 {{ $errors->has('payment_method_id') ? 'is-invalid' : '' }}" name="payment_method_id" id="payment_method_id" >
                    @foreach($payment_method as $id => $method)
                        <option value="{{ $id }}" {{ (old('payment_method_id') ? old('payment_method_id') : $eBillListing->payment_method->id ?? '') == $id ? 'selected' : '' }}>{{ $method }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment_method_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_method_id') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.eBillListing.fields.project_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.eBillListing.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $eBillListing->amount) }}" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expired_date">{{ trans('cruds.eBillListing.fields.expired_date') }}</label>
                <input class="form-control date {{ $errors->has('expired_date') ? 'is-invalid' : '' }}" type="text" name="expired_date" id="expired_date" value="{{ old('expired_date', $eBillListing->expired_date) }}"required>
                @if($errors->has('expired_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('expired_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.expired_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.eBillListing.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $eBillListing->remark) }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="project_id">{{ trans('cruds.eBillListing.fields.project') }}</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id" required>
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}" {{ (old('project_id') ? old('project_id') : $eBillListing->project->id ?? '') == $id ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                </select>
                @if($errors->has('project'))
                    <div class="invalid-feedback">
                        {{ $errors->first('project') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.project_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.eBillListing.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                    @foreach($units as $id => $unit)
                        <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $eBillListing->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $unit }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_acc_id">{{ trans('cruds.eBillListing.fields.bank_acc') }}</label>
                <select class="form-control select2 {{ $errors->has('bank_acc') ? 'is-invalid' : '' }}" name="bank_acc_id" id="bank_acc_id" required>
                    @foreach($bank_accs as $id => $bank_acc)
                        <option value="{{ $id }}" {{ (old('bank_acc_id') ? old('bank_acc_id') : $eBillListing->bank_acc->id ?? '') == $id ? 'selected' : '' }}>{{ $bank_acc }}</option>
                    @endforeach
                </select>
                @if($errors->has('bank_acc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_acc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.bank_acc_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="username_id">{{ trans('cruds.eBillListing.fields.username') }}</label>
                <select class="form-control select2 {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username_id" id="username_id" required>
                    @foreach($usernames as $id => $username)
                        <option value="{{ $id }}" {{ (old('username_id') ? old('username_id') : $eBillListing->username->id ?? '') == $id ? 'selected' : '' }}>{{ $username }}</option>
                    @endforeach
                </select>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="receipt">{{ trans('cruds.eBillListing.fields.receipt') }}</label>
                <div class="needsclick dropzone {{ $errors->has('receipt') ? 'is-invalid' : '' }}" id="receipt-dropzone">
                </div>
                @if($errors->has('receipt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('receipt') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.receipt_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.eBillListing.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\EBillListing::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $eBillListing->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eBillListing.fields.status_helper') }}</span>
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
    Dropzone.options.receiptDropzone = {
    url: '{{ route('admin.e-bill-listings.storeMedia') }}',
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
@if(isset($eBillListing) && $eBillListing->receipt)
      var file = {!! json_encode($eBillListing->receipt) !!}
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