<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWaterUtilitySettingRequest;
use App\Http\Requests\UpdateWaterUtilitySettingRequest;
use App\Http\Resources\Admin\WaterUtilitySettingResource;
use App\Models\WaterUtilitySetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterUtilitySettingsApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('water_utility_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $waterUtilitySetting = WaterUtilitySetting::with('project_code');

        if ($request->has('project_code_id')) {
            $waterUtilitySetting->where('project_id', $request->project_code_id);
        }

        return new WaterUtilitySettingResource($waterUtilitySetting->get());
    }

    public function store(StoreWaterUtilitySettingRequest $request)
    {
        $waterUtilitySetting = WaterUtilitySetting::create($request->all());

        return (new WaterUtilitySettingResource($waterUtilitySetting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WaterUtilitySetting $waterUtilitySetting)
    {
        abort_if(Gate::denies('water_utility_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WaterUtilitySettingResource($waterUtilitySetting);
    }

    public function update(UpdateWaterUtilitySettingRequest $request, WaterUtilitySetting $waterUtilitySetting)
    {
        $waterUtilitySetting->update($request->all());

        return (new WaterUtilitySettingResource($waterUtilitySetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WaterUtilitySetting $waterUtilitySetting)
    {
        abort_if(Gate::denies('water_utility_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $waterUtilitySetting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
