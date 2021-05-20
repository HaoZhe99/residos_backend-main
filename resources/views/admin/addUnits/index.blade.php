@extends('layouts.admin')
@section('content')
@can('add_unit_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.add-units.create') }}">
                {{ trans('cruds.addUnit.title_singular') }}
            </a>
            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button> --}}
            {{-- @include('csvImport.modal', ['model' => 'AddUnit', 'route' => 'admin.add-units.parseCsvImport']) --}}
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.addUnit.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.addUnit.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.addUnit.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.addUnit.fields.block') }}</label>
                <input type="text" class="form-control" id="block"
                    placeholder="{{ trans('cruds.addUnit.fields.block') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.addUnit.fields.floor') }}</label>
                <input type="text" class="form-control" id="floor"
                    placeholder="{{ trans('cruds.addUnit.fields.floor') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.addUnit.fields.unit') }}</label>
                <input type="text" class="form-control" id="unit"
                    placeholder="{{ trans('cruds.addUnit.fields.unit') }}">
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
        {{ trans('cruds.addUnit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-AddUnit">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.block') }}
                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.floor') }}
                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.square') }}
                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.meter') }}
                    </th>
                    <th>
                        {{ trans('cruds.addUnit.fields.project_code') }}
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
@can('add_unit_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.add-units.massDestroy') }}",
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
        pageLength: localStorage.getItem("addUnit") ? JSON.parse(localStorage.getItem("addUnit"))['length'] ? JSON.parse(localStorage.getItem("addUnit"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.add-units.index') }}",
            data: function(d) {

               if (localStorage.getItem("addUnit") && firstTime) {
                    var addUnit = JSON.parse(localStorage.getItem("addUnit"));

                    var page = addUnit['page'] ? addUnit['page'] : 0;
                    var length = addUnit['length'] ? addUnit['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("addUnit")) {
                var addUnit = JSON.parse(localStorage.getItem("addUnit"));
                if (addUnit['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(addUnit['page']).draw(false);
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
            { data: 'block_block', name: 'block.block' },
            { data: 'floor', name: 'floor' },
            { data: 'unit', name: 'unit' },
            { data: 'square', name: 'square' },
            { data: 'meter', name: 'meter' },
            { data: 'project_code', name: 'project_code.project_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-AddUnit').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-AddUnit').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-AddUnit').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("addUnit")) {
                var addUnit = JSON.parse(localStorage.getItem("addUnit"));
            }

            addUnit['page'] = info.page;
            addUnit['length'] = info.length;

            localStorage.setItem("addUnit", JSON.stringify(addUnit));
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
            $('#search #block').val('');
            $('#search #floor').val('');
            $('#search #unit').val('');
        }

        function Default() {
            if (localStorage.getItem("addUnit")) {
                var searching = JSON.parse(localStorage.getItem("addUnit"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #block').val(searching['block'] ? searching['block'] : '');
                $('#search #floor').val(searching['floor'] ? searching['floor'] : '');
                $('#search #unit').val(searching['unit'] ? searching['unit'] : '');

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
                .columns(7)
                .search(project_code)
                .draw();

            var block = $('#search #block').val();
            table
                .columns(2)
                .search(block)
                .draw();

            var floor = $('#search #floor').val();
            table
                .columns(3)
                .search(floor)
                .draw();

            var unit = $('#search #unit').val();
            table
                .columns(4)
                .search(unit)
                .draw();

            var addUnit = {
                'project_code'  : project_code,
                'block'         : block,
                'floor'         : floor,
                'unit'          : unit
            };

            if (localStorage.getItem("addUnit") && firstTime) {
                var addUnit = JSON.parse(localStorage.getItem("addUnit"));

                var page = addUnit['page'] ? addUnit['page'] : 0;
                var length = addUnit['length'] ? addUnit['length'] : 10;

                addUnit['page'] = page;
                addUnit['length'] = length;
            }

            localStorage.setItem("addUnit", JSON.stringify(addUnit));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
