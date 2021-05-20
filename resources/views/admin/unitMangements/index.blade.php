@extends('layouts.admin')
@section('content')
@can('unit_mangement_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.unit-mangements.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.unitMangement.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.unitMangement.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.unitMangement.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.unitMangement.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.unitMangement.fields.unit_code') }}</label>
                <input type="text" class="form-control" id="unit_code"
                    placeholder="{{ trans('cruds.unitMangement.fields.unit_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.unitMangement.fields.unit') }}</label>
                <input type="text" class="form-control" id="unit"
                    placeholder="{{ trans('cruds.unitMangement.fields.unit') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.unitMangement.fields.owner') }}</label>
                <input type="text" class="form-control" id="owner"
                    placeholder="{{ trans('cruds.unitMangement.fields.owner') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.unitMangement.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\UnitManagement::STATUS_SELECT as $key => $label)
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
        {{ trans('cruds.unitMangement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-UnitMangement">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.unit_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.floor_size') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.bed_room') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.toilet') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.unitMangement.fields.floor_level') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.unitMangement.fields.carpark_slot') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.bumi_lot') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.unitMangement.fields.block') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.unitMangement.fields.owner') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.unitMangement.fields.balcony') }}
                    </th>
                    <th>
                        SPA
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
@can('unit_mangement_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.unit-mangements.massDestroy') }}",
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
        pageLength: localStorage.getItem("unitManagement") ? JSON.parse(localStorage.getItem("unitManagement"))['length'] ? JSON.parse(localStorage.getItem("unitManagement"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.unit-mangements.index') }}",
            data: function(d) {

                if (localStorage.getItem("unitManagement") && firstTime) {
                    var unitManagement = JSON.parse(localStorage.getItem("unitManagement"));

                    var page = unitManagement['page'] ? unitManagement['page'] : 0;
                    var length = unitManagement['length'] ? unitManagement['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("unitManagement")) {
                var unitManagement = JSON.parse(localStorage.getItem("unitManagement"));
                if (unitManagement['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(unitManagement['page']).draw(false);
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
            { data: 'project_code', name: 'project_code.project_code' },
            { data: 'unit_code', name: 'unit_code' },
            { data: 'unit', name: 'unit.unit' },
            { data: 'floor_size', name: 'floor_size' },
            { data: 'bed_room', name: 'bed_room' },
            { data: 'toilet', name: 'toilet' },
            // { data: 'floor_level', name: 'floor_level' },
            { data: 'carpark_slot', name: 'carpark_slot' },
            { data: 'bumi_lot', name: 'bumi_lot' },
            // { data: 'block', name: 'block' },
            { data: 'owner', name: 'owner.name' },
            { data: 'status', name: 'status' },
            { data: 'balcony', name: 'balcony' },
            { data: 'spa', name: 'spa', sortable: false, searchable: false },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-UnitMangement').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-UnitMangement').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-UnitMangement').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("unitManagement")) {
                var unitManagement = JSON.parse(localStorage.getItem("unitManagement"));
            }

            unitManagement['page'] = info.page;
            unitManagement['length'] = info.length;

            localStorage.setItem("unitManagement", JSON.stringify(unitManagement));
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
            placeholder: "{{ trans('cruds.unitMangement.fields.status') }}",
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
            $('#search #project_code').val('');
            $('#search #unit_code').val('');
            $('#search #unit').val('');
            $('#search #owner').val('');

            $('#search #status').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("unitManagement")) {
                var searching = JSON.parse(localStorage.getItem("unitManagement"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #unit_code').val(searching['unit_code'] ? searching['unit_code'] : '');
                $('#search #unit').val(searching['unit'] ? searching['unit'] : '');
                $('#search #owner').val(searching['owner'] ? searching['owner'] : '');

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

            var project_code = $('#search #project_code').val();
            table
                .columns(2)
                .search(project_code)
                .draw();

            var unit_code = $('#search #unit_code').val();
            table
                .columns(3)
                .search(unit_code)
                .draw();

            var unit = $('#search #unit').val();
            table
                .columns(4)
                .search(unit)
                .draw();

            var owner = $('#search #owner').val();
            table
                .columns(10)
                .search(owner)
                .draw();

            var status = $('#search #status').val();
            if(jQuery.inArray("All", status) === -1) {
                searchingFunction(status, 11);
            } else {
                table
                    .columns(11)
                    .search('',true,false)
                    .draw();
            }

            var unitManagement = {
                'project_code'  : project_code,
                'unit_code'     : unit_code,
                'unit'          : unit,
                'owner'         : owner,
                'status'        : status
            };

            if (localStorage.getItem("unitManagement") && firstTime) {
                var unitManagement = JSON.parse(localStorage.getItem("unitManagement"));

                var page = unitManagement['page'] ? unitManagement['page'] : 0;
                var length = unitManagement['length'] ? unitManagement['length'] : 10;

                unitManagement['page'] = page;
                unitManagement['length'] = length;
            }

            localStorage.setItem("unitManagement", JSON.stringify(unitManagement));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
