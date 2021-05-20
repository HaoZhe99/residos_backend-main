@extends('layouts.admin')
@section('content')
@can('feedback_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.feedback-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.feedbackListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.feedbackListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.feedbackListing.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.feedbackListing.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.feedbackListing.fields.category') }}</label>
                <input type="text" class="form-control" id="category"
                    placeholder="{{ trans('cruds.feedbackListing.fields.category') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.feedbackListing.fields.title') }}</label>
                <input type="text" class="form-control" id="title"
                    placeholder="{{ trans('cruds.feedbackListing.fields.title') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.feedbackListing.fields.send_to') }}</label>
                <input type="text" class="form-control" id="send_to"
                    placeholder="{{ trans('cruds.feedbackListing.fields.send_to') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.feedbackListing.fields.created_by') }}</label>
                <input type="text" class="form-control" id="created_by"
                    placeholder="{{ trans('cruds.feedbackListing.fields.created_by') }}">
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
        {{ trans('cruds.feedbackListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FeedbackListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.send_to') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.reply') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.reply_photo') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.created_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.feedbackListing.fields.file') }}
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
@can('feedback_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.feedback-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("feedbackListing") ? JSON.parse(localStorage.getItem("feedbackListing"))['length'] ? JSON.parse(localStorage.getItem("feedbackListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.feedback-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("feedbackListing") && firstTime) {
                    var feedbackListing = JSON.parse(localStorage.getItem("feedbackListing"));

                    var page = feedbackListing['page'] ? feedbackListing['page'] : 0;
                    var length = feedbackListing['length'] ? feedbackListing['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("feedbackListing")) {
                var feedbackListing = JSON.parse(localStorage.getItem("feedbackListing"));
                if (feedbackListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(feedbackListing['page']).draw(false);
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
            { data: 'category_category', name: 'category.category' },
            { data: 'title', name: 'title' },
            { data: 'send_to', name: 'send_to' },
            { data: 'reply', name: 'reply' },
            { data: 'reply_photo', name: 'reply_photo', sortable: false, searchable: false },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'created_by_name', name: 'created_by.name' },
            { data: 'file', name: 'file', sortable: false, searchable: false },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-FeedbackListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-FeedbackListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-FeedbackListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("feedbackListing")) {
                var feedbackListing = JSON.parse(localStorage.getItem("feedbackListing"));
            }

            feedbackListing['page'] = info.page;
            feedbackListing['length'] = info.length;

            localStorage.setItem("feedbackListing", JSON.stringify(feedbackListing));
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
            $('#search #project_code').val('');
            $('#search #category').val('');
            $('#search #title').val('');
            $('#search #send_to').val('');
            $('#search #created_by').val('');
        }

        function Default() {
            if (localStorage.getItem("feedbackListing")) {
                var searching = JSON.parse(localStorage.getItem("feedbackListing"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #category').val(searching['category'] ? searching['category'] : '');
                $('#search #title').val(searching['title'] ? searching['title'] : '');
                $('#search #send_to').val(searching['send_to'] ? searching['send_to'] : '');
                $('#search #created_by').val(searching['created_by'] ? searching['created_by'] : '');

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
                .columns(7)
                .search(project_code)
                .draw();

            var category = $('#search #category').val();
            table
                .columns(2)
                .search(category)
                .draw();

            var title = $('#search #title').val();
            table
                .columns(3)
                .search(title)
                .draw();

            var send_to = $('#search #send_to').val();
            table
                .columns(4)
                .search(send_to)
                .draw();

            var created_by = $('#search #created_by').val();
            table
                .columns(8)
                .search(created_by)
                .draw();

            var feedbackListing = {
                'project_code'   : project_code,
                'category'       : category,
                'title'          : title,
                'send_to'        : send_to,
                'created_by'     : created_by
            };

            if (localStorage.getItem("feedbackListing") && firstTime) {
                var feedbackListing = JSON.parse(localStorage.getItem("feedbackListing"));

                var page = feedbackListing['page'] ? feedbackListing['page'] : 0;
                var length = feedbackListing['length'] ? feedbackListing['length'] : 10;

                feedbackListing['page'] = page;
                feedbackListing['length'] = length;
            }

            localStorage.setItem("feedbackListing", JSON.stringify(feedbackListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
