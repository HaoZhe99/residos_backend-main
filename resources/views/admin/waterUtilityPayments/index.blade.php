@extends('layouts.admin')
@section('content')
@can('water_utility_payment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.water-utility-payments.create') }}">
                {{ trans('global.add') }} Water Utility Payment
            </a>
            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'WaterUtilityPayment', 'route' => 'admin.water-utility-payments.parseCsvImport'])
            <div class="btn-group float-right">
                <a class="btn btn-outline-primary @if ($status == 'pending') active @endif" href="{{ route('admin.water-utility-payments.index', ['status' => 'pending']) }}">
                    Pending <span class="badge rounded-pill bg-danger">@if ($total['pending'] != 0) {{ $total['pending'] }} @endif</span>
                </a>
                <a class="btn btn-outline-primary @if ($status == 'outstanding') active @endif" href="{{ route('admin.water-utility-payments.index', ['status' => 'outstanding']) }}">
                    Outstanding <span class="badge rounded-pill bg-danger">@if ($total['outstanding'] != 0) {{ $total['outstanding'] }} @endif</span>
                </a>
                <a class="btn btn-outline-primary @if ($status == 'overdue') active @endif" href="{{ route('admin.water-utility-payments.index', ['status' => 'overdue']) }}">
                    Overdue <span class="badge rounded-pill bg-danger">@if ($total['overdue'] != 0) {{ $total['overdue'] }} @endif</span>
                </a>
                <a class="btn btn-outline-primary @if ($status == 'paid') active @endif" href="{{ route('admin.water-utility-payments.index', ['status' => 'paid']) }}">
                    Paid <span class="badge rounded-pill bg-danger">@if ($total['paid'] != 0) {{ $total['paid'] }} @endif</span>
                </a>
                <a class="btn btn-outline-primary @if ($status == 'reject') active @endif" href="{{ route('admin.water-utility-payments.index', ['status' => 'reject']) }}">
                    Reject <span class="badge rounded-pill bg-danger">@if ($total['reject'] != 0) {{ $total['reject'] }} @endif</span>
                </a>
            </div> --}}
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Water Utility Payment {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-WaterUtilityPayment">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        unit_owner
                    </th>
                    <th>
                        name
                    </th>
                    <th>
                        last_date
                    </th>
                    <th>
                        last_meter
                    </th>
                    <th>
                        this_meter
                    </th>
                    <th>
                        prev_consume
                    </th>
                    <th>
                        this_consume
                    </th>
                    <th>
                        variance
                    </th>
                    {{-- <th>
                        amount
                    </th>
                    <th>
                        status
                    </th>
                    <th>
                        receipt
                    </th> --}}
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- approve function --}}
<!-- set up the modal to start hidden and fade in and out -->
{{-- <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                                <td>unit_owner</td>
                                <td><input class="form-control" type="text" id="unit_owner" readonly></td>
                            </tr>
                            <tr>
                                <td>this_consume</td>
                                <td><input class="form-control" type="text" name="this_consume" id="this_consume" readonly></td>
                            </tr>
                            <tr>
                                <td>amount</td>
                                <td><input class="form-control" type="text" name="amount" id="amount" readonly></td>
                            </tr>
                        </table>
                        <input type="hidden" name="unit_owner_id" id="unit_owner_id">
                        <input type="hidden" name="name" id="name">
                        <input type="hidden" name="last_date" id="last_date">
                        <input type="hidden" name="last_meter" id="last_meter">
                        <input type="hidden" name="this_meter" id="this_meter">
                        <input type="hidden" name="prev_consume" id="prev_consume">
                        <input type="hidden" name="variance" id="variance">
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
</div> --}}

{{-- reject function --}}
<!-- set up the modal to start hidden and fade in and out -->
{{-- <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                                <td>unit_owner</td>
                                <td><input class="form-control" type="text" id="unit_owner" readonly></td>
                            </tr>
                            <tr>
                                <td>this_consume</td>
                                <td><input class="form-control" type="text" name="this_consume" id="this_consume" readonly></td>
                            </tr>
                            <tr>
                                <td>amount</td>
                                <td><input class="form-control" type="text" name="amount" id="amount" readonly></td>
                            </tr>
                        </table>
                        <input type="hidden" name="unit_owner_id" id="unit_owner_id">
                        <input type="hidden" name="name" id="name">
                        <input type="hidden" name="last_date" id="last_date">
                        <input type="hidden" name="last_meter" id="last_meter">
                        <input type="hidden" name="this_meter" id="this_meter">
                        <input type="hidden" name="prev_consume" id="prev_consume">
                        <input type="hidden" name="variance" id="variance">
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
</div> --}}

@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('water_utility_payment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.water-utility-payments.massDestroy') }}",
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
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.water-utility-payments.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'unit_owner_unit_owner', name: 'unit_owner.unit_owner' },
        { data: 'name', name: 'name' },
        { data: 'last_date', name: 'last_date' },
        { data: 'last_meter', name: 'last_meter' },
        { data: 'this_meter', name: 'this_meter' },
        { data: 'prev_consume', name: 'prev_consume' },
        { data: 'this_consume', name: 'this_consume' },
        { data: 'variance', name: 'variance' },
        { data: 'actions', name: '{{ trans('global.actions') }}' },
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-WaterUtilityPayment').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
    <!-- sometime later, probably inside your on load event callback -->
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
        var action = "{{ route('admin.water-utility-payments.update', 'id') }}";
        modal.find('.modal-body #approve-form').attr('action', action.replace('id', data.id));
        // set data
        modal.find('.modal-body #unit_owner').val(data.unit_owner.unit_owner);
        modal.find('.modal-body #this_consume').val(data.this_consume);
        modal.find('.modal-body #amount').val(data.amount);
        modal.find('.modal-body #unit_owner_id').val(data.unit_owner.id);
        modal.find('.modal-body #name').val(data.name);
        modal.find('.modal-body #last_date').val(data.last_date);
        modal.find('.modal-body #last_meter').val(data.last_meter);
        modal.find('.modal-body #this_meter').val(data.this_meter);
        modal.find('.modal-body #prev_consume').val(data.prev_consume);
        modal.find('.modal-body #variance').val(data.variance);
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
        var action = "{{ route('admin.water-utility-payments.update', 'id') }}";
        modal.find('.modal-body #reject-form').attr('action', action.replace('id', data.id));
        // set data
        modal.find('.modal-body #unit_owner').val(data.unit_owner.unit_owner);
        modal.find('.modal-body #this_consume').val(data.this_consume);
        modal.find('.modal-body #amount').val(data.amount);
        modal.find('.modal-body #unit_owner_id').val(data.unit_owner.id);
        modal.find('.modal-body #name').val(data.name);
        modal.find('.modal-body #last_date').val(data.last_date);
        modal.find('.modal-body #last_meter').val(data.last_meter);
        modal.find('.modal-body #this_meter').val(data.this_meter);
        modal.find('.modal-body #prev_consume').val(data.prev_consume);
        modal.find('.modal-body #variance').val(data.variance);
      });
    </script>
@endsection