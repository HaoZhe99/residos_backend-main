@extends('layouts.admin')
@section('content')
@can('event_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.event-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eventListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.eventListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.event_code') }}</label>
                <input type="text" class="form-control" id="event_code"
                    placeholder="{{ trans('cruds.eventListing.fields.event_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.catogery') }}</label>
                <input type="text" class="form-control" id="category"
                    placeholder="{{ trans('cruds.eventListing.fields.catogery') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.title') }}</label>
                <input type="text" class="form-control" id="title"
                    placeholder="{{ trans('cruds.eventListing.fields.title') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.payment') }}</label>
                <input type="text" class="form-control" id="payment"
                    placeholder="{{ trans('cruds.eventListing.fields.payment') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.participants') }}</label>
                <input type="number" class="form-control" id="participants"
                    placeholder="{{ trans('cruds.eventListing.fields.participants') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.organized_by') }}</label>
                <input type="text" class="form-control" id="organized_by"
                    placeholder="{{ trans('cruds.eventListing.fields.organized_by') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.type') }}</label>
                <input type="text" class="form-control" id="type"
                    placeholder="{{ trans('cruds.eventListing.fields.type') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.language') }}</label>
                <input type="text" class="form-control" id="language"
                    placeholder="{{ trans('cruds.eventListing.fields.language') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eventListing.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\EventListing::STATUS_SELECT as $key => $label)
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
        {{ trans('cruds.eventListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EventListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.event_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.catogery') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.language') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.payment') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.participants') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.organized_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.created_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventListing.fields.user_group') }}
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
@can('event_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.event-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("eventListing") ? JSON.parse(localStorage.getItem("eventListing"))['length'] ? JSON.parse(localStorage.getItem("eventListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.event-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("eventListing") && firstTime) {
                    var eventListing = JSON.parse(localStorage.getItem("eventListing"));

                    var page = eventListing['page'] ? eventListing['page'] : 0;
                    var length = eventListing['length'] ? eventListing['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("eventListing")) {
                var eventListing = JSON.parse(localStorage.getItem("eventListing"));
                if (eventListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(eventListing['page']).draw(false);
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
            { data: 'event_code', name: 'event_code' },
            { data: 'catogery_cateogey', name: 'catogery.cateogey' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'language', name: 'language' },
            { data: 'payment', name: 'payment', className: "text-right" },
            { data: 'participants', name: 'participants', className: "text-right" },
            { data: 'image', name: 'image', sortable: false, searchable: false },
            { data: 'organized_by', name: 'organized_by' },
            { data: 'type', name: 'type' },
            { data: 'status', name: 'status' },
            { data: 'created_by_name', name: 'created_by.name' },
            { data: 'user_group_title', name: 'user_group.title' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-EventListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-EventListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-EventListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("eventListing")) {
                var eventListing = JSON.parse(localStorage.getItem("eventListing"));
            }

            eventListing['page'] = info.page;
            eventListing['length'] = info.length;

            localStorage.setItem("eventListing", JSON.stringify(eventListing));
        }

        $('#search #status').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.eventListing.fields.status') }}",
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
            $('#search #event_code').val('');
            $('#search #category').val('');
            $('#search #title').val('');
            $('#search #payment').val('');
            $('#search #participants').val('');
            $('#search #organized_by').val('');
            $('#search #type').val('');
            $('#search #language').val('');

            $('#search #status').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("eventListing")) {
                var searching = JSON.parse(localStorage.getItem("eventListing"));

                $('#search #event_code').val(searching['event_code'] ? searching['event_code'] : '');
                $('#search #category').val(searching['category'] ? searching['category'] : '');
                $('#search #title').val(searching['title'] ? searching['title'] : '');
                $('#search #payment').val(searching['payment'] ? searching['payment'] : '');
                $('#search #participants').val(searching['participants'] ? searching['participants'] : '');
                $('#search #organized_by').val(searching['organized_by'] ? searching['organized_by'] : '');
                $('#search #type').val(searching['type'] ? searching['type'] : '');
                $('#search #language').val(searching['language'] ? searching['language'] : '');

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

            var event_code = $('#search #event_code').val();
            table
                .columns(2)
                .search(event_code)
                .draw();

            var category = $('#search #category').val();
            table
                .columns(3)
                .search(category)
                .draw();

            var title = $('#search #title').val();
            table
                .columns(4)
                .search(title)
                .draw();

            var payment = $('#search #payment').val();
            table
                .columns(7)
                .search(payment)
                .draw();

            var participants = $('#search #participants').val();
            table
                .columns(8)
                .search(participants)
                .draw();

            var organized_by = $('#search #organized_by').val();
            table
                .columns(10)
                .search(organized_by)
                .draw();

            var type = $('#search #type').val();
            table
                .columns(11)
                .search(type)
                .draw();

            var language = $('#search #language').val();
            table
                .columns(6)
                .search(language)
                .draw();

            var status = $('#search #status').val();
            if(jQuery.inArray("All", status) === -1) {
                searchingFunction(status, 12);
            } else {
                table
                    .columns(12)
                    .search('',true,false)
                    .draw();
            }

            var eventListing = {
                'event_code'    : event_code,
                'category'      : category,
                'title'         : title,
                'payment'       : payment,
                'participants'  : participants,
                'organized_by'  : organized_by,
                'type'          : type,
                'language'      : language,
                'status'        : status
            };

            if (localStorage.getItem("eventListing") && firstTime) {
                var eventListing = JSON.parse(localStorage.getItem("eventListing"));

                var page = eventListing['page'] ? eventListing['page'] : 0;
                var length = eventListing['length'] ? eventListing['length'] : 10;

                eventListing['page'] = page;
                eventListing['length'] = length;
            }

            localStorage.setItem("eventListing", JSON.stringify(eventListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
