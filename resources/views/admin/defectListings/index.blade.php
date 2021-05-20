@extends('layouts.admin')
@section('content')
@can('defect_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.defect-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.defectListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.defectListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.defectListing.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.case_code') }}</label>
                <input type="text" class="form-control" id="case_code"
                    placeholder="{{ trans('cruds.defectListing.fields.case_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.category') }}</label>
                <input type="text" class="form-control" id="category"
                    placeholder="{{ trans('cruds.defectListing.fields.category') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.incharge_person') }}</label>
                <input type="text" class="form-control" id="incharge_person"
                    placeholder="{{ trans('cruds.defectListing.fields.incharge_person') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.contractor') }}</label>
                <input type="text" class="form-control" id="contractor"
                    placeholder="{{ trans('cruds.defectListing.fields.contractor') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-6">
                <label>{{ trans('cruds.defectListing.fields.date_range') }}</label>
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
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.status_control') }}</label>
                <input type="text" class="form-control" id="status"
                    placeholder="{{ trans('cruds.defectListing.fields.status_control') }}">
            </div>
            {{-- <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.defectListing.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\DefectListing::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div> --}}
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
        {{ trans('cruds.defectListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DefectListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.case_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.remark') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.incharge_person') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.contractor') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.status_control') }}
                    </th>
                    <th>
                        {{ trans('cruds.defectListing.fields.project_code') }}
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
@can('defect_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.defect-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("defectListing") ? JSON.parse(localStorage.getItem("defectListing"))['length'] ? JSON.parse(localStorage.getItem("defectListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.defect-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("defectListing") && firstTime) {
                    var defectListing = JSON.parse(localStorage.getItem("defectListing"));

                    var page = defectListing['page'] ? defectListing['page'] : 0;
                    var length = defectListing['length'] ? defectListing['length'] : 10;

                    d.start = page * length;
                }

                d.min_date = moment($('#min-date').val()).format('YYYY-MM-DD');
                d.max_date = moment($('#max-date').val()).format('YYYY-MM-DD');
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("defectListing")) {
                var defectListing = JSON.parse(localStorage.getItem("defectListing"));
                if (defectListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(defectListing['page']).draw(false);
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
            { data: 'case_code', name: 'case_code' },
            { data: 'category_defect_cateogry', name: 'category.defect_cateogry' },
            { data: 'description', name: 'description' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'date', name: 'date' },
            { data: 'time', name: 'time' },
            { data: 'remark', name: 'remark' },
            { data: 'incharge_person', name: 'incharge_person' },
            { data: 'contractor', name: 'contractor' },
            { data: 'status_control_status', name: 'status_control.status' },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-DefectListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-DefectListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-DefectListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("defectListing")) {
                var defectListing = JSON.parse(localStorage.getItem("defectListing"));
            }

            defectListing['page'] = info.page;
            defectListing['length'] = info.length;

            localStorage.setItem("defectListing", JSON.stringify(defectListing));
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
            $('#search #case_code').val('');
            $('#search #category').val('');
            $('#search #incharge_person').val('');
            $('#search #contractor').val('');
            $('#search #status').val('');
        }

        function Default() {
            if (localStorage.getItem("defectListing")) {
                var searching = JSON.parse(localStorage.getItem("defectListing"));

                // set min date / max date default value
                $('#search #min-date').val(searching['min-date'] ? searching['min-date'] : moment().format("YYYY-MM-DD"));
                $('#search #max-date').val(searching['max-date'] ? searching['max-date'] : moment().format("YYYY-MM-DD"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #case_code').val(searching['case_code'] ? searching['case_code'] : '');
                $('#search #category').val(searching['category'] ? searching['category'] : '');
                $('#search #incharge_person').val(searching['incharge_person'] ? searching['incharge_person'] : '');
                $('#search #contractor').val(searching['contractor'] ? searching['contractor'] : '');
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
                .columns(12)
                .search(project_code)
                .draw();

            var case_code = $('#search #case_code').val();
            table
                .columns(2)
                .search(case_code)
                .draw();

            var category = $('#search #category').val();
            table
                .columns(3)
                .search(category)
                .draw();

            var incharge_person = $('#search #incharge_person').val();
            table
                .columns(9)
                .search(incharge_person)
                .draw();

            var contractor = $('#search #contractor').val();
            table
                .columns(10)
                .search(contractor)
                .draw();

            var status = $('#search #status').val();
            table
                .columns(11)
                .search(status)
                .draw();

            var defectListing = {
                'project_code'      : project_code,
                'case_code'         : case_code,
                'category'          : category,
                'incharge_person'   : incharge_person,
                'contractor'        : contractor,
                'status'            : status,
                'min-date'          : $('#min-date').val(),
                'max-date'          : $('#max-date').val()
            };

            if (localStorage.getItem("defectListing") && firstTime) {
                var defectListing = JSON.parse(localStorage.getItem("defectListing"));

                var page = defectListing['page'] ? defectListing['page'] : 0;
                var length = defectListing['length'] ? defectListing['length'] : 10;

                defectListing['page'] = page;
                defectListing['length'] = length;
            }

            localStorage.setItem("defectListing", JSON.stringify(defectListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
