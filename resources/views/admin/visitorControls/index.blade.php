@extends('layouts.admin')
@section('content')
@can('visitor_control_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.visitor-controls.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.visitorControl.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.visitorControl.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.visitorControl.fields.username') }}</label>
                <input type="text" class="form-control" id="username"
                    placeholder="{{ trans('cruds.visitorControl.fields.username') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.visitorControl.fields.add_by') }}</label>
                <input type="text" class="form-control" id="add_by"
                    placeholder="{{ trans('cruds.visitorControl.fields.add_by') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.visitorControl.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\VisitorControl::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 align-self-end">
                <button type="button" id="search_form_submit" class="btn btn-primary btn_controller" disabled>
                    {{ trans('global.search') }}
                </button>
                <button type="button" id="reset" class="btn btn-danger btn_controller" disabled>
                    {{ trans('global.reset') }}
                </button>
            </div>
            <div class="form-check col-12 text-right">
                <label class="checkbox-inline mr-2">
                    <input class="form-check-input" type="checkbox" value="" id="refresh" checked>
                    <label class="form-check-label" for="refresh">
                        {{ trans('global.auto_refresh') }}
                    </label>
                </label>
                <button type="button" id="refresh_button" class="btn btn-light btn_controller" disabled>
                    {{ trans('global.refresh') }} (<span id="countdown_number">15</span>)
                </button>
            </div>
        </div>
    </div>
</div>
{{-- /search --}}

<div class="card">
    <div class="card-header">
        {{ trans('cruds.visitorControl.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-VisitorControl">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.visitorControl.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.visitorControl.fields.username') }}
                        </th>
                        <th>
                            {{ trans('cruds.visitorControl.fields.add_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.visitorControl.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.visitorControl.fields.favourite') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach($visitorControls as $key => $visitorControl)
                        <tr data-entry-id="{{ $visitorControl->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $visitorControl->id ?? '' }}
                            </td>
                            <td>
                                {{ $visitorControl->username->name ?? '' }}
                            </td>
                            <td>
                                {{ $visitorControl->add_by->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\VisitorControl::STATUS_SELECT[$visitorControl->status] ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $visitorControl->favourite ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $visitorControl->favourite ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('visitor_control_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.visitor-controls.show', $visitorControl->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('visitor_control_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.visitor-controls.edit', $visitorControl->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('visitor_control_delete')
                                    <form action="{{ route('admin.visitor-controls.destroy', $visitorControl->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
        var firstTime = true;
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('visitor_control_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.visitor-controls.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

//   $.extend(true, $.fn.dataTable.defaults, {
//     orderCellsTop: true,
//     order: [[ 1, 'desc' ]],
//     pageLength: 100,
//   });

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        language: {
            sUrl : "{{ asset('json/datatable_language.json') }}"
        },
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        pageLength: localStorage.getItem("visitorControl") ? JSON.parse(localStorage.getItem("visitorControl"))['length'] ? JSON.parse(localStorage.getItem("visitorControl"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.visitor-controls.index') }}",
            data: function(d) {

                if (localStorage.getItem("visitorControl") && firstTime) {
                    var visitorControl = JSON.parse(localStorage.getItem("visitorControl"));

                    var page = visitorControl['page'] ? visitorControl['page'] : 0;
                    var length = visitorControl['length'] ? visitorControl['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("visitorControl")) {
                var visitorControl = JSON.parse(localStorage.getItem("visitorControl"));
                if (visitorControl['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(visitorControl['page']).draw(false);
                }
                firstTime = false;
            }
        },
        drawCallback: function(settings) {
            $('.btn_controller').prop('disabled', false);
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'username', name: 'username.name' },
            { data: 'add_by', name: 'add_by.name' },
            { data: 'status', name: 'status' },
            { data: 'favourite', name: 'favourite' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };

//   let table = $('.datatable-VisitorControl:not(.ajaxTable)').DataTable({ buttons: dtButtons })
//   $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
//       $($.fn.dataTable.tables(true)).DataTable()
//           .columns.adjust();
//   });

    let table = $('.datatable-VisitorControl').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-VisitorControl').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-VisitorControl').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("visitorControl")) {
                var visitorControl = JSON.parse(localStorage.getItem("visitorControl"));
            }

            visitorControl['page'] = info.page;
            visitorControl['length'] = info.length;

            localStorage.setItem("visitorControl", JSON.stringify(visitorControl));
        }

        $("#refresh_button").click(function() {
            reset_reload_button();
        })

        var doUpdate = function() {
            if ($('#refresh').is(':checked')) {
                var count = parseInt($('#countdown_number').html());
                if (count !== 0) {
                    $('#countdown_number').html(count - 1);
                } else {
                    reset_reload_button();
                }
            }
        };

        function reset_reload_button() {
            $('.btn_controller').prop('disabled', true);
            $('#countdown_number').html(15);
            table.ajax.reload(null, false);
        }

        setInterval(doUpdate, 1000);

        $('#search #status').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.visitorControl.fields.status') }}",
            allowClear: true
        });

        var searchingFunction = function (val, tableRow) {
            if (val.length > 1){
                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                table
                    .columns(tableRow)
                    .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                    .draw();
            } else if (val.length == 1) {
                table
                    .columns(tableRow)
                    .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                    .draw();
            } else {
                table
                    .columns(tableRow)
                    .search('',true,false)
                    .draw();
            }
        }

        $("#reset").on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Reset();
            Searching();
        });

        function Reset() {
            $('#search #username').val('');
            $('#search #add_by').val('');

            $('#search #status').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("visitorControl")) {
                var searching = JSON.parse(localStorage.getItem("visitorControl"));

                $('#search #username').val(searching['username'] ? searching['username'] : '');
                $('#search #add_by').val(searching['add_by'] ? searching['add_by'] : '');

                $('#search #status').val(searching['status'] ? searching['status'] : 'All').trigger('change');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var username = $('#search #username').val();
            table
                .columns(2)
                .search(username)
                .draw();

            var add_by = $('#search #add_by').val();
            table
                .columns(3)
                .search(add_by)
                .draw();

            var status = $('#search #status').val();
            if(jQuery.inArray("All", status) === -1) {
                searchingFunction(status, 4);
            } else {
                table
                    .columns(4)
                    .search('',true,false)
                    .draw();
            }

            var visitorControl = {
                'username'      : username,
                'add_by'        : add_by,
                'status'        : status
            };

            if (localStorage.getItem("visitorControl") && firstTime) {
                var visitorControl = JSON.parse(localStorage.getItem("visitorControl"));

                var page = visitorControl['page'] ? visitorControl['page'] : 0;
                var length = visitorControl['length'] ? visitorControl['length'] : 10;

                visitorControl['page'] = page;
                visitorControl['length'] = length;
            }

            localStorage.setItem("visitorControl", JSON.stringify(visitorControl));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
