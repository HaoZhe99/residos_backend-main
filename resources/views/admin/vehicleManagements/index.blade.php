@extends('layouts.admin')
@section('content')
@can('vehicle_management_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.vehicle-managements.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.vehicleManagement.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.vehicleManagement.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleManagement.fields.car_plate') }}</label>
                <input type="text" class="form-control" id="car_plate"
                    placeholder="{{ trans('cruds.vehicleManagement.fields.car_plate') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleManagement.fields.driver') }}</label>
                <input type="text" class="form-control" id="driver"
                    placeholder="{{ trans('cruds.vehicleManagement.fields.driver') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleManagement.fields.user') }}</label>
                <input type="text" class="form-control" id="user"
                    placeholder="{{ trans('cruds.vehicleManagement.fields.user') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleManagement.fields.carpark_location') }}</label>
                <input type="text" class="form-control" id="carpark_location"
                    placeholder="{{ trans('cruds.vehicleManagement.fields.carpark_location') }}">
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
        {{ trans('cruds.vehicleManagement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-VehicleManagement">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.car_plate') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.is_verify') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.is_season_park') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.is_resident') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.color') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.driver') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.carpark_location') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.brand') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleManagement.fields.model') }}
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
@can('vehicle_management_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vehicle-managements.massDestroy') }}",
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
        pageLength: localStorage.getItem("vehicleManagement") ? JSON.parse(localStorage.getItem("vehicleManagement"))['length'] ? JSON.parse(localStorage.getItem("vehicleManagement"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.vehicle-managements.index') }}",
            data: function(d) {

                if (localStorage.getItem("vehicleManagement") && firstTime) {
                    var vehicleManagement = JSON.parse(localStorage.getItem("vehicleManagement"));

                    var page = vehicleManagement['page'] ? vehicleManagement['page'] : 0;
                    var length = vehicleManagement['length'] ? vehicleManagement['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("vehicleManagement")) {
                var vehicleManagement = JSON.parse(localStorage.getItem("vehicleManagement"));
                if (vehicleManagement['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(vehicleManagement['page']).draw(false);
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
            { data: 'car_plate', name: 'car_plate' },
            { data: 'is_verify', name: 'is_verify' },
            { data: 'is_season_park', name: 'is_season_park' },
            { data: 'is_resident', name: 'is_resident' },
            { data: 'color', name: 'color' },
            { data: 'driver', name: 'driver' },
            { data: 'user_name', name: 'user.name' },
            { data: 'carpark_location_location', name: 'carpark_location.location' },
            { data: 'brand_brand', name: 'brand.brand' },
            { data: 'model_model', name: 'model.model' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-VehicleManagement').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-VehicleManagement').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-VehicleManagement').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("vehicleManagement")) {
                var vehicleManagement = JSON.parse(localStorage.getItem("vehicleManagement"));
            }

            vehicleManagement['page'] = info.page;
            vehicleManagement['length'] = info.length;

            localStorage.setItem("vehicleManagement", JSON.stringify(vehicleManagement));
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
            $('#search #car_plate').val('');
            $('#search #driver').val('');
            $('#search #user').val('');
            $('#search #carpark_location').val('');
        }

        function Default() {
            if (localStorage.getItem("vehicleManagement")) {
                var searching = JSON.parse(localStorage.getItem("vehicleManagement"));

                $('#search #car_plate').val(searching['car_plate'] ? searching['car_plate'] : '');
                $('#search #driver').val(searching['driver'] ? searching['driver'] : '');
                $('#search #user').val(searching['user'] ? searching['user'] : '');
                $('#search #carpark_location').val(searching['carpark_location'] ? searching['carpark_location'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var car_plate = $('#search #car_plate').val();
            table
                .columns(2)
                .search(car_plate)
                .draw();

            var driver = $('#search #driver').val();
            table
                .columns(7)
                .search(driver)
                .draw();

            var user = $('#search #user').val();
            table
                .columns(8)
                .search(user)
                .draw();

            var carpark_location = $('#search #carpark_location').val();
            table
                .columns(9)
                .search(carpark_location)
                .draw();

            var vehicleManagement = {
                'car_plate'        : car_plate,
                'driver'           : driver,
                'user'             : user,
                'carpark_location' : carpark_location
            };

            if (localStorage.getItem("vehicleManagement") && firstTime) {
                var vehicleManagement = JSON.parse(localStorage.getItem("vehicleManagement"));

                var page = vehicleManagement['page'] ? vehicleManagement['page'] : 0;
                var length = vehicleManagement['length'] ? vehicleManagement['length'] : 10;

                vehicleManagement['page'] = page;
                vehicleManagement['length'] = length;
            }

            localStorage.setItem("vehicleManagement", JSON.stringify(vehicleManagement));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
