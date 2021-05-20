@extends('layouts.admin')
@section('content')
@can('state_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.states.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.state.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.state.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.state.fields.country') }}</label>
                <input type="text" class="form-control" id="country"
                    placeholder="{{ trans('cruds.state.fields.country') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.country.fields.short_code') }}</label>
                <input type="text" class="form-control" id="short_code"
                    placeholder="{{ trans('cruds.country.fields.short_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.state.fields.states') }}</label>
                <input type="text" class="form-control" id="state"
                    placeholder="{{ trans('cruds.state.fields.states') }}">
            </div>
            <div class="form-group col-12 col-lg-6 align-self-end">
                <button type="button" id="search_form_submit" class="btn btn-primary btn_controller" disabled>
                    {{ trans('global.search') }}
                </button>
                <button type="button" id="reset" class="btn btn-danger btn_controller" disabled>
                    {{ trans('global.reset') }}
                </button>
            </div>
        </div>
    </div>
</div>
{{-- /search --}}

<div class="card">
    <div class="card-header">
        {{ trans('cruds.state.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-State">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.state.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.state.fields.country') }}
                    </th>
                    <th>
                        {{ trans('cruds.country.fields.short_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.state.fields.states') }}
                    </th>
                    <th>
                        {{ trans('cruds.state.fields.is_enable') }}
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
@can('state_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.states.massDestroy') }}",
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
        pageLength: localStorage.getItem("state") ? JSON.parse(localStorage.getItem("state"))['length'] ? JSON.parse(localStorage.getItem("state"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.states.index') }}",
            data: function(d) {

                if (localStorage.getItem("state") && firstTime) {
                    var state = JSON.parse(localStorage.getItem("state"));

                    var page = state['page'] ? state['page'] : 0;
                    var length = state['length'] ? state['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("state")) {
                var state = JSON.parse(localStorage.getItem("state"));
                if (state['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(state['page']).draw(false);
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
            { data: 'country_name', name: 'country.name' },
            { data: 'country.short_code', name: 'country.short_code' },
            { data: 'states', name: 'states' },
            { data: 'is_enable', name: 'is_enable' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-State').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-State').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-State').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("state")) {
                var state = JSON.parse(localStorage.getItem("state"));
            }

            state['page'] = info.page;
            state['length'] = info.length;

            localStorage.setItem("state", JSON.stringify(state));
        }

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
            $('#search #country').val('');
            $('#search #short_code').val('');
            $('#search #state').val('');
        }

        function Default() {
            if (localStorage.getItem("state")) {
                var searching = JSON.parse(localStorage.getItem("state"));

                $('#search #country').val(searching['country'] ? searching['country'] : '');
                $('#search #short_code').val(searching['short_code'] ? searching['short_code'] : '');
                $('#search #state').val(searching['state'] ? searching['state'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var country = $('#search #country').val();
            table
                .columns(2)
                .search(country)
                .draw();

            var short_code = $('#search #short_code').val();
            table
                .columns(3)
                .search(short_code)
                .draw();

            var state = $('#search #state').val();
            table
                .columns(4)
                .search(state)
                .draw();

            var state = {
                'country'       : country,
                'short_code'    : short_code,
                'state'         : state
            };

            if (localStorage.getItem("state") && firstTime) {
                var state = JSON.parse(localStorage.getItem("state"));

                var page = state['page'] ? state['page'] : 0;
                var length = state['length'] ? state['length'] : 10;

                state['page'] = page;
                state['length'] = length;
            }

            localStorage.setItem("state", JSON.stringify(state));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
