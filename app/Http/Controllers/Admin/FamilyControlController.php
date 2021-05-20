<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFamilyControlRequest;
use App\Http\Requests\StoreFamilyControlRequest;
use App\Http\Requests\UpdateFamilyControlRequest;
use App\Models\FamilyControl;
use App\Models\UnitManagement;
use App\Models\UnitMangement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FamilyControlController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('family_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FamilyControl::with(['family', 'unit_owner'])
                ->select(sprintf('%s.*', (new FamilyControl)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'family_control_show';
                $editGate      = 'family_control_edit';
                $deleteGate    = 'family_control_delete';
                $crudRoutePart = 'family-controls';

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
            $table->addColumn('family_name', function ($row) {
                return $row->family ? $row->family->name : '';
            });

            $table->addColumn('unit_owner_unit_owner', function ($row) {
                return $row->unit_owner ? $row->unit_owner->unit_owner : '';
            });

            $table->editColumn('activity_logs', function ($row) {
                return $row->activity_logs ? FamilyControl::ACTIVITY_LOGS_SELECT[$row->activity_logs] : '';
            });
            $table->editColumn('from_family', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->from_family ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'family', 'unit_owner', 'from_family']);

            return $table->make(true);
        }

        return view('admin.familyControls.index');
    }

    public function create()
    {
        abort_if(Gate::denies('family_control_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $families = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $unit_owners = UnitManagement::all()->pluck('unit_owner', 'id')->prepend(trans('global.pleaseSelect'), '');
        // dd($unit_owners);

        return view('admin.familyControls.create', compact('families', 'unit_owners'));
    }

    public function store(StoreFamilyControlRequest $request)
    {
        $familyControl = FamilyControl::create($request->all());

        return redirect()->route('admin.family-controls.index');
    }

    public function edit(FamilyControl $familyControl)
    {
        abort_if(Gate::denies('family_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $families = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $unit_owners = UnitManagement::all()->pluck('unit_owner', 'id')->prepend(trans('global.pleaseSelect'), '');

        $familyControl->load('family', 'unit_owner');

        return view('admin.familyControls.edit', compact('families', 'unit_owners', 'familyControl'));
    }

    public function update(UpdateFamilyControlRequest $request, FamilyControl $familyControl)
    {
        $familyControl->update($request->all());

        return redirect()->route('admin.family-controls.index');
    }

    public function show(FamilyControl $familyControl)
    {
        abort_if(Gate::denies('family_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $familyControl->load('family', 'unit_owner');

        return view('admin.familyControls.show', compact('familyControl'));
    }

    public function destroy(FamilyControl $familyControl)
    {
        abort_if(Gate::denies('family_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $familyControl->delete();

        return back();
    }

    public function massDestroy(MassDestroyFamilyControlRequest $request)
    {
        FamilyControl::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
