@extends('layouts.admin')
@section('content')
@can('event_enroll_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.event-enrolls.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eventEnroll.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.eventEnroll.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventEnroll.fields.event_code') }}</label>
                <input type="text" class="form-control" id="event_code"
                    placeholder="{{ trans('cruds.eventEnroll.fields.event_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventEnroll.fields.username') }}</label>
                <input type="text" class="form-control" id="username"
                    placeholder="{{ trans('cruds.eventEnroll.fields.username') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventEnroll.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\EventEnroll::STATUS_SELECT as $key => $label)
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
        {{ trans('cruds.eventEnroll.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EventEnroll">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.eventEnroll.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventEnroll.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventEnroll.fields.username') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventEnroll.fields.event_code') }}
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
        var firstTime = true;
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('event_enroll_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.event-enrolls.massDestroy') }}",
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
        pageLength: localStorage.getItem("eventEnroll") ? JSON.parse(localStorage.getItem("eventEnroll"))['length'] ? JSON.parse(localStorage.getItem("eventEnroll"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.event-enrolls.index') }}",
            data: function(d) {

                if (localStorage.getItem("eventEnroll") && firstTime) {
                    var eventEnroll = JSON.parse(localStorage.getItem("eventEnroll"));

                    var page = eventEnroll['page'] ? eventEnroll['page'] : 0;
                    var length = eventEnroll['length'] ? eventEnroll['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("eventEnroll")) {
                var eventEnroll = JSON.parse(localStorage.getItem("eventEnroll"));
                if (eventEnroll['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(eventEnroll['page']).draw(false);
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
            { data: 'status', name: 'event_enrolls.status' },
            { data: 'username_name', name: 'username.name' },
            { data: 'event_code_event_code', name: 'event_code.event_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-EventEnroll').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-EventEnroll').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-EventEnroll').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("eventEnroll")) {
                var eventEnroll = JSON.parse(localStorage.getItem("eventEnroll"));
            }

            eventEnroll['page'] = info.page;
            eventEnroll['length'] = info.length;

            localStorage.setItem("eventEnroll", JSON.stringify(eventEnroll));
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
            placeholder: "{{ trans('cruds.eventEnroll.fields.status') }}",
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
            $('#search #event_code').val('');
            $('#search #username').val('');

            $('#search #status').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("eventEnroll")) {
                var searching = JSON.parse(localStorage.getItem("eventEnroll"));

                $('#search #event_code').val(searching['event_code'] ? searching['event_code'] : '');
                $('#search #username').val(searching['username'] ? searching['username'] : '');

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

            var event_code = $('#search #event_code').val();
            table
                .columns(4)
                .search(event_code)
                .draw();

            var username = $('#search #username').val();
            table
                .columns(3)
                .search(username)
                .draw();

            var status = $('#search #status').val();
            if(jQuery.inArray("All", status) === -1) {
                searchingFunction(status, 2);
            } else {
                table
                    .columns(2)
                    .search('',true,false)
                    .draw();
            }

            var eventEnroll = {
                'event_code'  : event_code,
                'username'    : username,
                'status'      : status
            };

            if (localStorage.getItem("eventEnroll") && firstTime) {
                var eventEnroll = JSON.parse(localStorage.getItem("eventEnroll"));

                var page = eventEnroll['page'] ? eventEnroll['page'] : 0;
                var length = eventEnroll['length'] ? eventEnroll['length'] : 10;

                eventEnroll['page'] = page;
                eventEnroll['length'] = length;
            }

            localStorage.setItem("eventEnroll", JSON.stringify(eventEnroll));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
