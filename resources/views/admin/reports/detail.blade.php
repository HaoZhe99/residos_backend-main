@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        {{ trans('cruds.report.title') }} <b>{{$type}}</b>
        <div style="float:right;">
            <a class="btn btn-default" href="{{ route('admin.reports.index') }}">
                Back To {{ trans('global.generate') }}
            </a>
        </div>
    </div>

    <div class="card-body">
        @if ($type == 'eBilling')
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EBillListing">
                <thead>
                    <tr>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.type') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.payment_method') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.expired_date') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.remark') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.project') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.unit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.bank_acc') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.username') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.receipt') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.status') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.eBillListing.fields.created_at') }}
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right">{{ trans('cruds.report.fields.total_amount_ebill') }}</th>
                        <th style="text-align: right"></th>
                        <th colspan="8" style="text-align: right">{{ trans('cruds.report.fields.total_ebill') }}</th>
                        <th style="text-align: right"></th>
                    </tr>
                </tfoot>
            </table>
        @elseif ($type == 'transaction')
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Transaction">
                <thead>
                    <tr>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.bill_code') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.credit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.debit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.project_code') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.bank_acc') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.username') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.transaction.fields.created_at') }}
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align: right">{{ trans('cruds.report.fields.total_amount_transaction') }}</th>
                        <th style="text-align: right"></th>
                        <th style="text-align: right"></th>
                        <th colspan="3" style="text-align: right">{{ trans('cruds.report.fields.total_transaction') }}</th>
                        <th style="text-align: right"></th>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        let dtOverrideGlobals = {
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Report for {{$type}}',
                    filename: '{{$type}}',
                    className: "btn btn-success",
                    exportOptions: {
                        columns: [".export"]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Report for {{$type}}',
                    filename: '{{$type}}',
                    pageSize: 'LEGAL',
                    className: "btn btn-default",
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [".export"]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: 'Report for {{$type}}',
                    filename: '{{$type}}',
                    className: "btn btn-info",
                    exportOptions: {
                        columns: [".export"]
                    }
                },
                {
                    extend: 'print',
                    title: 'Report for {{$type}}',
                    filename: '{{$type}}',
                    className: "btn btn-default",
                    exportOptions: {
                        columns: [".export"]
                    },
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '10pt')
    
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: $(location).attr("href"),
            @if ($type == 'eBilling')
                columns: [
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
                    { data: 'created_at', name: 'created_at' },
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(),data;
                    // converting to interger to find total
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // computing column Total of the complete result 
                    var amount = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalcolumn = api.rows().count();
                    $(api.column(3).footer()).html(amount);
                    $(api.column(12).footer()).html(totalcolumn);
                },
            @elseif ($type == 'transaction')
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'bill_code', name: 'bill_code' },
                    { data: 'credit', name: 'credit', className: "text-right" },
                    { data: 'debit', name: 'debit', className: "text-right" },
                    { data: 'project_code_project_code', name: 'project_code.project_code' },
                    { data: 'bank_acc_bank_account', name: 'bank_acc.bank_account' },
                    { data: 'username_name', name: 'username.name' },
                    { data: 'created_at', name: 'created_at' },
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(),data;
                    // converting to interger to find total
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // computing column Total of the complete result 
                    var credit = api
                        .column(2)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var debit = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalcolumn = api.rows().count();
                    $(api.column(7).footer()).html(totalcolumn);
                    $(api.column(2).footer()).html(credit);
                    $(api.column(3).footer()).html(debit);
                },
            @endif

            orderCellsTop: true,
            pageLength: 25,
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: true,
                },
                @if ($type == 'Quotation_Item')
                {
                    targets: 12,
                    orderable: false,
                    searchable: true,
                    visible: false
                },
                {
                    targets: 13,
                    orderable: false,
                    searchable: true,
                    visible: false
                },
                {
                    targets: 14,
                    orderable: false,
                    searchable: true,
                    visible: false
                },
                @endif
            ],
        };
        @if ($type == 'eBilling')
            let table = $('.datatable-EBillListing').DataTable(dtOverrideGlobals);
        @elseif ($type == 'transaction')
            let table = $('.datatable-Transaction').DataTable(dtOverrideGlobals);
        @endif
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>
@endsection