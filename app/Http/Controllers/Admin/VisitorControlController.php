<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVisitorControlRequest;
use App\Http\Requests\StoreVisitorControlRequest;
use App\Http\Requests\UpdateVisitorControlRequest;
use App\Models\User;
use App\Models\VisitorControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VisitorControlController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('visitor_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $visitorControls = VisitorControl::with(['username', 'add_by'])->get();

        if ($request->ajax()) {
            $query = VisitorControl::with(['username', 'add_by'])
                ->select(sprintf('%s.*', (new VisitorControl)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'visitor_control_show';
                $editGate      = 'visitor_control_edit';
                $deleteGate    = 'visitor_control_delete';
                $crudRoutePart = 'visitor-controls';

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

            $table->addColumn('username', function ($row) {
                return $row->username ? $row->username->name : '';
            });

            $table->addColumn('add_by', function ($row) {
                return $row->add_by ? $row->add_by->name : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? VisitorControl::STATUS_SELECT[$row->status] : '';
            });

            $table->editColumn('favourite', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->favourite ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'username', 'add_by', 'status', 'favourite']);

            return $table->make(true);
        }

        return view('admin.visitorControls.index');
        // return view('admin.visitorControls.index', compact('visitorControls'));
    }

    public function create()
    {
        abort_if(Gate::denies('visitor_control_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $add_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.visitorControls.create', compact('usernames', 'add_bies'));
    }

    public function store(StoreVisitorControlRequest $request)
    {
        $visitorControl = VisitorControl::create($request->all());

        return redirect()->route('admin.visitor-controls.index');
    }

    public function edit(VisitorControl $visitorControl)
    {
        abort_if(Gate::denies('visitor_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $add_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $visitorControl->load('username', 'add_by');

        return view('admin.visitorControls.edit', compact('usernames', 'add_bies', 'visitorControl'));
    }

    public function update(UpdateVisitorControlRequest $request, VisitorControl $visitorControl)
    {
        $visitorControl->update($request->all());

        return redirect()->route('admin.visitor-controls.index');
    }

    public function show(VisitorControl $visitorControl)
    {
        abort_if(Gate::denies('visitor_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitorControl->load('username', 'add_by');

        return view('admin.visitorControls.show', compact('visitorControl'));
    }

    public function destroy(VisitorControl $visitorControl)
    {
        abort_if(Gate::denies('visitor_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visitorControl->delete();

        return back();
    }

    public function massDestroy(MassDestroyVisitorControlRequest $request)
    {
        VisitorControl::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
