<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAreaRequest;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Models\Area;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Area::query()
                ->select(sprintf('%s.*', (new Area)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'area_show';
                $editGate      = 'area_edit';
                $deleteGate    = 'area_delete';
                $crudRoutePart = 'areas';

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
            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : "";
            });
            $table->editColumn('states', function ($row) {
                return $row->states ? $row->states : "";
            });
            $table->editColumn('area', function ($row) {
                return $row->area ? $row->area : "";
            });
            $table->editColumn('postcode', function ($row) {
                return $row->postcode ? $row->postcode : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.areas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('area_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.areas.create');
    }

    public function store(StoreAreaRequest $request)
    {
        $area = Area::create($request->all());

        return redirect()->route('admin.areas.index');
    }

    public function edit(Area $area)
    {
        abort_if(Gate::denies('area_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.areas.edit', compact('area'));
    }

    public function update(UpdateAreaRequest $request, Area $area)
    {
        $area->update($request->all());

        return redirect()->route('admin.areas.index');
    }

    public function show(Area $area)
    {
        abort_if(Gate::denies('area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.areas.show', compact('area'));
    }

    public function destroy(Area $area)
    {
        abort_if(Gate::denies('area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $area->delete();

        return back();
    }

    public function massDestroy(MassDestroyAreaRequest $request)
    {
        Area::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
