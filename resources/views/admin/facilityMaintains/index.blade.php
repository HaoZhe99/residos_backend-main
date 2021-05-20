@extends('layouts.admin')
@section('content')
@can('facility_maintain_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.facility-maintains.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.facilityMaintain.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.facilityMaintain.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityMaintain.fields.facility_code') }}</label>
                <input type="text" class="form-control" id="facility_code"
                    placeholder="{{ trans('cruds.facilityMaintain.fields.facility_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.facilityMaintain.fields.username') }}</label>
                <input type="text" class="form-control" id="username"
                    placeholder="{{ trans('cruds.facilityMaintain.fields.username') }}">
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
        {{ trans('cruds.facilityMaintain.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FacilityMaintain">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.facilityMaintain.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityMaintain.fields.remark') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityMaintain.fields.username') }}
                    </th>
                    <th>
                        {{ trans('cruds.facilityMaintain.fields.facility_code') }}
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
@can('facility_maintain_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.facility-maintains.massDestroy') }}",
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
        pageLength: localStorage.getItem("facilityMaintain") ? JSON.parse(localStorage.getItem("facilityMaintain"))['length'] ? JSON.parse(localStorage.getItem("facilityMaintain"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.facility-maintains.index') }}",
            data: function(d) {

                if (localStorage.getItem("facilityMaintain") && firstTime) {
                    var facilityMaintain = JSON.parse(localStorage.getItem("facilityMaintain"));

                    var page = facilityMaintain['page'] ? facilityMaintain['page'] : 0;
                    var length = facilityMaintain['length'] ? facilityMaintain['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("facilityMaintain")) {
                var facilityMaintain = JSON.parse(localStorage.getItem("facilityMaintain"));
                if (facilityMaintain['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(facilityMaintain['page']).draw(false);
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
            { data: 'remark', name: 'remark' },
            { data: 'username_name', name: 'username.name' },
            { data: 'facility_code_facility_code', name: 'facility_code.facility_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}'}
        ],
    };
    let table = $('.datatable-FacilityMaintain').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-FacilityMaintain').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-FacilityMaintain').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("facilityMaintain")) {
                var facilityMaintain = JSON.parse(localStorage.getItem("facilityMaintain"));
            }

            facilityMaintain['page'] = info.page;
            facilityMaintain['length'] = info.length;

            localStorage.setItem("facilityMaintain", JSON.stringify(facilityMaintain));
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
            $('#search #facility_code').val('');
            $('#search #username').val('');
        }

        function Default() {
            if (localStorage.getItem("facilityMaintain")) {
                var searching = JSON.parse(localStorage.getItem("facilityMaintain"));

                $('#search #facility_code').val(searching['facility_code'] ? searching['facility_code'] : '');
                $('#search #username').val(searching['username'] ? searching['username'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var facility_code = $('#search #facility_code').val();
            table
                .columns(4)
                .search(facility_code)
                .draw();

            var username = $('#search #username').val();
            table
                .columns(3)
                .search(username)
                .draw();

            var facilityMaintain = {
                'facility_code' : facility_code,
                'username'      : username
            };

            if (localStorage.getItem("facilityMaintain") && firstTime) {
                var facilityMaintain = JSON.parse(localStorage.getItem("facilityMaintain"));

                var page = facilityMaintain['page'] ? facilityMaintain['page'] : 0;
                var length = facilityMaintain['length'] ? facilityMaintain['length'] : 10;

                facilityMaintain['page'] = page;
                facilityMaintain['length'] = length;
            }

            localStorage.setItem("facilityMaintain", JSON.stringify(facilityMaintain));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
