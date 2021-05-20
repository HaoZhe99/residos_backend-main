<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvanceSettingRequest;
use App\Http\Requests\UpdateAdvanceSettingRequest;
use App\Http\Resources\Admin\AdvanceSettingResource;
use App\Models\AdvanceSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdvanceSettingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('advance_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdvanceSettingResource(AdvanceSetting::all());
    }

    public function store(StoreAdvanceSettingRequest $request)
    {
        $advanceSetting = AdvanceSetting::create($request->all());

        return (new AdvanceSettingResource($advanceSetting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdvanceSetting $advanceSetting)
    {
        abort_if(Gate::denies('advance_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdvanceSettingResource($advanceSetting);
    }

    public function update(UpdateAdvanceSettingRequest $request, AdvanceSetting $advanceSetting)
    {
        $advanceSetting->update($request->all());

        return (new AdvanceSettingResource($advanceSetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdvanceSetting $advanceSetting)
    {
        abort_if(Gate::denies('advance_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advanceSetting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
