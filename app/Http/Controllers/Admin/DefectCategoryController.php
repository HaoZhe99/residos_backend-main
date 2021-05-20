<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDefectCategoryRequest;
use App\Http\Requests\StoreDefectCategoryRequest;
use App\Http\Requests\UpdateDefectCategoryRequest;
use App\Models\DefectCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DefectCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('defect_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DefectCategory::query()->select(sprintf('%s.*', (new DefectCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'defect_category_show';
                $editGate      = 'defect_category_edit';
                $deleteGate    = 'defect_category_delete';
                $crudRoutePart = 'defect-categories';

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
            $table->editColumn('defect_cateogry', function ($row) {
                return $row->defect_cateogry ? $row->defect_cateogry : "";
            });
            $table->editColumn('in_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->in_enable ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'in_enable']);

            return $table->make(true);
        }

        return view('admin.defectCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('defect_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.defectCategories.create');
    }

    public function store(StoreDefectCategoryRequest $request)
    {
        $defectCategory = DefectCategory::create($request->all());

        return redirect()->route('admin.defect-categories.index');
    }

    public function edit(DefectCategory $defectCategory)
    {
        abort_if(Gate::denies('defect_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.defectCategories.edit', compact('defectCategory'));
    }

    public function update(UpdateDefectCategoryRequest $request, DefectCategory $defectCategory)
    {
        $defectCategory->update($request->all());

        return redirect()->route('admin.defect-categories.index');
    }

    public function show(DefectCategory $defectCategory)
    {
        abort_if(Gate::denies('defect_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.defectCategories.show', compact('defectCategory'));
    }

    public function destroy(DefectCategory $defectCategory)
    {
        abort_if(Gate::denies('defect_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $defectCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyDefectCategoryRequest $request)
    {
        DefectCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
