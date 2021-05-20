@extends('layouts.admin')
@section('content')
@can('rent_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.rents.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.rent.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rent.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.tenant') }}</label>
                <input type="text" class="form-control" id="tenant"
                    placeholder="{{ trans('cruds.rent.fields.tenant') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.rent') }}</label>
                <input type="number" class="form-control" id="rent"
                    placeholder="{{ trans('cruds.rent.fields.rent') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.day_of_month') }}</label>
                <select class="form-control select2" id="day_of_month">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\Rent::DAY_OF_MONTH_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.leases') }}</label>
                <input type="number" class="form-control" id="leases"
                    placeholder="{{ trans('cruds.rent.fields.leases') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.bank_acc') }}</label>
                <input type="text" class="form-control" id="bank_acc"
                    placeholder="{{ trans('cruds.rent.fields.bank_acc') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.ststus') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\Rent::STSTUS_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.type') }}</label>
                <select class="form-control select2" id="type">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\Rent::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.slot_limit') }}</label>
                <input type="number" class="form-control" id="slot_limit"
                    placeholder="{{ trans('cruds.rent.fields.slot_limit') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.room_size') }}</label>
                <input type="text" class="form-control" id="room_size"
                    placeholder="{{ trans('cruds.rent.fields.room_size') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.unit_owner') }}</label>
                <input type="text" class="form-control" id="unit_owner"
                    placeholder="{{ trans('cruds.rent.fields.unit_owner') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.rent.fields.unit_code') }}</label>
                <input type="text" class="form-control" id="unit_code"
                    placeholder="{{ trans('cruds.rent.fields.unit_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-6">
                <label>{{ trans('cruds.rent.fields.date_range') }}</label>
                <div class="input-group">
                    <input type="date" class="form-control date-range-filter" id="min-date">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                    <input type="date" class="form-control date-range-filter" id="max-date">
                </div>
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
        {{ trans('cruds.rent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Rent">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.id') }}
                        </th>
                        <th>
                            Tenant
                        </th>
                        {{-- <th>
                            {{ trans('cruds.rent.fields.tenant') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.rent.fields.rent') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.day_of_month') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.leases') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.start_rent_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.end_rent_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.bank_acc') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.ststus') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.slot_limit') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.room_size') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.amenities') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.unit_owner') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.unit_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.rent.fields.image') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach($rents as $key => $rent)
                        <tr data-entry-id="{{ $rent->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $rent->id ?? '' }}
                            </td>
                            <td>
                                {{ $rent->tenant->name ?? '' }}
                            </td> --}}
                            {{-- <td>
                                {{ $rent->tenant ?? '' }}
                            </td> --}}
                            {{-- <td>
                                {{ $rent->rent_fee ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Rent::DAY_OF_MONTH_SELECT[$rent->day_of_month] ?? '' }}
                            </td>
                            <td>
                                {{ $rent->start_rent_day ?? '' }}
                            </td>
                            <td>
                                {{ $rent->bank_acc ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Rent::STSTUS_SELECT[$rent->status] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Rent::TYPE_SELECT[$rent->type] ?? '' }}
                            </td>
                            <td>
                                {{ $rent->slot_limit ?? '' }}
                            </td>
                            <td>
                                {{ $rent->room_size ?? '' }}
                            </td>
                            <td>
                                {{ $rent->remark ?? '' }}
                            </td>
                            <td>
                                @foreach($rent->amenities as $key => $item)
                                    <span class="badge badge-info">{{ $item->type }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $rent->unit_owner->owner->name ?? '' }}
                            </td>
                            <td>
                                {{ $rent->unit_owner->unit_code ?? '' }}
                            </td>
                            <td>
                                @foreach($rent->image as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('rent_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.rents.show', $rent->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('rent_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.rents.edit', $rent->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('rent_delete')
                                    <form action="{{ route('admin.rents.destroy', $rent->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('rent_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.rents.massDestroy') }}",
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
        pageLength: localStorage.getItem("rent") ? JSON.parse(localStorage.getItem("rent"))['length'] ? JSON.parse(localStorage.getItem("rent"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.rents.index') }}",
            data: function(d) {

                if (localStorage.getItem("rent") && firstTime) {
                    var rent = JSON.parse(localStorage.getItem("rent"));

                    var page = rent['page'] ? rent['page'] : 0;
                    var length = rent['length'] ? rent['length'] : 10;

                    d.start = page * length;
                }

                d.min_date = moment($('#min-date').val()).format('YYYY-MM-DD');
                d.max_date = moment($('#max-date').val()).format('YYYY-MM-DD');
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("rent")) {
                var rent = JSON.parse(localStorage.getItem("rent"));
                if (rent['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(rent['page']).draw(false);
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
            { data: 'tenant', name: 'tenant.name' },
            { data: 'rent_fee', name: 'rent_fee', className: "text-right" },
            { data: 'day_of_month', name: 'day_of_month' },
            { data: 'leases', name: 'leases' },
            {
                data: 'start_rent_day',
                name: 'start_rent_day',
                render: function(data, type, row) {
                    return moment(row['start_rent_day']).format('YYYY-MM-DD')
                }
            },
            {
                data: 'end_rent_day',
                name: 'end_rent_day',
                render: function(data, type, row) {
                    return moment(row['end_rent_day']).format('YYYY-MM-DD')
                }
            },
            { data: 'bank_acc', name: 'bank_acc' },
            { data: 'status', name: 'rents.status' },
            { data: 'type', name: 'type' },
            { data: 'slot_limit', name: 'slot_limit' },
            { data: 'room_size', name: 'room_size' },
            { data: 'remark', name: 'remark' },
            { data: 'amenities', name: 'amenities' },
            { data: 'unit_owner', name: 'unit_owner.unit_owner' },
            { data: 'unit_owner_unit_code', name: 'unit_owner.unit_code' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'actions', name: '{{ trans('global.action') }}' }
        ],
    }
//   let table = $('.datatable-Rent:not(.ajaxTable)').DataTable({ buttons: dtButtons })
//   $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
//       $($.fn.dataTable.tables(true)).DataTable()
//           .columns.adjust();
//   });

    let table = $('.datatable-Rent').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

        $('.datatable-Rent').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-Rent').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("rent")) {
                var rent = JSON.parse(localStorage.getItem("rent"));
            }

            rent['page'] = info.page;
            rent['length'] = info.length;

            localStorage.setItem("rent", JSON.stringify(rent));
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

        $('#search #day_of_month').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.rent.fields.day_of_month') }}",
            allowClear: true
        });

        $('#search #status').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.rent.fields.ststus') }}",
            allowClear: true
        });

        $('#search #type').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.rent.fields.type') }}",
            allowClear: true
        });

        var today = moment();

        $('#min-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            if (min.isAfter(today, 'days')) {
                $('#min-date').val(today.format("YYYY-MM-DD"))
                alert('Cannot choose over today')
            }

            if (min.isAfter(max, 'days') && min) {
                $('#max-date').val($('#min-date').val())
            }
        });
        $('#max-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            // if (max.isAfter(today, 'days')) {
            //     $('#max-date').val(today.format("YYYY-MM-DD"))
            //     alert('cannot choose over today')
            // }

            if (max.isBefore(min, 'days') && max) {
                $('#min-date').val($('#max-date').val())
            }
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
            // set min date / max date default value
            $('#min-date').val(moment().format("YYYY-MM-DD"));
            $('#max-date').val(moment().format("YYYY-MM-DD"));

            $('#search #tenant').val('');
            $('#search #rent').val('');
            $('#search #bank_acc').val('');
            $('#search #slot_limit').val('');
            $('#search #room_size').val('');
            $('#search #unit_owner').val('');
            $('#search #unit_code').val('');

            $('#search #day_of_month').val('All').trigger('change');
            $('#search #status').val('All').trigger('change');
            $('#search #type').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("rent")) {
                var searching = JSON.parse(localStorage.getItem("rent"));

                // set min date / max date default value
                $('#search #min-date').val(searching['min-date'] ? searching['min-date'] : moment().format("YYYY-MM-DD"));
                $('#search #max-date').val(searching['max-date'] ? searching['max-date'] : moment().format("YYYY-MM-DD"));

                $('#search #tenant').val(searching['tenant'] ? searching['tenant'] : '');
                $('#search #rent').val(searching['rent'] ? searching['rent'] : '');
                $('#search #bank_acc').val(searching['bank_acc'] ? searching['bank_acc'] : '');
                $('#search #slot_limit').val(searching['slot_limit'] ? searching['slot_limit'] : '');
                $('#search #room_size').val(searching['room_size'] ? searching['room_size'] : '');
                $('#search #unit_owner').val(searching['unit_owner'] ? searching['unit_owner'] : '');
                $('#search #unit_code').val(searching['unit_code'] ? searching['unit_code'] : '');

                $('#search #day_of_month').val(searching['day_of_month'] ? searching['day_of_month'] : 'All').trigger('change');
                $('#search #status').val(searching['status'] ? searching['status'] : 'All').trigger('change');
                $('#search #type').val(searching['type'] ? searching['type'] : 'All').trigger('change');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var tenant = $('#search #tenant').val();
            table
                .columns(2)
                .search(tenant)
                .draw();

            var rent = $('#search #rent').val();
            table
                .columns(3)
                .search(rent)
                .draw();

            var day_of_month = $('#search #day_of_month').val();
            if(jQuery.inArray("All", day_of_month) === -1) {
                searchingFunction(day_of_month, 4);
            } else {
                table
                    .columns(4)
                    .search('',true,false)
                    .draw();
            }

            var bank_acc = $('#search #bank_acc').val();
            table
                .columns(6)
                .search(bank_acc)
                .draw();

            var status = $('#search #status').val();
            if(jQuery.inArray("All", status) === -1) {
                searchingFunction(status, 7);
            } else {
                table
                    .columns(7)
                    .search('',true,false)
                    .draw();
            }

            var type = $('#search #type').val();
            if(jQuery.inArray("All", type) === -1) {
                searchingFunction(type, 8);
            } else {
                table
                    .columns(8)
                    .search('',true,false)
                    .draw();
            }

            var slot_limit = $('#search #slot_limit').val();
            table
                .columns(9)
                .search(slot_limit)
                .draw();

            var room_size = $('#search #room_size').val();
            table
                .columns(10)
                .search(room_size)
                .draw();

            var unit_owner = $('#search #unit_owner').val();
            table
                .columns(13)
                .search(unit_owner)
                .draw();

            var unit_code = $('#search #unit_code').val();
            table
                .columns(14)
                .search(unit_code)
                .draw();

            var rent = {
                'tenant'       : tenant,
                'rent'         : rent,
                'day_of_month' : day_of_month,
                'bank_acc'     : bank_acc,
                'status'       : status,
                'type'         : type,
                'slot_limit'   : slot_limit,
                'room_size'    : room_size,
                'unit_owner'   : unit_owner,
                'unit_code'    : unit_code,
                'min-date'     : $('#min-date').val(),
                'max-date'     : $('#max-date').val()
            };

            if (localStorage.getItem("rent") && firstTime) {
                var rent = JSON.parse(localStorage.getItem("rent"));

                var page = rent['page'] ? rent['page'] : 0;
                var length = rent['length'] ? rent['length'] : 10;

                rent['page'] = page;
                rent['length'] = length;
            }

            localStorage.setItem("rent", JSON.stringify(rent));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
