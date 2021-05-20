@extends('layouts.admin')
@section('content')
@can('bank_name_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bank-names.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bankName.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bankName.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankName.fields.country') }}</label>
                <input type="text" class="form-control" id="country"
                    placeholder="{{ trans('cruds.bankName.fields.country') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankName.fields.bank_name') }}</label>
                <input type="text" class="form-control" id="bank_name"
                    placeholder="{{ trans('cruds.bankName.fields.bank_name') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankName.fields.swift_code') }}</label>
                <input type="text" class="form-control" id="swift_code"
                    placeholder="{{ trans('cruds.bankName.fields.swift_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankName.fields.bank_code') }}</label>
                <input type="text" class="form-control" id="bank_code"
                    placeholder="{{ trans('cruds.bankName.fields.bank_code') }}">
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
        {{ trans('cruds.bankName.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-BankName">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.bankName.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankName.fields.country') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankName.fields.bank_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankName.fields.swift_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankName.fields.bank_code') }}
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
@can('bank_name_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bank-names.massDestroy') }}",
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
        pageLength: localStorage.getItem("bankName") ? JSON.parse(localStorage.getItem("bankName"))['length'] ? JSON.parse(localStorage.getItem("bankName"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.bank-names.index') }}",
            data: function(d) {

                if (localStorage.getItem("bankName") && firstTime) {
                    var bankName = JSON.parse(localStorage.getItem("bankName"));

                    var page = bankName['page'] ? bankName['page'] : 0;
                    var length = bankName['length'] ? bankName['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("bankName")) {
                var bankName = JSON.parse(localStorage.getItem("bankName"));
                if (bankName['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(bankName['page']).draw(false);
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
            { data: 'bank_name', name: 'bank_name' },
            { data: 'swift_code', name: 'swift_code' },
            { data: 'bank_code', name: 'bank_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-BankName').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-BankName').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-BankName').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("bankName")) {
                var bankName = JSON.parse(localStorage.getItem("bankName"));
            }

            bankName['page'] = info.page;
            bankName['length'] = info.length;

            localStorage.setItem("bankName", JSON.stringify(bankName));
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
            $('#search #bank_name').val('');
            $('#search #swift_code').val('');
            $('#search #bank_code').val('');
        }

        function Default() {
            if (localStorage.getItem("bankName")) {
                var searching = JSON.parse(localStorage.getItem("bankName"));

                $('#search #country').val(searching['country'] ? searching['country'] : '');
                $('#search #bank_name').val(searching['bank_name'] ? searching['bank_name'] : '');
                $('#search #swift_code').val(searching['swift_code'] ? searching['swift_code'] : '');
                $('#search #bank_code').val(searching['bank_code'] ? searching['bank_code'] : '');

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

            var bank_name = $('#search #bank_name').val();
            table
                .columns(3)
                .search(bank_name)
                .draw();

            var swift_code = $('#search #swift_code').val();
            table
                .columns(4)
                .search(swift_code)
                .draw();

            var bank_code = $('#search #bank_code').val();
            table
                .columns(5)
                .search(bank_code)
                .draw();

            var bankName = {
                'country'       : country,
                'bank_name'     : bank_name,
                'swift_code'    : swift_code,
                'bank_code'     : bank_code
            };

            if (localStorage.getItem("bankName") && firstTime) {
                var bankName = JSON.parse(localStorage.getItem("bankName"));

                var page = bankName['page'] ? bankName['page'] : 0;
                var length = bankName['length'] ? bankName['length'] : 10;

                bankName['page'] = page;
                bankName['length'] = length;
            }

            localStorage.setItem("bankName", JSON.stringify(bankName));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
