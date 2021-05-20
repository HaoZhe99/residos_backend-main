@extends('layouts.admin')
@section('content')
@can('qr_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.qrs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.qr.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.qr.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Qr">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.expired_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.username') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.qr.fields.unit_owner') }}
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
@can('qr_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.qrs.massDestroy') }}",
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
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.qrs.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'status', name: 'status' },
{ data: 'type', name: 'type' },
{ data: 'expired_at', name: 'expired_at' },
{ data: 'username_name', name: 'username.name' },
{ data: 'project_code_project_code', name: 'project_code.project_code' },
{ data: 'unit_owner', name: 'unit_owner.unit_owner' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Qr').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection