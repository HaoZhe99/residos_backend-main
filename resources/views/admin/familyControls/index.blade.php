@extends('layouts.admin')
@section('content')
@can('family_control_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.family-controls.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.familyControl.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.familyControl.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.familyControl.fields.family') }}</label>
                <input type="text" class="form-control" id="family"
                    placeholder="{{ trans('cruds.familyControl.fields.family') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.familyControl.fields.unit_owner') }}</label>
                <input type="text" class="form-control" id="unit_owner"
                    placeholder="{{ trans('cruds.familyControl.fields.unit_owner') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.familyControl.fields.activity_log') }}</label>
                <select class="form-control select2" id="activity_log">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\FamilyControl::ACTIVITY_LOGS_SELECT as $key => $label)
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
        {{ trans('cruds.familyControl.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FamilyControl">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.familyControl.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.familyControl.fields.family') }}
                    </th>
                    <th>
                        {{ trans('cruds.familyControl.fields.unit_owner') }}
                    </th>
                    <th>
                        {{ trans('cruds.familyControl.fields.activity_log') }}
                    </th>
                    <th>
                        {{ trans('cruds.familyControl.fields.from_family') }}
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
@can('family_control_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.family-controls.massDestroy') }}",
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
        pageLength: localStorage.getItem("familyControl") ? JSON.parse(localStorage.getItem("familyControl"))['length'] ? JSON.parse(localStorage.getItem("familyControl"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.family-controls.index') }}",
            data: function(d) {

                if (localStorage.getItem("familyControl") && firstTime) {
                    var familyControl = JSON.parse(localStorage.getItem("familyControl"));

                    var page = familyControl['page'] ? familyControl['page'] : 0;
                    var length = familyControl['length'] ? familyControl['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("familyControl")) {
                var familyControl = JSON.parse(localStorage.getItem("familyControl"));
                if (familyControl['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(familyControl['page']).draw(false);
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
            { data: 'family_name', name: 'family.name' },
            { data: 'unit_owner_unit_owner', name: 'unit_owner.unit_owner' },
            { data: 'activity_logs', name: 'activity_logs' },
            { data: 'from_family', name: 'from_family' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-FamilyControl').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-FamilyControl').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-FamilyControl').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("familyControl")) {
                var familyControl = JSON.parse(localStorage.getItem("familyControl"));
            }

            familyControl['page'] = info.page;
            familyControl['length'] = info.length;

            localStorage.setItem("familyControl", JSON.stringify(familyControl));
        }

        $('#search #activity_log').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.familyControl.fields.activity_log') }}",
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
            $('#search #family').val('');
            $('#search #unit_owner').val('');

            $('#search #activity_log').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("familyControl")) {
                var searching = JSON.parse(localStorage.getItem("familyControl"));

                $('#search #family').val(searching['family'] ? searching['family'] : '');
                $('#search #unit_owner').val(searching['unit_owner'] ? searching['unit_owner'] : '');

                $('#search #activity_log').val(searching['activity_log'] ? searching['activity_log'] : 'All').trigger('change');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var family = $('#search #family').val();
            table
                .columns(2)
                .search(family)
                .draw();

            var unit_owner = $('#search #unit_owner').val();
            table
                .columns(3)
                .search(unit_owner)
                .draw();

            var activity_log = $('#search #activity_log').val();
            if(jQuery.inArray("All", activity_log) === -1) {
                searchingFunction(activity_log, 4);
            } else {
                table
                    .columns(4)
                    .search('',true,false)
                    .draw();
            }

            var familyControl = {
                'family'        : family,
                'unit_owner'    : unit_owner,
                'activity_log'  : activity_log
            };

            if (localStorage.getItem("familyControl") && firstTime) {
                var familyControl = JSON.parse(localStorage.getItem("familyControl"));

                var page = familyControl['page'] ? familyControl['page'] : 0;
                var length = familyControl['length'] ? familyControl['length'] : 10;

                familyControl['page'] = page;
                familyControl['length'] = length;
            }

            localStorage.setItem("familyControl", JSON.stringify(familyControl));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
