<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWaterUtilityPaymentRequest;
use App\Http\Requests\UpdateWaterUtilityPaymentRequest;
use App\Http\Resources\Admin\WaterUtilityPaymentResource;
use App\Models\WaterUtilityPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\AddUnit;
use App\Models\EBillListing;
use App\Models\UnitManagement;
use App\Models\WaterUtilitySetting;

class WaterUtilityPaymentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('water_utility_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new WaterUtilityPaymentResource(WaterUtilityPayment::with(['unit_owner', 'payment_method'])->get());

        $waterUtilityPayments = WaterUtilityPayment::with(['unit_owner', 'unit_owner.unit']);

        if ($request->has('owner_id')) {
            $waterUtilityPayments->whereIn('unit_owner_id', UnitManagement::select('id')->where('owner_id', $request->owner_id));
        }

        if ($request->has('status')) {
            $waterUtilityPayments->where('status', $request->status);
        }

        return new WaterUtilityPaymentResource($waterUtilityPayments->get());
    }

    public function store(Request $request)
    {
        $waterUtilityPayment = WaterUtilityPayment::create($request->all());

        // if ($request->file('receipt', false)) {
        //     $waterUtilityPayment->addMedia(/*storage_path('tmp/uploads/' . */$request->file('receipt')/*)*/)->toMediaCollection('receipt');
        // }

        return (new WaterUtilityPaymentResource($waterUtilityPayment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WaterUtilityPayment $waterUtilityPayment)
    {
        abort_if(Gate::denies('water_utility_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WaterUtilityPaymentResource($waterUtilityPayment->load(['unit_owner', 'unit_owner.unit']));
    }

    public function update(Request $request, WaterUtilityPayment $waterUtilityPayment)
    {
        $waterUtilityPayment->update($request->all());

        // if ($request->file('receipt', false)) {
        //     if (!$waterUtilityPayment->receipt || $request->file('receipt') !== $waterUtilityPayment->receipt->file_name) {
        //         if ($waterUtilityPayment->receipt) {
        //             $waterUtilityPayment->receipt->delete();
        //         }

        //         $waterUtilityPayment->addMedia(/*storage_path('tmp/uploads/' . */$request->file('receipt')/*)*/)->toMediaCollection('receipt');
        //     }
        //     } elseif ($waterUtilityPayment->receipt) {
        //         $waterUtilityPayment->receipt->delete();
        // }

        return (new WaterUtilityPaymentResource($waterUtilityPayment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WaterUtilityPayment $waterUtilityPayment)
    {
        abort_if(Gate::denies('water_utility_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $waterUtilityPayment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function scanQrCode(Request $request)
    {
        $waterUtilityPayment = array();
        $setting = WaterUtilitySetting::find(1);
        $addUnit = AddUnit::select('id')->where('meter', $request->qrcode)->first();

        if ($addUnit != null) {
            $unit = UnitManagement::where('unit_id', $addUnit->id)->first();

            if ($unit != null) {
                $request['unit_owner_id'] = $unit->id;
                $last = WaterUtilityPayment::where('unit_owner_id', $unit->id)->latest()->first();

                if ($last != null) {
                    $request['last_date'] = ($last->created_at)->format('Y-m-d');
                    $request['last_meter'] = $last->this_meter;
                    $request['prev_consume'] = $last->this_consume;
                    $request['this_consume'] = $request->this_meter - $last->this_meter;
                    $request['variance'] = ($request->this_consume - $request->prev_consume) / $request->prev_consume * 100;
                } else {
                    $request['last_meter'] = 0;
                    $request['prev_consume'] = 0;
                    $request['this_consume'] = $request->this_meter;
                    $request['variance'] = 0;
                }

                if ($last == null || ($last->created_at)->format('Y-m-d') != now()->format('Y-m-d')) {
                    $waterUtilityPayment = WaterUtilityPayment::create($request->all());

                    $a = EBillListing::create([
                        'type' => 'Water Utilities',
                        'payment_method_id' => 1,
                        'amount' => $setting->amount_per_consumption * $request->this_consume,
                        'status' => 'outstanding',
                        'project_id' => $setting->project_id,
                        'unit_id' => $addUnit->id,
                        'bank_acc_id' => 1,
                        'username_id' => $unit->id,
                        'payment_method_id' => 1,
                    ]);
                    // return dd('hhh' . $a);

                    return (new WaterUtilityPaymentResource($waterUtilityPayment))
                        ->response()
                        ->setStatusCode(Response::HTTP_CREATED);
                }
            }
        }

        return new WaterUtilityPaymentResource($waterUtilityPayment);
    }
}
