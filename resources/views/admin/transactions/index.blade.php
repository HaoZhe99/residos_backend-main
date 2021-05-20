@extends('layouts.admin')
@section('content')
@can('transaction_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.transactions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.transaction.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.transaction.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.transaction.fields.project_code') }}</label>
                <input type="text" class="form-control" id="project_code"
                    placeholder="{{ trans('cruds.transaction.fields.project_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.transaction.fields.bill_code') }}</label>
                <input type="text" class="form-control" id="bill_code"
                    placeholder="{{ trans('cruds.transaction.fields.bill_code') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.transaction.fields.bank_acc') }}</label>
                <input type="text" class="form-control" id="bank_acc"
                    placeholder="{{ trans('cruds.transaction.fields.bank_acc') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.transaction.fields.username') }}</label>
                <input type="text" class="form-control" id="username"
                    placeholder="{{ trans('cruds.transaction.fields.username') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.transaction.fields.credit') }}</label>
                <input type="number" class="form-control" id="credit"
                    placeholder="{{ trans('cruds.transaction.fields.credit') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.transaction.fields.debit') }}</label>
                <input type="number" class="form-control" id="debit"
                    placeholder="{{ trans('cruds.transaction.fields.debit') }}">
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
        {{ trans('cruds.transaction.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Transaction">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.bill_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.credit') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.debit') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.project_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.bank_acc') }}
                    </th>
                    <th>
                        {{ trans('cruds.transaction.fields.username') }}
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
@can('transaction_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.transactions.massDestroy') }}",
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
        pageLength: localStorage.getItem("transaction") ? JSON.parse(localStorage.getItem("transaction"))['length'] ? JSON.parse(localStorage.getItem("transaction"))['length'] :10 : 10,
        search :{
            regex : true,
        },
        bSort: false,
        orderCellsTop: true,
        ajax: {
            url: "{{ route('admin.transactions.index') }}",
            data: function(d) {

                if (localStorage.getItem("transaction") && firstTime) {
                    var transaction = JSON.parse(localStorage.getItem("transaction"));

                    var page = transaction['page'] ? transaction['page'] : 0;
                    var length = transaction['length'] ? transaction['length'] : 10;

                    d.start = page * length;
                }
            }
        },
        initComplete: function(settings, json) {
            if (localStorage.getItem("transaction")) {
                var transaction = JSON.parse(localStorage.getItem("transaction"));
                if (transaction['page']) {
                    const api = $.fn.dataTable.Api(settings);
                    api.page(transaction['page']).draw(false);
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
            { data: 'bill_code', name: 'bill_code' },
            { data: 'credit', name: 'credit', className: "text-right" },
            { data: 'debit', name: 'debit', className: "text-right" },
            { data: 'project_code_project_code', name: 'project_code.project_code' },
            { data: 'bank_acc_bank_account', name: 'bank_acc.bank_account' },
            { data: 'username_name', name: 'username.name' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
    };
    let table = $('.datatable-Transaction').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-Transaction').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-Transaction').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("transaction")) {
                var transaction = JSON.parse(localStorage.getItem("transaction"));
            }

            transaction['page'] = info.page;
            transaction['length'] = info.length;

            localStorage.setItem("transaction", JSON.stringify(transaction));
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
            $('#search #bill_code').val('');
            $('#search #bank_acc').val('');
            $('#search #username').val('');
            $('#search #credit').val('');
            $('#search #debit').val('');
        }

        function Default() {
            if (localStorage.getItem("transaction")) {
                var searching = JSON.parse(localStorage.getItem("transaction"));

                $('#search #project_code').val(searching['project_code'] ? searching['project_code'] : '');
                $('#search #bill_code').val(searching['bill_code'] ? searching['bill_code'] : '');
                $('#search #bank_acc').val(searching['bank_acc'] ? searching['bank_acc'] : '');
                $('#search #username').val(searching['username'] ? searching['username'] : '');
                $('#search #credit').val(searching['credit'] ? searching['credit'] : '');
                $('#search #debit').val(searching['debit'] ? searching['debit'] : '');

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
                .columns(5)
                .search(project_code)
                .draw();

            var bill_code = $('#search #bill_code').val();
            table
                .columns(2)
                .search(bill_code)
                .draw();

            var bank_acc = $('#search #bank_acc').val();
            table
                .columns(6)
                .search(bank_acc)
                .draw();

            var username = $('#search #username').val();
            table
                .columns(7)
                .search(username)
                .draw();

            var credit = $('#search #credit').val();
            table
                .columns(3)
                .search(credit)
                .draw();

            var debit = $('#search #debit').val();
            table
                .columns(4)
                .search(debit)
                .draw();

            var transaction = {
                'project_code'  : project_code,
                'bill_code'     : bill_code,
                'bank_acc'      : bank_acc,
                'username'      : username,
                'credit'        : credit,
                'debit'         : debit
            };

            if (localStorage.getItem("transaction") && firstTime) {
                var transaction = JSON.parse(localStorage.getItem("transaction"));

                var page = transaction['page'] ? transaction['page'] : 0;
                var length = transaction['length'] ? transaction['length'] : 10;

                transaction['page'] = page;
                transaction['length'] = length;
            }

            localStorage.setItem("transaction", JSON.stringify(transaction));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>
@endsection
