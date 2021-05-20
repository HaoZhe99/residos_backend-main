<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFacilityMaintainRequest;
use App\Http\Requests\StoreFacilityMaintainRequest;
use App\Http\Requests\UpdateFacilityMaintainRequest;
use App\Models\FacilityListing;
use App\Models\FacilityMaintain;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FacilityMaintainController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('facility_maintain_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FacilityMaintain::with(['username', 'facility_code'])
                ->select(sprintf('%s.*', (new FacilityMaintain)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'facility_maintain_show';
                $editGate      = 'facility_maintain_edit';
                $deleteGate    = 'facility_maintain_delete';
                $crudRoutePart = 'facility-maintains';

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
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->addColumn('username_name', function ($row) {
                return $row->username ? $row->username->name : '';
            });

            $table->addColumn('facility_code_facility_code', function ($row) {
                return $row->facility_code ? $row->facility_code->facility_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'username', 'facility_code']);

            return $table->make(true);
        }

        return view('admin.facilityMaintains.index');
    }

    public function create()
    {
        abort_if(Gate::denies('facility_maintain_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facility_codes = FacilityListing::all()->pluck('facility_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.facilityMaintains.create', compact('usernames', 'facility_codes'));
    }

    public function store(StoreFacilityMaintainRequest $request)
    {
        $facilityMaintain = FacilityMaintain::create($request->all());

        return redirect()->route('admin.facility-maintains.index');
    }

    public function edit(FacilityMaintain $facilityMaintain)
    {
        abort_if(Gate::denies('facility_maintain_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facility_codes = FacilityListing::all()->pluck('facility_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facilityMaintain->load('username', 'facility_code');

        return view('admin.facilityMaintains.edit', compact('usernames', 'facility_codes', 'facilityMaintain'));
    }

    public function update(UpdateFacilityMaintainRequest $request, FacilityMaintain $facilityMaintain)
    {
        $facilityMaintain->update($request->all());

        return redirect()->route('admin.facility-maintains.index');
    }

    public function show(FacilityMaintain $facilityMaintain)
    {
        abort_if(Gate::denies('facility_maintain_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityMaintain->load('username', 'facility_code');

        return view('admin.facilityMaintains.show', compact('facilityMaintain'));
    }

    public function destroy(FacilityMaintain $facilityMaintain)
    {
        abort_if(Gate::denies('facility_maintain_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityMaintain->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacilityMaintainRequest $request)
    {
        FacilityMaintain::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
