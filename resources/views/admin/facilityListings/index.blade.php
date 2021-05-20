@extends('layouts.admin')
@section('content')
@can('facility_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.facility-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.facilityListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.facilityListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityListing.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.facilityListing.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityListing.fields.facility_code') }}</label>
                <input type="text" class="form-control" id="facility_code"
                    placeholder="{{ trans('cruds.facilityListing.fields.facility_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityListing.fields.name') }}</label>
                <input type="text" class="form-control" id="name"
                    placeholder="{{ trans('cruds.facilityListing.fields.name') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityListing.fields.category') }}</label>
                <input type="text" class="form-control" id="category"
                    placeholder="{{ trans('cruds.facilityListing.fields.category') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityListing.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\FacilityListing::STATUS_SELECT as $key => $label)
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
        </div>
    </div>
</div>
{{-- /search --}}

<div class="card">
    <div class="card-header">
        {{ trans('cruds.facilityListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FacilityListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.facility_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.open') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.closed') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityListing.fields.project_code') }}
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
@can('facility_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.facility-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("facilityListing") ? JSON.parse(localStorage.getItem("facilityListing"))['length'] ? JSON.parse(localStorage.getItem("facilityListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.facility-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("facilityListing") && firstTime) {
                    var facilityListing = JSON.parse(localStorage.getItem("facilityListing"));

                    var page = facilityListing['page'] ? facilityListing['page'] : 0;
                    var length = facilityListing['length'] ? facilityListing['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("facilityListing")) {
                var facilityListing = JSON.parse(localStorage.getItem("facilityListing"));
                if (facilityListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(facilityListing['page']).draw(false);
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
            { data: 'facility_code', name: 'facility_code' },
            { data: 'name', name: 'name' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'status', name: 'status' },
            { data: 'open', name: 'open' },
            { data: 'closed', name: 'closed' },
            { data: 'category_category', name: 'category.category' },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };

    let table = $('.datatable-FacilityListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

        $('.datatable-FacilityListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-FacilityListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("facilityListing")) {
                var facilityListing = JSON.parse(localStorage.getItem("facilityListing"));
            }

            facilityListing['page'] = info.page;
            facilityListing['length'] = info.length;

            localStorage.setItem("facilityListing", JSON.stringify(facilityListing));
        }

        $('#search #status').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.facilityListing.fields.status') }}",
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
            $('#search #facility_code').val('');
            $('#search #name').val('');
            $('#search #category').val('');

            $('#search #status').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("facilityListing")) {
                var searching = JSON.parse(localStorage.getItem("facilityListing"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #facility_code').val(searching['facility_code'] ? searching['facility_code'] : '');
                $('#search #name').val(searching['name'] ? searching['name'] : '');
                $('#search #category').val(searching['category'] ? searching['category'] : '');

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
                .columns(9)
                .search(project_code)
                .draw();

            var facility_code = $('#search #facility_code').val();
            table
                .columns(2)
                .search(facility_code)
                .draw();

            var name = $('#search #name').val();
            table
                .columns(3)
                .search(name)
                .draw();

            var category = $('#search #category').val();
            table
                .columns(8)
                .search(category)
                .draw();

            var status = $('#search #status').val();
            if(jQuery.inArray("All", status) === -1) {
                searchingFunction(status, 5);
            } else {
                table
                    .columns(5)
                    .search('',true,false)
                    .draw();
            }

            var facilityListing = {
                'project_code'  : project_code,
                'facility_code' : facility_code,
                'name'          : name,
                'category'      : category,
                'status'        : status
            };

            if (localStorage.getItem("facilityListing") && firstTime) {
                var facilityListing = JSON.parse(localStorage.getItem("facilityListing"));

                var page = facilityListing['page'] ? facilityListing['page'] : 0;
                var length = facilityListing['length'] ? facilityListing['length'] : 10;

                facilityListing['page'] = page;
                facilityListing['length'] = length;
            }

            localStorage.setItem("facilityListing", JSON.stringify(facilityListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
