<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFacilityCategoryRequest;
use App\Http\Requests\StoreFacilityCategoryRequest;
use App\Http\Requests\UpdateFacilityCategoryRequest;
use App\Models\FacilityCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FacilityCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('facility_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FacilityCategory::query()->select(sprintf('%s.*', (new FacilityCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'facility_category_show';
                $editGate      = 'facility_category_edit';
                $deleteGate    = 'facility_category_delete';
                $crudRoutePart = 'facility-categories';

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
            $table->editColumn('category', function ($row) {
                return $row->category ? $row->category : "";
            });
            $table->editColumn('in_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->in_enable ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'in_enable']);

            return $table->make(true);
        }

        return view('admin.facilityCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('facility_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.facilityCategories.create');
    }

    public function store(StoreFacilityCategoryRequest $request)
    {
        $facilityCategory = FacilityCategory::create($request->all());

        return redirect()->route('admin.facility-categories.index');
    }

    public function edit(FacilityCategory $facilityCategory)
    {
        abort_if(Gate::denies('facility_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.facilityCategories.edit', compact('facilityCategory'));
    }

    public function update(UpdateFacilityCategoryRequest $request, FacilityCategory $facilityCategory)
    {
        $facilityCategory->update($request->all());

        return redirect()->route('admin.facility-categories.index');
    }

    public function show(FacilityCategory $facilityCategory)
    {
        abort_if(Gate::denies('facility_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.facilityCategories.show', compact('facilityCategory'));
    }

    public function destroy(FacilityCategory $facilityCategory)
    {
        abort_if(Gate::denies('facility_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacilityCategoryRequest $request)
    {
        FacilityCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
