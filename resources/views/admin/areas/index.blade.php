@extends('layouts.admin')
@section('content')
@can('area_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.areas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.area.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.area.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.area.fields.country') }}</label>
                <input type="text" class="form-control" id="country"
                    placeholder="{{ trans('cruds.area.fields.country') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.area.fields.states') }}</label>
                <input type="text" class="form-control" id="state"
                    placeholder="{{ trans('cruds.area.fields.states') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.area.fields.area') }}</label>
                <input type="text" class="form-control" id="area"
                    placeholder="{{ trans('cruds.area.fields.area') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.area.fields.postcode') }}</label>
                <input type="text" class="form-control" id="postcode"
                    placeholder="{{ trans('cruds.area.fields.postcode') }}">
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
        {{ trans('cruds.area.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Area">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.area.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.area.fields.country') }}
                    </th>
                    <th>
                        {{ trans('cruds.area.fields.states') }}
                    </th>
                    <th>
                        {{ trans('cruds.area.fields.area') }}
                    </th>
                    <th>
                        {{ trans('cruds.area.fields.postcode') }}
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
@can('area_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.areas.massDestroy') }}",
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
        pageLength: localStorage.getItem("area") ? JSON.parse(localStorage.getItem("area"))['length'] ? JSON.parse(localStorage.getItem("area"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.areas.index') }}",
            data: function(d) {

                if (localStorage.getItem("area") && firstTime) {
                    var area = JSON.parse(localStorage.getItem("area"));

                    var page = area['page'] ? area['page'] : 0;
                    var length = area['length'] ? area['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("area")) {
                var area = JSON.parse(localStorage.getItem("area"));
                if (area['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(area['page']).draw(false);
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
            { data: 'country', name: 'country' },
            { data: 'states', name: 'states' },
            { data: 'area', name: 'area' },
            { data: 'postcode', name: 'postcode' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-Area').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-Area').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-Area').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("area")) {
                var area = JSON.parse(localStorage.getItem("area"));
            }

            area['page'] = info.page;
            area['length'] = info.length;

            localStorage.setItem("area", JSON.stringify(area));
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
            $('#search #country').val('');
            $('#search #area').val('');
            $('#search #state').val('');
            $('#search #postcode').val('');
        }

        function Default() {
            if (localStorage.getItem("area")) {
                var searching = JSON.parse(localStorage.getItem("area"));

                $('#search #country').val(searching['country'] ? searching['country'] : '');
                $('#search #area').val(searching['area'] ? searching['area'] : '');
                $('#search #state').val(searching['state'] ? searching['state'] : '');
                $('#search #postcode').val(searching['postcode'] ? searching['postcode'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var country = $('#search #country').val();
            table
                .columns(2)
                .search(country)
                .draw();

            var area = $('#search #area').val();
            table
                .columns(3)
                .search(area)
                .draw();

            var state = $('#search #state').val();
            table
                .columns(4)
                .search(state)
                .draw();

            var postcode = $('#search #postcode').val();
            table
                .columns(5)
                .search(postcode)
                .draw();

            var area = {
                'country'     : country,
                'area'        : area,
                'state'       : state,
                'postcode'    : postcode
            };

            if (localStorage.getItem("area") && firstTime) {
                var area = JSON.parse(localStorage.getItem("area"));

                var page = area['page'] ? area['page'] : 0;
                var length = area['length'] ? area['length'] : 10;

                area['page'] = page;
                area['length'] = length;
            }

            localStorage.setItem("area", JSON.stringify(area));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
