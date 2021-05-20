<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventEnrollRequest;
use App\Http\Requests\StoreEventEnrollRequest;
use App\Http\Requests\UpdateEventEnrollRequest;
use App\Models\EventEnroll;
use App\Models\EventListing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EventEnrollController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('event_enroll_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EventEnroll::with(['username', 'event_code'])
                ->select(sprintf('%s.*', (new EventEnroll)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'event_enroll_show';
                $editGate      = 'event_enroll_edit';
                $deleteGate    = 'event_enroll_delete';
                $crudRoutePart = 'event-enrolls';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? EventEnroll::STATUS_SELECT[$row->status] : '';
            });
            $table->addColumn('username_name', function ($row) {
                return $row->username ? $row->username->name : '';
            });

            $table->addColumn('event_code_event_code', function ($row) {
                return $row->event_code ? $row->event_code->event_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'username', 'event_code']);

            return $table->make(true);
        }

        return view('admin.eventEnrolls.index');
    }

    public function create()
    {
        abort_if(Gate::denies('event_enroll_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event_codes = EventListing::all()->pluck('event_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eventEnrolls.create', compact('usernames', 'event_codes'));
    }

    public function store(StoreEventEnrollRequest $request)
    {
        $eventEnroll = EventEnroll::create($request->all());

        return redirect()->route('admin.event-enrolls.index');
    }

    public function edit(EventEnroll $eventEnroll)
    {
        abort_if(Gate::denies('event_enroll_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event_codes = EventListing::all()->pluck('event_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eventEnroll->load('username', 'event_code');

        return view('admin.eventEnrolls.edit', compact('usernames', 'event_codes', 'eventEnroll'));
    }

    public function update(UpdateEventEnrollRequest $request, EventEnroll $eventEnroll)
    {
        $eventEnroll->update($request->all());

        return redirect()->route('admin.event-enrolls.index');
    }

    public function show(EventEnroll $eventEnroll)
    {
        abort_if(Gate::denies('event_enroll_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventEnroll->load('username', 'event_code');

        return view('admin.eventEnrolls.show', compact('eventEnroll'));
    }

    public function destroy(EventEnroll $eventEnroll)
    {
        abort_if(Gate::denies('event_enroll_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventEnroll->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventEnrollRequest $request)
    {
        EventEnroll::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
