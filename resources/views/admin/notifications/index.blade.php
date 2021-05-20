@extends('layouts.admin')
@section('content')
@can('notifications_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.notifications.create') }}">
                {{ trans('global.add') }} Notification
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.notification.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.notification.fields.title_text') }}</label>
                <input type="text" class="form-control" id="title_text"
                    placeholder="{{ trans('cruds.notification.fields.title_text') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.notification.fields.description_text') }}</label>
                <input type="text" class="form-control" id="description_text"
                    placeholder="{{ trans('cruds.notification.fields.description_text') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.notification.fields.language') }}</label>
                <input type="text" class="form-control" id="language"
                    placeholder="{{ trans('cruds.notification.fields.language') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.notification.fields.url') }}</label>
                <input type="text" class="form-control" id="url"
                    placeholder="{{ trans('cruds.notification.fields.url') }}">
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
        Notification {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-notifications">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.title_text') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.description_text') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.language') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.url') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.expired_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.roles_id') }}
                    </th>
                    <th>
                        {{ trans('cruds.notification.fields.user_id') }}
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
    @can('notifications_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.notifications.massDestroy') }}",
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
        pageLength: localStorage.getItem("notification") ? JSON.parse(localStorage.getItem("notification"))['length'] ? JSON.parse(localStorage.getItem("notification"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.notifications.index') }}",
            data: function(d) {

                if (localStorage.getItem("notification") && firstTime) {
                    var notification = JSON.parse(localStorage.getItem("notification"));

                    var page = notification['page'] ? notification['page'] : 0;
                    var length = notification['length'] ? notification['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("notification")) {
                var notification = JSON.parse(localStorage.getItem("notification"));
                if (notification['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(notification['page']).draw(false);
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
            { data: 'title_text', name: 'title_text' },
            { data: 'description_text', name: 'description_text'},
            { data: 'image', name: 'image', sortable: false, searchable: false},
            { data: 'language_shortkey', name: 'language_shortkey'},
            { data: 'url', name: 'url'},
            { data: 'expired_date', name: 'expired_date'},
            { data: 'is_active', name: 'is_active'},
            { data: 'role', name: 'roles.title'},
            { data: 'user', name: 'user.name'},
            { data: 'actions', name: '{{ trans('global.actions') }}'}
        ],
    };
    let table = $('.datatable-notifications').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('.datatable-notifications').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-notifications').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("notification")) {
                var notification = JSON.parse(localStorage.getItem("notification"));
            }

            notification['page'] = info.page;
            notification['length'] = info.length;

            localStorage.setItem("notification", JSON.stringify(notification));
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
            $('#search #title_text').val('');
            $('#search #description_text').val('');
            $('#search #language').val('');
            $('#search #url').val('');
        }

        function Default() {
            if (localStorage.getItem("notification")) {
                var searching = JSON.parse(localStorage.getItem("notification"));

                $('#search #title_text').val(searching['title_text'] ? searching['title_text'] : '');
                $('#search #description_text').val(searching['description_text'] ? searching['description_text'] : '');
                $('#search #language').val(searching['language'] ? searching['language'] : '');
                $('#search #url').val(searching['url'] ? searching['url'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var title_text = $('#search #title_text').val();
            table
                .columns(2)
                .search(title_text)
                .draw();

            var description_text = $('#search #description_text').val();
            table
                .columns(3)
                .search(description_text)
                .draw();

            var language = $('#search #language').val();
            table
                .columns(5)
                .search(language)
                .draw();

            var url = $('#search #url').val();
            table
                .columns(6)
                .search(url)
                .draw();

            var notification = {
                'title_text'       : title_text,
                'description_text' : description_text,
                'language'         : language,
                'url'              : url
            };

            if (localStorage.getItem("notification") && firstTime) {
                var notification = JSON.parse(localStorage.getItem("notification"));

                var page = notification['page'] ? notification['page'] : 0;
                var length = notification['length'] ? notification['length'] : 10;

                notification['page'] = page;
                notification['length'] = length;
            }

            localStorage.setItem("notification", JSON.stringify(notification));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })
    });
</script>
@endsection
