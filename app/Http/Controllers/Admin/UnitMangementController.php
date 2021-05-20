<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUnitMangementRequest;
use App\Http\Requests\StoreUnitMangementRequest;
use App\Http\Requests\UpdateUnitMangementRequest;
use App\Models\AddUnit;
use App\Models\ProjectListing;
use App\Models\UnitManagement;
use App\Models\UnitMangement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UnitMangementController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_mangement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitManagement::with(['project_code', 'unit', 'owner'])
                ->select(sprintf('%s.*', (new UnitManagement)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'unit_mangement_show';
                $editGate      = 'unit_mangement_edit';
                $deleteGate    = 'unit_mangement_delete';
                $crudRoutePart = 'unit-mangements';

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
            $table->editColumn('project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : "";
            });
            $table->editColumn('unit_code', function ($row) {
                return $row->unit_code ? $row->unit_code : "";
            });
            $table->editColumn('unit', function ($row) {
                return $row->unit ? $row->unit->unit : "";
            });
            $table->editColumn('floor_size', function ($row) {
                return $row->floor_size ? $row->floor_size : "";
            });
            $table->editColumn('bed_room', function ($row) {
                return $row->bed_room ? $row->bed_room : "";
            });
            $table->editColumn('toilet', function ($row) {
                return $row->toilet ? $row->toilet : "";
            });
            // $table->editColumn('floor_level', function ($row) {
            //     return $row->floor_level ? $row->floor_level : "";
            // });
            $table->editColumn('carpark_slot', function ($row) {
                return $row->carpark_slot ? $row->carpark_slot : "";
            });
            $table->editColumn('bumi_lot', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->bumi_lot ? 'checked' : null) . '>';
            });
            // $table->editColumn('block', function ($row) {
            //     return $row->block ? $row->block : "";
            // });
            $table->editColumn('owner', function ($row) {
                return $row->owner ? $row->owner->name : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? UnitManagement::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('balcony', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->balcony ? 'checked' : null) . '>';
            });
            $table->editColumn('spa', function ($row) {
                return $row->spa ? '<a href="' . $row->spa->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'bumi_lot', 'balcony', 'spa']);

            return $table->make(true);
        }

        return view('admin.unitMangements.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_mangement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes  = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = AddUnit::whereNotIn('id', UnitManagement::pluck('unit_id'))->pluck('unit', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owners = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.unitMangements.create', compact('project_codes', 'owners', 'units'));
    }

    public function store(StoreUnitMangementRequest $request)
    {
        $unit = AddUnit::find($request->unit_id)->load(['block']);
        $user = User::find($request->owner_id);

        // $unitManagement = UnitManagement::create($request->all());
        $unitManagement = UnitManagement::create([
            'unit_code'     => $request->unit_code,
            'floor_size'    => $request->floor_size,
            'bed_room'   => $request->bed_room,
            'toilet' => $request->toilet,
            'unit_owner'  => $unit->block->block . $unit->floor . $unit->unit . ' - ' . $user->name,
            'status' => $request->status,
            'carpark_slot'      => $request->carpark_slot,
            'project_code_id'       => $request->project_code_id,
            'unit_id'       => $request->unit_id,
            'owner_id'       => $request->owner_id,
        ]);
        // return dd($unitManagement   );
        if ($request->input('spa', false)) {
            $unitManagement->addMedia(storage_path('tmp/uploads/' . $request->input('spa')))->toMediaCollection('spa');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $unitManagement->id]);
        }

        // DB::table('unit_managements')->whereIn('unit_id', AddUnit::pluck('id'))->update(['unit_square' => 10, 'unit_owner' => 'A0101-Admin']);

        return redirect()->route('admin.unit-mangements.index');
    }

    public function edit(UnitManagement $unitMangement)
    {
        abort_if(Gate::denies('unit_mangement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes  = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = AddUnit::all()->pluck('unit', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owners = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.unitMangements.edit', compact('unitMangement', 'project_codes', 'owners', 'units'));
    }

    public function update(UpdateUnitMangementRequest $request, UnitManagement $unitMangement)
    {
        $unitMangement->update($request->all());

        if ($request->input('spa', false)) {
            if (!$unitMangement->spa || $request->input('spa') !== $unitMangement->spa->file_name) {
                if ($unitMangement->spa) {
                    $unitMangement->spa->delete();
                }

                $unitMangement->addMedia(storage_path('tmp/uploads/' . $request->input('spa')))->toMediaCollection('spa');
            }
            // } elseif ($unitManagement->spa) {
            //     $unitManagement->spa->delete();
        }

        return redirect()->route('admin.unit-mangements.index');
    }

    public function show(UnitManagement $unitMangement)
    {
        abort_if(Gate::denies('unit_mangement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitMangements.show', compact('unitMangement'));
    }

    public function destroy(UnitManagement $unitMangement)
    {
        abort_if(Gate::denies('unit_mangement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitMangement->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitMangementRequest $request)
    {
        UnitManagement::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('unit_management_create') && Gate::denies('unit_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UnitManagement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
