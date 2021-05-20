@extends('layouts.admin')
@section('content')
@can('add_block_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.add-blocks.create') }}">
                {{ trans('cruds.addBlock.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.addBlock.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.addBlock.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.addBlock.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.addBlock.fields.block') }}</label>
                <input type="text" class="form-control" id="block"
                    placeholder="{{ trans('cruds.addBlock.fields.block') }}">
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
        {{ trans('cruds.addBlock.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-AddBlock">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.addBlock.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.addBlock.fields.block') }}
                    </th>
                    <th>
                        {{ trans('cruds.addBlock.fields.project_code') }}
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
@can('add_block_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.add-blocks.massDestroy') }}",
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
        pageLength: localStorage.getItem("addBlock") ? JSON.parse(localStorage.getItem("addBlock"))['length'] ? JSON.parse(localStorage.getItem("addBlock"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.add-blocks.index') }}",
            data: function(d) {

                if (localStorage.getItem("addBlock") && firstTime) {
                    var addBlock = JSON.parse(localStorage.getItem("addBlock"));

                    var page = addBlock['page'] ? addBlock['page'] : 0;
                    var length = addBlock['length'] ? addBlock['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("addBlock")) {
                var addBlock = JSON.parse(localStorage.getItem("addBlock"));
                if (addBlock['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(addBlock['page']).draw(false);
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
            { data: 'block', name: 'block' },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-AddBlock').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-AddBlock').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-AddBlock').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("addBlock")) {
                var addBlock = JSON.parse(localStorage.getItem("addBlock"));
            }

            addBlock['page'] = info.page;
            addBlock['length'] = info.length;

            localStorage.setItem("addBlock", JSON.stringify(addBlock));
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
            $('#search #project_code').val('');
            $('#search #block').val('');
        }

        function Default() {
            if (localStorage.getItem("addBlock")) {
                var searching = JSON.parse(localStorage.getItem("addBlock"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #block').val(searching['block'] ? searching['block'] : '');

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
                .columns(3)
                .search(project_code)
                .draw();

            var block = $('#search #block').val();
            table
                .columns(2)
                .search(block)
                .draw();

            var addBlock = {
                'project_code'  : project_code,
                'block'         : block
            };

            if (localStorage.getItem("addBlock") && firstTime) {
                var addBlock = JSON.parse(localStorage.getItem("addBlock"));

                var page = addBlock['page'] ? addBlock['page'] : 0;
                var length = addBlock['length'] ? addBlock['length'] : 10;

                addBlock['page'] = page;
                addBlock['length'] = length;
            }

            localStorage.setItem("addBlock", JSON.stringify(addBlock));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
