@extends('layouts.admin')
@section('content')
@can('vehicle_model_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.vehicle-models.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.vehicleModel.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.vehicleModel.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleModel.fields.brand') }}</label>
                <input type="text" class="form-control" id="brand"
                    placeholder="{{ trans('cruds.vehicleModel.fields.brand') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleModel.fields.model') }}</label>
                <input type="text" class="form-control" id="model"
                    placeholder="{{ trans('cruds.vehicleModel.fields.model') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.vehicleModel.fields.type') }}</label>
                <select class="form-control select2" id="type">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\VehicleModel::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 align-self-end">
                <button type="button" id="search_form_submit" class="btn btn-primary">
                    {{ trans('global.search') }}
                </button>
                <button type="button" id="reset" class="btn btn-danger">
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
                <button type="button" id="refresh_button" class="btn btn-light">
                    {{ trans('global.refresh') }} (<span id="countdown_number">15</span>)
                </button>
            </div>
        </div>
    </div>
</div>
{{-- /search --}}

<div class="card">
    <div class="card-header">
        {{ trans('cruds.vehicleModel.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-VehicleModel">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.brand') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.model') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.is_enable') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.color') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.variant') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.series') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.release_year') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.seat_capacity') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.length') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.width') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.height') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.wheel_base') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.kerb_weight') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.fuel_tank') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.front_brake') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.rear_brake') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.front_suspension') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.rear_suspension') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.steering') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.engine_cc') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.compression_ratio') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.peak_power_bhp') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.peak_torque_nm') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.engine_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.fuel_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.vehicleModel.fields.driven_wheel_drive') }}
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
@can('vehicle_model_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vehicle-models.massDestroy') }}",
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
        ajax: {
            url: "{{ route('admin.vehicle-models.index') }}",
        },
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'brand_brand', name: 'brand.brand' },
            { data: 'model', name: 'model' },
            { data: 'is_enable', name: 'is_enable' },
            { data: 'type', name: 'type' },
            { data: 'color', name: 'color' },
            { data: 'variant', name: 'variant' },
            { data: 'series', name: 'series' },
            { data: 'release_year', name: 'release_year' },
            { data: 'seat_capacity', name: 'seat_capacity' },
            { data: 'length', name: 'length' },
            { data: 'width', name: 'width' },
            { data: 'height', name: 'height' },
            { data: 'wheel_base', name: 'wheel_base' },
            { data: 'kerb_weight', name: 'kerb_weight' },
            { data: 'fuel_tank', name: 'fuel_tank' },
            { data: 'front_brake', name: 'front_brake' },
            { data: 'rear_brake', name: 'rear_brake' },
            { data: 'front_suspension', name: 'front_suspension' },
            { data: 'rear_suspension', name: 'rear_suspension' },
            { data: 'steering', name: 'steering' },
            { data: 'engine_cc', name: 'engine_cc' },
            { data: 'compression_ratio', name: 'compression_ratio' },
            { data: 'peak_power_bhp', name: 'peak_power_bhp' },
            { data: 'peak_torque_nm', name: 'peak_torque_nm' },
            { data: 'engine_type', name: 'engine_type' },
            { data: 'fuel_type', name: 'fuel_type' },
            { data: 'driven_wheel_drive', name: 'driven_wheel_drive' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 10,
    };
    let table = $('.datatable-VehicleModel').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $("#refresh_button").click(function() {
            table.ajax.reload(null, false);
        })

        var doUpdate = function() {
            if ($('#refresh').is(':checked')) {
                var count = parseInt($('#countdown_number').html());
                if (count !== 0) {
                    $('#countdown_number').html(count - 1);
                } else {
                    $('#refresh_button').click();
                    $('#countdown_number').html(15);
                }
            }
        };

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
//brand
        $('#search #brand').on('keyup', function() {
            table
                .columns(2)
                .search(this.value)
                .draw();
        });
//model
        $('#search #model').on('keyup', function() {
            table
                .columns(3)
                .search(this.value)
                .draw();
        });
//type
        $('#search #type').on('change', function() {
            var val = new Array();
            //set val to current element in the dropdown.
            val = $(this).val();

            if(jQuery.inArray("All", val) === -1) {
                searchingFunction(val, 5);
            } else {
                table
                    .columns(5)
                    .search('',true,false)
                    .draw();
            }
        });

        $('#search #type').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.vehicleModel.fields.type') }}",
            allowClear: true
        });
//reset button
        $("#reset").on('click', function() {
            $('#search #brand').val('').trigger('keyup');
            $('#search #model').val('').trigger('keyup');
            $('#search #type').val('0').trigger('change');

            $('#search_form_submit').click();
        })

        $("#reset").click();
// search button
        $('#search_form_submit').on('click', function() {
            $('#search #brand').keyup();
            $('#search #model').keyup();
            $('#search #type').change();
        })


});

</script>
@endsection
