<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdvanceSettingRequest;
use App\Http\Requests\StoreAdvanceSettingRequest;
use App\Http\Requests\UpdateAdvanceSettingRequest;
use App\Models\AdvanceSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdvanceSettingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('advance_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AdvanceSetting::query()->select(sprintf('%s.*', (new AdvanceSetting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'advance_setting_show';
                $editGate      = 'advance_setting_edit';
                $deleteGate    = 'advance_setting_delete';
                $crudRoutePart = 'advance-settings';

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
            $table->editColumn('type', function ($row) {
                return $row->type ? AdvanceSetting::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('key', function ($row) {
                return $row->key ? $row->key : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });
            $table->editColumn('project_code', function ($row) {
                return $row->project_code ? $row->project_code : "";
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.advanceSettings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('advance_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.advanceSettings.create');
    }

    public function store(StoreAdvanceSettingRequest $request)
    {
        $advanceSetting = AdvanceSetting::create($request->all());

        return redirect()->route('admin.advance-settings.index');
    }

    public function edit(AdvanceSetting $advanceSetting)
    {
        abort_if(Gate::denies('advance_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.advanceSettings.edit', compact('advanceSetting'));
    }

    public function update(UpdateAdvanceSettingRequest $request, AdvanceSetting $advanceSetting)
    {
        $advanceSetting->update($request->all());

        return redirect()->route('admin.advance-settings.index');
    }

    public function show(AdvanceSetting $advanceSetting)
    {
        abort_if(Gate::denies('advance_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.advanceSettings.show', compact('advanceSetting'));
    }

    public function destroy(AdvanceSetting $advanceSetting)
    {
        abort_if(Gate::denies('advance_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advanceSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdvanceSettingRequest $request)
    {
        AdvanceSetting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
