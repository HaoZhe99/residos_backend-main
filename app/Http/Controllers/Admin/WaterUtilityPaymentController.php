<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWaterUtilityPaymentRequest;
use App\Http\Requests\StoreWaterUtilityPaymentRequest;
use App\Http\Requests\UpdateWaterUtilityPaymentRequest;
use App\Models\UnitManagement;
use App\Models\WaterUtilityPayment;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WaterUtilityPaymentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('water_utility_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $status = $request->query('status');
        // $total = [
        //     'pending' => WaterUtilityPayment::where('status', 'pending')->count(),
        //     'outstanding' => WaterUtilityPayment::where('status', 'outstanding')->count(),
        //     'overdue' => WaterUtilityPayment::where('status', 'overdue')->count(),
        //     'paid' => WaterUtilityPayment::where('status', 'paid')->count(),
        //     'reject' => WaterUtilityPayment::where('status', 'reject')->count(),
        // ];

        if ($request->ajax()) {
            $query = WaterUtilityPayment::with(['unit_owner'])
                ->select(sprintf('%s.*', (new WaterUtilityPayment)->table));
            // ->where(sprintf('%s.status', (new WaterUtilityPayment)->table), $status)
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            // if ($status == 'pending') {
            $table->editColumn('actions', function ($row) {
                $viewGate      = 'water_utility_payment_show';
                $editGate      = 'water_utility_payment_edit';
                $deleteGate    = 'water_utility_payment_delete';
                $crudRoutePart = 'water-utility-payments';
                // $approveGate   = 'water_utility_payment_edit';
                // $rejectGate   = 'water_utility_payment_edit';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    // 'approveGate',
                    // 'rejectGate'
                ));
            });
            // }

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('unit_owner_unit_owner', function ($row) {
                return $row->unit_owner ? $row->unit_owner->unit_owner : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('last_meter', function ($row) {
                return $row->last_meter ? $row->last_meter : "";
            });
            $table->editColumn('this_meter', function ($row) {
                return $row->this_meter ? $row->this_meter : "";
            });
            $table->editColumn('prev_consume', function ($row) {
                return $row->prev_consume ? $row->prev_consume : "";
            });
            $table->editColumn('this_consume', function ($row) {
                return $row->this_consume ? $row->this_consume : "";
            });
            $table->editColumn('variance', function ($row) {
                return $row->variance ? $row->variance : "";
            });
            // $table->editColumn('amount', function ($row) {
            //     return $row->amount ? $row->amount : "";
            // });
            // $table->editColumn('status', function ($row) {
            //     return $row->status ? WaterUtilityPayment::STATUS_SELECT[$row->status] : '';
            // });

            // $table->editColumn('receipt', function ($row) {
            //     return $row->receipt ? '<a href="' . $row->receipt->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            // });

            $table->rawColumns(['actions', 'placeholder', 'unit_owner']);

            return $table->make(true);
        }

        return view('admin.waterUtilityPayments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('water_utility_payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit_owners = UnitManagement::all()->pluck('unit_owner', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.waterUtilityPayments.create', compact('unit_owners'));
    }

    public function store(StoreWaterUtilityPaymentRequest $request)
    {
        $waterUtilityPayment = WaterUtilityPayment::create($request->all());

        // if ($request->input('receipt', false)) {
        //     $waterUtilityPayment->addMedia(storage_path('tmp/uploads/' . $request->input('receipt')))->toMediaCollection('receipt');
        // }

        // if ($media = $request->input('ck-media', false)) {
        //     Media::whereIn('id', $media)->update(['model_id' => $waterUtilityPayment->id]);
        // }

        return redirect()->route('admin.water-utility-payments.index');
    }

    public function edit(WaterUtilityPayment $waterUtilityPayment)
    {
        abort_if(Gate::denies('water_utility_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit_owners = UnitManagement::all()->pluck('unit_owner', 'id')->prepend(trans('global.pleaseSelect'), '');

        $waterUtilityPayment->load('unit_owner');

        return view('admin.waterUtilityPayments.edit', compact('unit_owners', 'waterUtilityPayment'));
    }

    public function update(UpdateWaterUtilityPaymentRequest $request, WaterUtilityPayment $waterUtilityPayment)
    {
        $waterUtilityPayment->update($request->all());

        // if ($request->input('receipt', false)) {
        //     if (!$waterUtilityPayment->receipt || $request->input('receipt') !== $waterUtilityPayment->receipt->file_name) {
        //         if ($waterUtilityPayment->receipt) {
        //             $waterUtilityPayment->receipt->delete();
        //         }

        //         $waterUtilityPayment->addMedia(storage_path('tmp/uploads/' . $request->input('receipt')))->toMediaCollection('receipt');
        //     }
        //     } elseif ($waterUtilityPayment->receipt) {
        //         $waterUtilityPayment->receipt->delete();
        // }

        return redirect()->route('admin.water-utility-payments.index');
    }

    public function show(WaterUtilityPayment $waterUtilityPayment)
    {
        abort_if(Gate::denies('water_utility_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $waterUtilityPayment->load('unit_owner');

        return view('admin.waterUtilityPayments.show', compact('waterUtilityPayment'));
    }

    public function destroy(WaterUtilityPayment $waterUtilityPayment)
    {
        abort_if(Gate::denies('water_utility_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $waterUtilityPayment->delete();

        return back();
    }

    public function massDestroy(MassDestroyWaterUtilityPaymentRequest $request)
    {
        WaterUtilityPayment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    // public function storeCKEditorImages(Request $request)
    // {
    //     abort_if(Gate::denies('water_utility_payment_create') && Gate::denies('water_utility_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $model         = new WaterUtilityPayment();
    //     $model->id     = $request->input('crud_id', 0);
    //     $model->exists = true;
    //     $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

    //     return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    // }
}
