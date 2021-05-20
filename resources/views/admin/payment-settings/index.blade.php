@extends('layouts.admin')
@section('content')
@can('payment_method_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.payment-settings.create') }}">
                Add Payment Method
            </a>
            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'PaymentMethod', 'route' => 'admin.payment-methods.parseCsvImport']) --}}
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Payment Method List
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-PaymentMethod">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        Method
                    </th>
                    <th>
                        status
                    </th>
                    <th>
                        description
                    </th>
                    <th>
                        in_enable
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('payment_method_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.payment-settings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        language: {
            sUrl : "{{ asset('json/datatable_language.json') }}"
        },
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: {
            url: "{{ route('admin.payment-settings.index') }}",
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'method', name: 'method' },
            { data: 'status', name: 'status' },
            { data: 'description', name: 'description' },
            { data: 'in_enable', name: 'in_enable' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 100,
    };
    let table = $('.datatable-PaymentMethod').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

});

</script>
@endsection
