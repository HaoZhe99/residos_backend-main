<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRentRequest;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Amenity;
use App\Models\Rent;
use App\Models\UnitManagement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Carbon\Carbon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('rent_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $rents = Rent::with(['tenant', 'amenities', 'unit_owner'])->get();
        if ($request->ajax()) {
            $query = Rent::with(['tenant', 'amenities', 'unit_owner'])
                ->select(sprintf('%s.*', (new Rent)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'rent_show';
                $editGate      = 'rent_edit';
                $deleteGate    = 'rent_delete';
                $crudRoutePart = 'rents';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $query->whereDate('start_rent_day', '>=', $request->min_date);
            $query->whereDate('start_rent_day', '<=', $request->max_date);

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('tenant', function ($row) {
                return $row->tenant ? $row->tenant->name : "";
            });

            $table->editColumn('rent_fee', function ($row) {
                return $row->rent_fee ? $row->rent_fee : "";
            });

            $table->editColumn('day_of_month', function ($row) {
                return $row->day_of_month ? Rent::DAY_OF_MONTH_SELECT[$row->day_of_month] : '';
            });

            $table->editColumn('leases', function ($row) {
                return $row->leases ? $row->leases : "";
            });

            $table->editColumn('start_rent_day', function ($row) {
                return $row->start_rent_day ? $row->start_rent_day : "";
            });

            $table->editColumn('end_rent_day', function ($row) {
                return $row->end_rent_day ? $row->end_rent_day : "";
            });

            $table->editColumn('bank_acc', function ($row) {
                return $row->bank_acc ? $row->bank_acc : "";
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? Rent::STSTUS_SELECT[$row->status] : '';
            });

            $table->editColumn('type', function ($row) {
                return $row->type ? Rent::TYPE_SELECT[$row->type] : '';
            });

            $table->editColumn('slot_limit', function ($row) {
                return $row->slot_limit ? $row->slot_limit : "";
            });

            $table->editColumn('room_size', function ($row) {
                return $row->room_size ? $row->room_size : "";
            });

            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });

            $table->editColumn('amenities', function ($row) {
                $labels = [];
                foreach ($row->amenities as $amenity) {

                    $labels[] = sprintf('<span class="badge badge-info badge-many">%s</span>', $amenity->type);
                }
                return implode(' ', $labels);
            });

            $table->editColumn('unit_owner', function ($row) {
                return $row->unit_owner ? $row->unit_owner->owner->name : "";
            });

            $table->editColumn('unit_owner_unit_code', function ($row) {
                return $row->unit_owner ? $row->unit_owner->unit_code : "";
            });

            $table->editColumn('image', function ($row) {
                if (!$row->image) {
                    return '';
                }
                $links = [];

                foreach ($row->image as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src"' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'image', 'tenant', 'amenities', 'unit_owner']);

            return $table->make(true);
        }
        // return view('admin.rents.index', compact('rents'));
        return view('admin.rents.index');
    }

    public function create()
    {
        abort_if(Gate::denies('rent_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $amenities = Amenity::all()->pluck('type', 'id');

        $unit_owners = UnitManagement::whereNotIn('id', Rent::pluck('unit_owner_id'))->pluck('unit_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.rents.create', compact('tenants', 'amenities', 'unit_owners'));
    }

    public function store(StoreRentRequest $request)
    {
        $rent = Rent::create([
            'rent_fee' => $request->rent_fee,
            'status' => $request->status,
            'type' => $request->type,
            'slot_limit' => $request->slot_limit,
            'room_size' => $request->room_size,
            'bank_acc' => $request->bank_acc,
            'tenant_id' => $request->tenant_id,
            'day_of_month' => $request->day_of_month,
            'bank_acc' => $request->bank_acc,
            'remark' => $request->room_size,
            'start_rent_day' => $request->start_rent_day,
            'end_rent_day' => (new Carbon($request->start_rent_day))->addMonth($request->leases),
            'leases' => $request->leases,
            'unit_owner_id' => $request->unit_owner_id,
        ]);

        $rent->amenities()->sync($request->input('amenities', []));

        foreach ($request->input('image', []) as $file) {
            $rent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $rent->id]);
        }

        return redirect()->route('admin.rents.index');
    }

    public function edit(Rent $rent)
    {
        abort_if(Gate::denies('rent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $amenities = Amenity::all()->pluck('type', 'id');

        $unit_owners = UnitManagement::all()->pluck('unit_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $rent->load('tenant', 'amenities', 'unit_owner');

        return view('admin.rents.edit', compact('tenants', 'amenities', 'unit_owners', 'rent'));
    }

    public function update(UpdateRentRequest $request, Rent $rent)
    {
        $rent->update([
            'tenant_id' => $request->tenant_id,
            'rent_fee' => $request->rent_fee,
            'status' => $request->status,
            'type' => $request->type,
            'slot_limit' => $request->slot_limit,
            'room_size' => $request->room_size,
            'bank_acc' => $request->bank_acc,
            'day_of_month' => $request->day_of_month,
            'bank_acc' => $request->bank_acc,
            'remark' => $request->room_size,
            'start_rent_day' => $request->start_rent_day,
            'end_rent_day' => (new Carbon($request->start_rent_day))->addMonth($request->leases),
            'leases' => $request->leases,
            'unit_owner_id' => $request->unit_owner_id,
        ]);

        $rent->amenities()->sync($request->input('amenities', []));

        if (count($rent->image) > 0) {
            foreach ($rent->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }

        $media = $rent->image->pluck('file_name')->toArray();

        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $rent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.rents.index');
    }

    public function show(Rent $rent)
    {
        abort_if(Gate::denies('rent_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rent->load('tenant', 'amenities', 'unit_owner');

        return view('admin.rents.show', compact('rent'));
    }

    public function destroy(Rent $rent)
    {
        abort_if(Gate::denies('rent_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rent->delete();

        return back();
    }

    public function massDestroy(MassDestroyRentRequest $request)
    {
        Rent::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('rent_create') && Gate::denies('rent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Rent();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
