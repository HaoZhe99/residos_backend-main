<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDefectCategoryRequest;
use App\Http\Requests\UpdateDefectCategoryRequest;
use App\Http\Resources\Admin\DefectCategoryResource;
use App\Models\DefectCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefectCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('defect_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DefectCategoryResource(DefectCategory::all());
    }

    public function store(StoreDefectCategoryRequest $request)
    {
        $defectCategory = DefectCategory::create($request->all());

        return (new DefectCategoryResource($defectCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DefectCategory $defectCategory)
    {
        abort_if(Gate::denies('defect_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DefectCategoryResource($defectCategory);
    }

    public function update(UpdateDefectCategoryRequest $request, DefectCategory $defectCategory)
    {
        $defectCategory->update($request->all());

        return (new DefectCategoryResource($defectCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DefectCategory $defectCategory)
    {
        abort_if(Gate::denies('defect_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $defectCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
