@extends('layouts.admin')
@section('content')
@can('e_bill_listing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.e-bill-listings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eBillListing.title_singular') }}
            </a>
        </div>
    </div>
@endcan

{{-- search --}}
<div class="card">
    <div class="card-header">
        {{ trans('cruds.eBillListing.title_singular') }} {{ trans('global.list') }} {{ trans('global.search') }}
    </div>
    <div class="card-body">
        <div class="row" id="search">
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.project') }}</label>
                <input type="text" class="form-control" id="project"
                    placeholder="{{ trans('cruds.eBillListing.fields.project') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.unit') }}</label>
                <input type="text" class="form-control" id="unit"
                    placeholder="{{ trans('cruds.eBillListing.fields.unit') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.type') }}</label>
                <select class="form-control select2" id="type">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\EBillListing::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.payment_method') }}</label>
                <input type="text" class="form-control" id="payment_method"
                    placeholder="{{ trans('cruds.eBillListing.fields.payment_method') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.amount') }}</label>
                <input type="number" class="form-control" id="amount"
                    placeholder="{{ trans('cruds.eBillListing.fields.amount') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.bank_acc') }}</label>
                <input type="text" class="form-control" id="bank_acc"
                    placeholder="{{ trans('cruds.eBillListing.fields.bank_acc') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.username') }}</label>
                <input type="text" class="form-control" id="username"
                    placeholder="{{ trans('cruds.eBillListing.fields.username') }}">
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-3">
                <label>{{ trans('cruds.eBillListing.fields.status') }}</label>
                <select class="form-control select2" id="status">
                    <option value="All">{{ trans('global.all') }}</option>
                    @foreach (App\Models\EBillListing::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-lg-6 col-xl-6">
                <label>{{ trans('cruds.eBillListing.fields.date_range') }}</label>
                <div class="input-group">
                    <input type="date" class="form-control date-range-filter" id="min-date">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                    <input type="date" class="form-control date-range-filter" id="max-date">
                </div>
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
        {{ trans('cruds.eBillListing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EBillListing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.payment_method') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.expired_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.remark') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.project') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.bank_acc') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.username') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.receipt') }}
                    </th>
                    <th>
                        {{ trans('cruds.eBillListing.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- set up the modal to start hidden and fade in and out -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ trans('global.areYouSure') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- dialog body -->
            <div class="modal-body">
                <img class="container" id="img">
                <div class="container">
                    <form method="POST" id="approve-form">
                        @method('PUT')
                        @csrf
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.type') }}</td>
                                <td><input class="form-control" type="text" name="type" id="type" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.amount') }}</td>
                                <td><input class="form-control" type="text" id="amount" name="amount" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.expired_date') }}</td>
                                <td><input class="form-control" type="text" name="expired_date" id="expired_date" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.remark') }}</td>
                                <td><input class="form-control" type="text" name="remark" id="remark" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.project') }}</td>
                                <td><input class="form-control" type="text" name="project" id="project" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.unit') }}</td>
                                <td><input class="form-control" type="text" name="unit" id="unit" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.bank_acc') }}</td>
                                <td><input class="form-control" type="text" name="bank_acc" id="bank_acc" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.username') }}</td>
                                <td><input class="form-control" type="text" name="username" id="username" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.payment_method') }}</td>
                                <td><input class="form-control" type="text" name="payment_method" id="payment_method" readonly></td>
                            </tr>
                        </table>
                        <input type="hidden" name="status" value="paid">
                    </form>
                </div>
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="event.preventDefault();document.getElementById('approve-form').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- set up the modal to start hidden and fade in and out -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ trans('global.areYouSure') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- dialog body -->
            <div class="modal-body">
                <img class="container" id="img">
                <div class="container">
                    <form method="POST" id="reject-form">
                        @method('PUT')
                        @csrf
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.type') }}</td>
                                <td><input class="form-control" type="text" name="type" id="type" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.amount') }}</td>
                                <td><input class="form-control" type="text" id="amount" name="amount" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.expired_date') }}</td>
                                <td><input class="form-control" type="text" name="expired_date" id="expired_date" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.remark') }}</td>
                                <td><input class="form-control" type="text" name="remark" id="remark" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.project') }}</td>
                                <td><input class="form-control" type="text" name="project" id="project" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.unit') }}</td>
                                <td><input class="form-control" type="text" name="unit" id="unit" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.bank_acc') }}</td>
                                <td><input class="form-control" type="text" name="bank_acc" id="bank_acc" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.username') }}</td>
                                <td><input class="form-control" type="text" name="username" id="username" readonly></td>
                            </tr>
                            <tr>
                                <td>{{ trans('cruds.eBillListing.fields.payment_method') }}</td>
                                <td><input class="form-control" type="text" name="payment_method" id="payment_method" readonly></td>
                            </tr>
                        </table>
                        <input type="hidden" name="status" value="reject">
                    </form>
                </div>
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="event.preventDefault();document.getElementById('reject-form').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        var firstTime = true;
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('e_bill_listing_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.e-bill-listings.massDestroy') }}",
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
            pageLength: localStorage.getItem("eBillListing") ? JSON.parse(localStorage.getItem("eBillListing"))['length'] ? JSON.parse(localStorage.getItem("eBillListing"))['length'] :10 : 10,
            search :{
                regex : true,
            },
            bSort: false,
            orderCellsTop: true,
            ajax: {
                url: "{{ route('admin.e-bill-listings.index') }}",
                data: function(d) {

                    if (localStorage.getItem("eBillListing") && firstTime) {
                        var eBillListing = JSON.parse(localStorage.getItem("eBillListing"));

                        var page = eBillListing['page'] ? eBillListing['page'] : 0;
                        var length = eBillListing['length'] ? eBillListing['length'] : 10;

                        d.start = page * length;
                    }

                    d.min_date = moment($('#min-date').val()).format('YYYY-MM-DD');
                    d.max_date = moment($('#max-date').val()).format('YYYY-MM-DD');
                }
            },
            initComplete: function(settings, json) {
                if (localStorage.getItem("eBillListing")) {
                    var eBillListing = JSON.parse(localStorage.getItem("eBillListing"));
                    if (eBillListing['page']) {
                        const api = $.fn.dataTable.Api(settings);
                        api.page(eBillListing['page']).draw(false);
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
                { data: 'type', name: 'type' },
                { data: 'payment_method', name: 'payment_method.method' },
                { data: 'amount', name: 'amount', class: 'dt-body-right' },
                { data: 'expired_date', name: 'expired_date' },
                { data: 'remark', name: 'remark' },
                { data: 'project_project_code', name: 'project.project_code' },
                { data: 'unit_unit_code', name: 'unit.unit_code' },
                { data: 'bank_acc_bank_account', name: 'bank_acc.bank_account' },
                { data: 'username_name', name: 'username.name' },
                { data: 'receipt', name: 'receipt', sortable: false, searchable: false },
                { data: 'status', name: 'e_bill_listings.status' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
        };
        let table = $('.datatable-EBillListing').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.datatable-EBillListing').on( 'page.dt', function () {
            datatable_set_page_and_length();
        });

        $('.datatable-EBillListing').on( 'length.dt', function ( e, settings, len ) {
            datatable_set_page_and_length();
        });

        function datatable_set_page_and_length() {
            var info = table.page.info();

            if (localStorage.getItem("eBillListing")) {
                var eBillListing = JSON.parse(localStorage.getItem("eBillListing"));
            }

            eBillListing['page'] = info.page;
            eBillListing['length'] = info.length;

            localStorage.setItem("eBillListing", JSON.stringify(eBillListing));
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

        $('#search #type').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.eBillListing.fields.type') }}",
            allowClear: true
        });

        $('#search #status').select2({
            multiple: true,
            placeholder: "{{ trans('cruds.eBillListing.fields.status') }}",
            allowClear: true
        });

        var today = moment();

        $('#min-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            if (min.isAfter(today, 'days')) {
                $('#min-date').val(today.format("YYYY-MM-DD"))
                alert('cannot choose over today')
            }

            if (min.isAfter(max, 'days') && min) {
                $('#max-date').val($('#min-date').val())
            }
        });
        $('#max-date').change(function() {
            var min = moment($('#min-date').val());
            var max = moment($('#max-date').val());

            // if (max.isAfter(today, 'days')) {
            //     $('#max-date').val(today.format("YYYY-MM-DD"))
            //     alert('cannot choose over today')
            // }

            if (max.isBefore(min, 'days') && max) {
                $('#min-date').val($('#max-date').val())
            }
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
            // set min date / max date default value
            $('#min-date').val(moment().format("YYYY-MM-DD"));
            $('#max-date').val(moment().format("YYYY-MM-DD"));

            $('#search #project').val('');
            $('#search #unit').val('');
            $('#search #payment_method').val('');
            $('#search #amount').val('');
            $('#search #bank_acc').val('');
            $('#search #username').val('');

            $('#search #type').val('All').trigger('change');
            $('#search #status').val('All').trigger('change');
        }

        function Default() {
            if (localStorage.getItem("eBillListing")) {
                var searching = JSON.parse(localStorage.getItem("eBillListing"));

                // set min date / max date default value
                $('#search #min-date').val(searching['min-date'] ? searching['min-date'] : moment().format("YYYY-MM-DD"));
                $('#search #max-date').val(searching['max-date'] ? searching['max-date'] : moment().format("YYYY-MM-DD"));

                $('#search #project').val(searching['project'] ? searching['project'] : '');
                $('#search #unit').val(searching['unit'] ? searching['unit'] : '');
                $('#search #payment_method').val(searching['payment_method'] ? searching['payment_method'] : '');
                $('#search #amount').val(searching['amount'] ? searching['amount'] : '');
                $('#search #bank_acc').val(searching['bank_acc'] ? searching['bank_acc'] : '');
                $('#search #username').val(searching['username'] ? searching['username'] : '');

                $('#search #type').val(searching['type'] ? searching['type'] : 'All').trigger('change');
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

            var project = $('#search #project').val();
            table
                .columns(7)
                .search(project)
                .draw();

            var unit = $('#search #unit').val();
            table
                .columns(8)
                .search(unit)
                .draw();

            var type = $('#search #type').val();
            if(jQuery.inArray("All", type) === -1) {
                searchingFunction(type, 2);
            } else {
                table
                    .columns(2)
                    .search('',true,false)
                    .draw();
            }

            var payment_method = $('#search #payment_method').val();
            table
                .columns(3)
                .search(payment_method)
                .draw();

            var amount = $('#search #amount').val();
            table
                .columns(4)
                .search(amount)
                .draw();

            var bank_acc = $('#search #bank_acc').val();
            table
                .columns(9)
                .search(bank_acc)
                .draw();

            var username = $('#search #username').val();
            table
                .columns(10)
                .search(username)
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

            var eBillListing = {
                'project'       : project,
                'unit'          : unit,
                'payment_method': payment_method,
                'type'          : type,
                'amount'        : amount,
                'bank_acc'      : bank_acc,
                'username'      : username,
                'status'        : status,
                'min-date'      : $('#min-date').val(),
                'max-date'      : $('#max-date').val()
            };

            if (localStorage.getItem("eBillListing") && firstTime) {
                var eBillListing = JSON.parse(localStorage.getItem("eBillListing"));

                var page = eBillListing['page'] ? eBillListing['page'] : 0;
                var length = eBillListing['length'] ? eBillListing['length'] : 10;

                eBillListing['page'] = page;
                eBillListing['length'] = length;
            }

            localStorage.setItem("eBillListing", JSON.stringify(eBillListing));
        }

        $('#search_form_submit').on('click', function(e) {
            e.preventDefault();

            $('.btn_controller').prop('disabled', true);

            Searching();
        })

});

