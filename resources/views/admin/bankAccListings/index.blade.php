@extends('layouts.admin')
@section('content')
@can('bank_acc_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bank-acc-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bankAccListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bankAccListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankAccListing.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.bankAccListing.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankAccListing.fields.bank_account') }}</label>
                <input type="text" class="form-control" id="bank_account"
                    placeholder="{{ trans('cruds.bankAccListing.fields.bank_account') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankAccListing.fields.bank_name') }}</label>
                <input type="text" class="form-control" id="bank_name"
                    placeholder="{{ trans('cruds.bankAccListing.fields.bank_name') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankAccListing.fields.balance') }}</label>
                <input type="number" class="form-control" id="balance"
                    placeholder="{{ trans('cruds.bankAccListing.fields.balance') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankAccListing.fields.status') }}</label>
                <input type="text" class="form-control" id="status"
                    placeholder="{{ trans('cruds.bankAccListing.fields.status') }}">
            </div>
            {{-- <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.bankAccListing.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\BankAccListing::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div> --}}
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
        {{ trans('cruds.bankAccListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-BankAccListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.bank_account') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.balance') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.bank_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.bankAccListing.fields.project_code') }}
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
@can('bank_acc_listing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bank-acc-listings.massDestroy') }}",
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
        pageLength: localStorage.getItem("bankAccListing") ? JSON.parse(localStorage.getItem("bankAccListing"))['length'] ? JSON.parse(localStorage.getItem("bankAccListing"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.bank-acc-listings.index') }}",
            data: function(d) {

                if (localStorage.getItem("bankAccListing") && firstTime) {
                    var bankAccListing = JSON.parse(localStorage.getItem("bankAccListing"));

                    var page = bankAccListing['page'] ? bankAccListing['page'] : 0;
                    var length = bankAccListing['length'] ? bankAccListing['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("bankAccListing")) {
                var bankAccListing = JSON.parse(localStorage.getItem("bankAccListing"));
                if (bankAccListing['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(bankAccListing['page']).draw(false);
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
            { data: 'bank_account', name: 'bank_account' },
            { data: 'status', name: 'status' },
            { data: 'is_active', name: 'is_active' },
            { data: 'balance', name: 'balance', class: 'dt-body-right' },
            { data: 'bank_name_bank_name', name: 'bank_name.bank_name' },
            { data: 'project_code', name: 'project_code.project_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-BankAccListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-BankAccListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-BankAccListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("bankAccListing")) {
                var bankAccListing = JSON.parse(localStorage.getItem("bankAccListing"));
            }

            bankAccListing['page'] = info.page;
            bankAccListing['length'] = info.length;

            localStorage.setItem("bankAccListing", JSON.stringify(bankAccListing));
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
            $('#search #bank_acc').val('');
            $('#search #bank_name').val('');
            $('#search #balance').val('');
            $('#search #status').val('');
        }

        function Default() {
            if (localStorage.getItem("bankAccListing")) {
                var searching = JSON.parse(localStorage.getItem("bankAccListing"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #bank_acc').val(searching['bank_acc'] ? searching['bank_acc'] : '');
                $('#search #bank_name').val(searching['bank_name'] ? searching['bank_name'] : '');
                $('#search #balance').val(searching['balance'] ? searching['balance'] : '');
                $('#search #status').val(searching['status'] ? searching['status'] : '');

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

            var bank_acc = $('#search #bank_acc').val();
            table
                .columns(2)
                .search(bank_acc)
                .draw();

            var bank_name = $('#search #bank_name').val();
            table
                .columns(6)
                .search(bank_name)
                .draw();

            var balance = $('#search #balance').val();
            table
                .columns(5)
                .search(balance)
                .draw();

            var status = $('#search #status').val();
            table
                .columns(3)
                .search(status)
                .draw();

            var bankAccListing = {
                'project_code'     : project_code,
                'bank_acc'         : bank_acc,
                'bank_name'        : bank_name,
                'balance'          : balance,
                'status'           : status
            };

            if (localStorage.getItem("bankAccListing") && firstTime) {
                var bankAccListing = JSON.parse(localStorage.getItem("bankAccListing"));

                var page = bankAccListing['page'] ? bankAccListing['page'] : 0;
                var length = bankAccListing['length'] ? bankAccListing['length'] : 10;

                bankAccListing['page'] = page;
                bankAccListing['length'] = length;
            }

            localStorage.setItem("bankAccListing", JSON.stringify(bankAccListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
