@extends('layouts.admin')
@section('content')
@can('social_login_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.social-logins.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.socialLogin.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.socialLogin.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SocietiesLogin">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.socialLogin.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialLogin.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialLogin.fields.user_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialLogin.fields.secret') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialLogin.fields.redirect') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($socialLogins as $key => $socialLogin)
                        <tr data-entry-id="{{ $socialLogin->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $socialLogin->id ?? '' }}
                            </td>
                            <td>
                                {{ $socialLogin->name ?? '' }}
                            </td>
                            <td>
                                {{ $socialLogin->user_id ?? '' }}
                            </td>
                            <td>
                                {{ $socialLogin->secret ?? '' }}
                            </td>
                            <td>
                                {{ $socialLogin->redirect ?? '' }}
                            </td>
                            <td>
                                @can('social_login_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.social-logins.show', $socialLogin->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('social_login_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.social-logins.edit', $socialLogin->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('social_login_delete')
                                    <form action="{{ route('admin.social-logins.destroy', $socialLogin->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('social_login_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.social-logins.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-SocietiesLogin:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('div#sidebar').on('transitionend', function(e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  })
  
})

</script>
@endsection