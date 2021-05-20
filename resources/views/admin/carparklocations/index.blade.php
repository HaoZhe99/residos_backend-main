@extends('layouts.admin')
@section('content')
@can('carparklocation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.carparklocations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carparklocation.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carparklocation.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.carparklocation.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.carparklocation.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.carparklocation.fields.location_code') }}</label>
                <input type="text" class="form-control" id="location_code"
                    placeholder="{{ trans('cruds.carparklocation.fields.location_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.carparklocation.fields.location') }}</label>
                <input type="text" class="form-control" id="location"
                    placeholder="{{ trans('cruds.carparklocation.fields.location') }}">
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
        {{ trans('cruds.carparklocation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Carparklocation">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.carparklocation.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.carparklocation.fields.location') }}
                    </th>
                    <th>
                        {{ trans('cruds.carparklocation.fields.is_enable') }}
                    </th>
                    <th>
                        {{ trans('cruds.carparklocation.fields.location_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.carparklocation.fields.project_code') }}
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
@can('carparklocation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.carparklocations.massDestroy') }}",
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
        pageLength: localStorage.getItem("carparkLocation") ? JSON.parse(localStorage.getItem("carparkLocation"))['length'] ? JSON.parse(localStorage.getItem("carparkLocation"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.carparklocations.index') }}",
            data: function(d) {

                if (localStorage.getItem("carparkLocation") && firstTime) {
                    var carparkLocation = JSON.parse(localStorage.getItem("carparkLocation"));

                    var page = carparkLocation['page'] ? carparkLocation['page'] : 0;
                    var length = carparkLocation['length'] ? carparkLocation['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("carparkLocation")) {
                var carparkLocation = JSON.parse(localStorage.getItem("carparkLocation"));
                if (carparkLocation['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(carparkLocation['page']).draw(false);
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
            { data: 'location', name: 'location' },
            { data: 'is_enable', name: 'is_enable' },
            { data: 'location_code', name: 'location_code' },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-Carparklocation').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-Carparklocation').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-Carparklocation').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("carparkLocation")) {
                var carparkLocation = JSON.parse(localStorage.getItem("carparkLocation"));
            }

            carparkLocation['page'] = info.page;
            carparkLocation['length'] = info.length;

            localStorage.setItem("carparkLocation", JSON.stringify(carparkLocation));
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
            $('#search #project_code').val('');
            $('#search #location_code').val('');
            $('#search #location').val('');
        }

        function Default() {
            if (localStorage.getItem("carparkLocation")) {
                var searching = JSON.parse(localStorage.getItem("carparkLocation"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #location_code').val(searching['location_code'] ? searching['location_code'] : '');
                $('#search #location').val(searching['location'] ? searching['location'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var project_code = $('#search #project_code').val();
            table
                .columns(5)
                .search(project_code)
                .draw();

            var location_code = $('#search #location_code').val();
            table
                .columns(4)
                .search(location_code)
                .draw();

            var location = $('#search #location').val();
            table
                .columns(2)
                .search(location)
                .draw();

            var carparkLocation = {
                'project_code'   : project_code,
                'location_code'  : location_code,
                'location'       : location
            };

            if (localStorage.getItem("carparkLocation") && firstTime) {
                var carparkLocation = JSON.parse(localStorage.getItem("carparkLocation"));

                var page = carparkLocation['page'] ? carparkLocation['page'] : 0;
                var length = carparkLocation['length'] ? carparkLocation['length'] : 10;

                carparkLocation['page'] = page;
                carparkLocation['length'] = length;
            }

            localStorage.setItem("carparkLocation", JSON.stringify(carparkLocation));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
