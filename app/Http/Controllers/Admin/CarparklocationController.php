<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarparklocationRequest;
use App\Http\Requests\StoreCarparklocationRequest;
use App\Http\Requests\UpdateCarparklocationRequest;
use App\Models\Carparklocation;
use App\Models\ProjectListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CarparklocationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('carparklocation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Carparklocation::with(['project_code'])
                ->select(sprintf('%s.*', (new Carparklocation)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'carparklocation_show';
                $editGate      = 'carparklocation_edit';
                $deleteGate    = 'carparklocation_delete';
                $crudRoutePart = 'carparklocations';

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
            $table->editColumn('location', function ($row) {
                return $row->location ? $row->location : "";
            });
            $table->editColumn('is_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_enable ? 'checked' : null) . '>';
            });
            $table->editColumn('location_code', function ($row) {
                return $row->location_code ? $row->location_code : "";
            });
            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_enable', 'project_code']);

            return $table->make(true);
        }

        return view('admin.carparklocations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('carparklocation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.carparklocations.create', compact('project_codes'));
    }

    public function store(StoreCarparklocationRequest $request)
    {
        $carparklocation = Carparklocation::create($request->all());

        return redirect()->route('admin.carparklocations.index');
    }

    public function edit(Carparklocation $carparklocation)
    {
        abort_if(Gate::denies('carparklocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $carparklocation->load('project_code');

        return view('admin.carparklocations.edit', compact('project_codes', 'carparklocation'));
    }

    public function update(UpdateCarparklocationRequest $request, Carparklocation $carparklocation)
    {
        $carparklocation->update($request->all());

        return redirect()->route('admin.carparklocations.index');
    }

    public function show(Carparklocation $carparklocation)
    {
        abort_if(Gate::denies('carparklocation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carparklocation->load('project_code');

        return view('admin.carparklocations.show', compact('carparklocation'));
    }

    public function destroy(Carparklocation $carparklocation)
    {
        abort_if(Gate::denies('carparklocation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carparklocation->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarparklocationRequest $request)
    {
        Carparklocation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
