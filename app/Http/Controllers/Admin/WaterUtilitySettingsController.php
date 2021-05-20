<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWaterUtilitySettingRequest;
use App\Http\Requests\StoreWaterUtilitySettingRequest;
use App\Http\Requests\UpdateWaterUtilitySettingRequest;
use App\Models\ProjectListing;
use App\Models\WaterUtilitySetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WaterUtilitySettingsController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('water_utility_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WaterUtilitySetting::with(['project_code'])
                ->select(sprintf('%s.*', (new WaterUtilitySetting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'water_utility_setting_show';
                $editGate      = 'water_utility_setting_edit';
                $deleteGate    = 'water_utility_setting_delete';
                $crudRoutePart = 'water-utility-settings';

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
            $table->editColumn('amount_per_consumption', function ($row) {
                return $row->amount_per_consumption ? $row->amount_per_consumption : "";
            });

            $table->editColumn('project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.waterUtilitySettings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('water_utility_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_code = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'));

        return view('admin.waterUtilitySettings.create', compact('project_code'));
    }

    public function store(StoreWaterUtilitySettingRequest $request)
    {
        $waterUtilitySetting = WaterUtilitySetting::create($request->all());

        return redirect()->route('admin.water-utility-settings.index');
    }

    public function edit(WaterUtilitySetting $waterUtilitySetting)
    {
        abort_if(Gate::denies('water_utility_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_code = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'));

        return view('admin.waterUtilitySettings.edit', compact('waterUtilitySetting', 'project_code'));
    }

    public function update(UpdateWaterUtilitySettingRequest $request, WaterUtilitySetting $waterUtilitySetting)
    {
        $waterUtilitySetting->update($request->all());

        return redirect()->route('admin.water-utility-settings.index');
    }

    public function show(WaterUtilitySetting $waterUtilitySetting)
    {
        abort_if(Gate::denies('water_utility_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.waterUtilitySettings.show', compact('waterUtilitySetting'));
    }

    public function destroy(WaterUtilitySetting $waterUtilitySetting)
    {
        abort_if(Gate::denies('water_utility_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $waterUtilitySetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyWaterUtilitySettingRequest $request)
    {
        WaterUtilitySetting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
