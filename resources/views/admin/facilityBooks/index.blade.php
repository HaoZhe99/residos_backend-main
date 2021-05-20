@extends('layouts.admin')
@section('content')
@can('facility_book_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.facility-books.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.facilityBook.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.facilityBook.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityBook.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.facilityBook.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityBook.fields.facility_code') }}</label>
                <input type="text" class="form-control" id="facility_code"
                    placeholder="{{ trans('cruds.facilityBook.fields.facility_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityBook.fields.username') }}</label>
                <input type="text" class="form-control" id="username"
                    placeholder="{{ trans('cruds.facilityBook.fields.username') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityBook.fields.status') }}</label>
                <input type="text" class="form-control" id="status"
                    placeholder="{{ trans('cruds.facilityBook.fields.status') }}">
            </div>
            {{-- <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityBook.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\FacilityBook::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div> --}}
            <div class="form-group col-12 col-lg-6 col-xl-6">
                <label>{{ trans('cruds.facilityBook.fields.date_range') }}</label>
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
        {{ trans('cruds.facilityBook.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FacilityBook">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.username') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityBook.fields.facility_code') }}
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
    @can('facility_book_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.facility-books.massDestroy') }}",
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
        pageLength: localStorage.getItem("facilityBook") ? JSON.parse(localStorage.getItem("facilityBook"))['length'] ? JSON.parse(localStorage.getItem("facilityBook"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.facility-books.index') }}",
            data: function(d) {

                if (localStorage.getItem("facilityBook") && firstTime) {
                    var facilityBook = JSON.parse(localStorage.getItem("facilityBook"));

                    var page = facilityBook['page'] ? facilityBook['page'] : 0;
                    var length = facilityBook['length'] ? facilityBook['length'] : 10;

                    d.start = page * length;
                }

                d.min_date = moment($('#min-date').val()).format('YYYY-MM-DD');
                d.max_date = moment($('#max-date').val()).format('YYYY-MM-DD');
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("facilityBook")) {
                var facilityBook = JSON.parse(localStorage.getItem("facilityBook"));
                if (facilityBook['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(facilityBook['page']).draw(false);
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
            { data: 'date', name: 'date', },
            { data: 'time', name: 'time' },
            { data: 'status', name: 'status' },
            { data: 'username_name', name: 'username.name' },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'facility_code_facility_code', name: 'facility_code.facility_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-FacilityBook').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

        $('.datatable-FacilityBook').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-FacilityBook').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("facilityBook")) {
                var facilityBook = JSON.parse(localStorage.getItem("facilityBook"));
            }

            facilityBook['page'] = info.page;
            facilityBook['length'] = info.length;

            localStorage.setItem("facilityBook", JSON.stringify(facilityBook));
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

        var today = moment();

        $('#min-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            if (min.isAfter(today, 'days')) {
                $('#min-date').val(today.format("YYYY-MM-DD"))
                alert('cannot choose over today')
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

            $('#search #project_code').val('');
            $('#search #facility_code').val('');
            $('#search #username').val('');
            $('#search #status').val('');
        }

        function Default() {
            if (localStorage.getItem("facilityBook")) {
                var searching = JSON.parse(localStorage.getItem("facilityBook"));

                // set min date / max date default value
                $('#search #min-date').val(searching['min-date'] ? searching['min-date'] : moment().format("YYYY-MM-DD"));
                $('#search #max-date').val(searching['max-date'] ? searching['max-date'] : moment().format("YYYY-MM-DD"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #facility_code').val(searching['facility_code'] ? searching['facility_code'] : '');
                $('#search #username').val(searching['username'] ? searching['username'] : '');
                $('#search #status').val(searching['status'] ? searching['status'] : '');

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
                .columns(6)
                .search(project_code)
                .draw();

            var facility_code = $('#search #facility_code').val();
            table
                .columns(7)
                .search(facility_code)
                .draw();

            var username = $('#search #username').val();
            table
                .columns(5)
                .search(username)
                .draw();

            var status = $('#search #status').val();
            table
                .columns(4)
                .search(status)
                .draw();

            var facilityBook = {
                'project_code'  : project_code,
                'facility_code' : facility_code,
                'username'      : username,
                'status'        : status,
                'min-date'      : $('#min-date').val(),
                'max-date'      : $('#max-date').val()
            };

            if (localStorage.getItem("facilityBook") && firstTime) {
                var facilityBook = JSON.parse(localStorage.getItem("facilityBook"));

                var page = facilityBook['page'] ? facilityBook['page'] : 0;
                var length = facilityBook['length'] ? facilityBook['length'] : 10;

                facilityBook['page'] = page;
                facilityBook['length'] = length;
            }

            localStorage.setItem("facilityBook", JSON.stringify(facilityBook));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
