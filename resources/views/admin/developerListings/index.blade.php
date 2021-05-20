@extends('layouts.admin')
@section('content')
@can('developer_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.developer-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.developerListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.developerListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.developerListing.fields.company_name') }}</label>
                <input type="text" class="form-control" id="company_name"
                    placeholder="{{ trans('cruds.developerListing.fields.company_name') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.developerListing.fields.contact') }}</label>
                <input type="text" class="form-control" id="contact"
                    placeholder="{{ trans('cruds.developerListing.fields.contact') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.developerListing.fields.address') }}</label>
                <input type="text" class="form-control" id="address"
                    placeholder="{{ trans('cruds.developerListing.fields.address') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.developerListing.fields.email') }}</label>
                <input type="text" class="form-control" id="email"
                    placeholder="{{ trans('cruds.developerListing.fields.email') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.developerListing.fields.pic') }}</label>
                <input type="text" class="form-control" id="pic"
                    placeholder="{{ trans('cruds.developerListing.fields.pic') }}">
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
        {{ trans('cruds.developerListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DeveloperListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.company_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.contact') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.website') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.fb') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.linked_in') }}
                    </th>
                    <th>
                        {{ trans('cruds.developerListing.fields.pic') }}
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
@can('developer_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.developer-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("developerListing") ? JSON.parse(localStorage.getItem("developerListing"))['length'] ? JSON.parse(localStorage.getItem("developerListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.developer-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("developerListing") && firstTime) {
                    var developerListing = JSON.parse(localStorage.getItem("developerListing"));

                    var page = developerListing['page'] ? developerListing['page'] : 0;
                    var length = developerListing['length'] ? developerListing['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("developerListing")) {
                var developerListing = JSON.parse(localStorage.getItem("developerListing"));
                if (developerListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(developerListing['page']).draw(false);
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
            { data: 'company_name', name: 'company_name' },
            { data: 'contact', name: 'contact' },
            { data: 'address', name: 'address' },
            { data: 'email', name: 'email' },
            { data: 'website', name: 'website' },
            { data: 'fb', name: 'fb' },
            { data: 'linked_in', name: 'linked_in' },
            { data: 'pic_name', name: 'pic.name' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-DeveloperListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-DeveloperListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-DeveloperListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("developerListing")) {
                var developerListing = JSON.parse(localStorage.getItem("developerListing"));
            }

            developerListing['page'] = info.page;
            developerListing['length'] = info.length;

            localStorage.setItem("developerListing", JSON.stringify(developerListing));
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
            $('#search #company_name').val('');
            $('#search #contact').val('');
            $('#search #address').val('');
            $('#search #email').val('');
            $('#search #pic').val('');
        }

        function Default() {
            if (localStorage.getItem("developerListing")) {
                var searching = JSON.parse(localStorage.getItem("developerListing"));

                $('#search #company_name').val(searching['company_name'] ? searching['company_name'] : '');
                $('#search #contact').val(searching['contact'] ? searching['contact'] : '');
                $('#search #address').val(searching['address'] ? searching['address'] : '');
                $('#search #email').val(searching['email'] ? searching['email'] : '');
                $('#search #pic').val(searching['pic'] ? searching['pic'] : '');

                Searching();
            } else {
                Reset();
                Searching();
            }
        }

        Default();

        function Searching() {
            table.ajax.reload();

            var company_name = $('#search #company_name').val();
            table
                .columns(2)
                .search(company_name)
                .draw();

            var contact = $('#search #contact').val();
            table
                .columns(3)
                .search(contact)
                .draw();

            var address = $('#search #address').val();
            table
                .columns(4)
                .search(address)
                .draw();

            var email = $('#search #email').val();
            table
                .columns(5)
                .search(email)
                .draw();

            var pic = $('#search #pic').val();
            table
                .columns(9)
                .search(pic)
                .draw();

            var developerListing = {
                'company_name'   : company_name,
                'contact'        : contact,
                'address'        : address,
                'email'          : email,
                'pic'            : pic
            };

            if (localStorage.getItem("developerListing") && firstTime) {
                var developerListing = JSON.parse(localStorage.getItem("developerListing"));

                var page = developerListing['page'] ? developerListing['page'] : 0;
                var length = developerListing['length'] ? developerListing['length'] : 10;

                developerListing['page'] = page;
                developerListing['length'] = length;
            }

            localStorage.setItem("developerListing", JSON.stringify(developerListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
