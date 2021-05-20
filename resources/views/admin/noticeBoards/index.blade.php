@extends('layouts.admin')
@section('content')
@can('notice_board_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.notice-boards.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.noticeBoard.title_singular') }}
            </a>
            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'NoticeBoard', 'route' => 'admin.notice-boards.parseCsvImport']) --}}
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.noticeBoard.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-NoticeBoard">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        zh
                    </th>
                    <th>
                        en
                    </th>
                    <th>
                        ms
                    </th>
                    <th>
                        post_at
                    </th>
                    <th>
                        post_to
                    </th>
                    <th>
                        pinned
                    </th>
                    <th>
                        status
                    </th>
                    <th>
                        post_by
                    </th>
                    <th>
                        image
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
@can('notice_board_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.notice-boards.massDestroy') }}",
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
            url: "{{ route('admin.notice-boards.index') }}",
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'title_zh', name: 'title_zh' },
            { data: 'title_en', name: 'title_en' },
            { data: 'title_ms', name: 'title_ms' },
            { data: 'post_at', name: 'post_at' },
            { data: 'post_to', name: 'post_to' },
            { data: 'pinned', name: 'pinned' },
            { data: 'status', name: 'status' },
            { data: 'post_by', name: 'post_by' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 10,
    };
    let table = $('.datatable-NoticeBoard').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

});

</script>
@endsection
