@extends('layouts.admin')
@section('content')
@can('content_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.content-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.contentListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.contentListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.contentListing.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.type') }}</label>
                <input type="text" class="form-control" id="type"
                    placeholder="{{ trans('cruds.contentListing.fields.type') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.title') }}</label>
                <input type="text" class="form-control" id="title"
                    placeholder="{{ trans('cruds.contentListing.fields.title') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.language') }}</label>
                <input type="text" class="form-control" id="language"
                    placeholder="{{ trans('cruds.contentListing.fields.language') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.created_by') }}</label>
                <input type="text" class="form-control" id="created_by"
                    placeholder="{{ trans('cruds.contentListing.fields.created_by') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.send_to') }}</label>
                <input type="text" class="form-control" id="send_to"
                    placeholder="{{ trans('cruds.contentListing.fields.send_to') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.user_group') }}</label>
                <input type="text" class="form-control" id="user_group"
                    placeholder="{{ trans('cruds.contentListing.fields.user_group') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.contentListing.fields.user') }}</label>
                <input type="text" class="form-control" id="user"
                    placeholder="{{ trans('cruds.contentListing.fields.user') }}">
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
        {{ trans('cruds.contentListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ContentListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentType.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.pinned') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.language') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.created_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.send_to') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.url') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.user_group') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.expired_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.contentListing.fields.user') }}
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
@can('content_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.content-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("contentListing") ? JSON.parse(localStorage.getItem("contentListing"))['length'] ? JSON.parse(localStorage.getItem("contentListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.content-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("contentListing") && firstTime) {
                    var contentListing = JSON.parse(localStorage.getItem("contentListing"));

                    var page = contentListing['page'] ? contentListing['page'] : 0;
                    var length = contentListing['length'] ? contentListing['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("contentListing")) {
                var contentListing = JSON.parse(localStorage.getItem("contentListing"));
                if (contentListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(contentListing['page']).draw(false);
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
            { data: 'type_type', name: 'type.type' },
            { data: 'type.is_active', name: 'type.is_active' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'pinned', name: 'pinned' },
            { data: 'language', name: 'language' },
            { data: 'created_by', name: 'created_by' },
            { data: 'send_to', name: 'send_to' },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'url', name: 'url' },
            { data: 'user_group', name: 'user_group' },
            { data: 'expired_date', name: 'expired_date' },
            { data: 'is_active', name: 'is_active' },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'user', name: 'users.name' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-ContentListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-ContentListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-ContentListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("contentListing")) {
                var contentListing = JSON.parse(localStorage.getItem("contentListing"));
            }

            contentListing['page'] = info.page;
            contentListing['length'] = info.length;

            localStorage.setItem("contentListing", JSON.stringify(contentListing));
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
            $('#search #type').val('');
            $('#search #title').val('');
            $('#search #language').val('');
            $('#search #created_by').val('');
            $('#search #send_to').val('');
            $('#search #user_group').val('');
            $('#search #user').val('');
        }

        function Default() {
            if (localStorage.getItem("contentListing")) {
                var searching = JSON.parse(localStorage.getItem("contentListing"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #type').val(searching['type'] ? searching['type'] : '');
                $('#search #title').val(searching['title'] ? searching['title'] : '');
                $('#search #language').val(searching['language'] ? searching['language'] : '');
                $('#search #created_by').val(searching['created_by'] ? searching['created_by'] : '');
                $('#search #send_to').val(searching['send_to'] ? searching['send_to'] : '');
                $('#search #user_group').val(searching['user_group'] ? searching['user_group'] : '');
                $('#search #user').val(searching['user'] ? searching['user'] : '');

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
                .columns(15)
                .search(project_code)
                .draw();

            var type = $('#search #type').val();
            table
                .columns(2)
                .search(type)
                .draw();

            var title = $('#search #title').val();
            table
                .columns(4)
                .search(title)
                .draw();

            var language = $('#search #language').val();
            table
                .columns(7)
                .search(langauge)
                .draw();

            var created_by = $('#search #created_by').val();
            table
                .columns(8)
                .search(created_by)
                .draw();

            var send_to = $('#search #send_to').val();
            table
                .columns(9)
                .search(send_to)
                .draw();

            var user_group = $('#search #user_group').val();
            table
                .columns(12)
                .search(user_group)
                .draw();

            var user = $('#search #user').val();
            table
                .columns(16)
                .search(user)
                .draw();

            var contentListing = {
                'project_code'  : project_code,
                'type'          : type,
                'title'         : title,
                'language'      : language,
                'created_by'    : created_by,
                'send_to'       : send_to,
                'user_group'    : user_group,
                'user'          : user
            };

            if (localStorage.getItem("contentListing") && firstTime) {
                var contentListing = JSON.parse(localStorage.getItem("contentListing"));

                var page = contentListing['page'] ? contentListing['page'] : 0;
                var length = contentListing['length'] ? contentListing['length'] : 10;

                contentListing['page'] = page;
                contentListing['length'] = length;
            }

            localStorage.setItem("contentListing", JSON.stringify(contentListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