</script>

<script>
    $('#approveModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Button that triggered the modal
        var data = button.data('row');          // Extract info from data-* attributes
        var img = button.data('img');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        // set image
        modal.find('.modal-body #img').attr('src', img);
        // set action
        var action = "{{ route('admin.e-bill-listings.owner_approval_payement', 'id') }}";
        modal.find('.modal-body #approve-form').attr('action', action.replace('id', data.id));
        // set data
        modal.find('.modal-body #type').val(data.type);
        modal.find('.modal-body #amount').val(data.amount);
        modal.find('.modal-body #expired_date').val(data.expired_date);
        modal.find('.modal-body #remark').val(data.remark);
        modal.find('.modal-body #project').val(data.project.project_code);
        modal.find('.modal-body #unit').val(data.unit.unit_code);
        modal.find('.modal-body #bank_acc').val(data.bank_acc.bank_account);
        modal.find('.modal-body #username').val(data.username.name);
        modal.find('.modal-body #payment_method').val(data.payment_method.method);
    });
</script>
<script>
    $('#rejectModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Button that triggered the modal
        var data = button.data('row');          // Extract info from data-* attributes
        var img = button.data('img');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        // set image
        modal.find('.modal-body #img').attr('src', img);
        // set action
        var action = "{{ route('admin.e-bill-listings.owner_approval_payement', 'id') }}";
        modal.find('.modal-body #reject-form').attr('action', action.replace('id', data.id));
        // set data
        modal.find('.modal-body #type').val(data.type);
        modal.find('.modal-body #amount').val(data.amount);
        modal.find('.modal-body #expired_date').val(data.expired_date);
        modal.find('.modal-body #remark').val(data.remark);
        modal.find('.modal-body #project').val(data.project.project_code);
        modal.find('.modal-body #unit').val(data.unit.unit_code);
        modal.find('.modal-body #bank_acc').val(data.bank_acc.bank_account);
        modal.find('.modal-body #username').val(data.username.name);
        modal.find('.modal-body #payment_method').val(data.payment_method.method);
    });
</script>

@endsection
