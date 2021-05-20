@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan

@if(isset($approveGate))
    <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#approveModal" data-row="{{ $row }}"
    data-img="
    @if($row->receipt != null){{ $row->receipt->getUrl() }}
    @elseif($row->spa != null){{ $row->spa->getUrl() }}
    @endif
    ">Approve</button>
@endif

@if(isset($rejectGate))
    <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#rejectModal" data-row="{{ $row }}"
    data-img="
    @if($row->receipt != null){{ $row->receipt->getUrl() }}
    @elseif($row->spa != null){{ $row->spa->getUrl() }}
    @endif
    ">Reject</button>
@endif