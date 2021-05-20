<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEBillListingRequest;
use App\Http\Requests\UpdateEBillListingRequest;
use App\Http\Resources\Admin\EBillListingResource;
use App\Http\Resources\Admin\NotificationResource;
use App\Models\EBillListing;
use App\Models\Notification;
use App\Models\Rent;
use App\Models\UnitManagement;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use OneSignal;

class EBillListingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('e_bill_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eBillListing = EBillListing::with(['project', 'unit', 'unit.unit', 'bank_acc', 'username', 'payment_method']);

        if ($request->has('project_code_id')) {
            $eBillListing->where('project_id', $request->project_code_id);
        }

        if ($request->has('owner_id')) {
            $eBillListing->whereIn('unit_id', UnitManagement::select('id')->where('owner_id', $request->owner_id));
        }

        if ($request->has('type')) {
            $eBillListing->where('type', $request->type);
        }

        if ($request->has('status')) {
            $eBillListing->where('status', $request->status);
        }

        return new EBillListingResource($eBillListing->get());
    }

    public function store(StoreEBillListingRequest $request)
    {
        $eBillListing = EBillListing::create($request->all());

        if ($request->file('receipt', false)) {
            $eBillListing->addMedia(/*storage_path('tmp/uploads/' . */$request->file('receipt')/*)*/)->toMediaCollection('receipt');
        }

        return (new EBillListingResource($eBillListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EBillListing $eBillListing)
    {
        abort_if(Gate::denies('e_bill_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EBillListingResource($eBillListing->load(['project', 'unit', 'unit.unit', 'bank_acc', 'username', 'payment_method']));
    }

    public function update(Request $request, EBillListing $eBillListing)
    {
        $eBillListing->update($request->all());

        if ($request->file('receipt', false)) {
            if (!$eBillListing->receipt || $request->file('receipt') !== $eBillListing->receipt->file_name) {
                if ($eBillListing->receipt) {
                    $eBillListing->receipt->delete();
                }

                $eBillListing->addMedia(/*storage_path('tmp/uploads/' . */$request->file('receipt')/*)*/)->toMediaCollection('receipt');
            }
        }
        // elseif ($eBillListing->receipt) {
        //     $eBillListing->receipt->delete();
        // }

        return (new EBillListingResource($eBillListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function owner_approval_payement(Request $request, $id)
    {
        $eBillListing = EBillListing::find($id);
        $id = $eBillListing->id;
        $array_user = array((String)$id);
        if ($request->status == 'approve') {
            $eBillListing->update(['status' => 'paid']);
            $notification = Notification::create([
                'title_text' => "E-Bill Payment Successful",
                'description_text' => "Your E-Bill are approved. Payment Successful",
                'language_shortkey' => "en",
                'user_id' => $id,
                'is_active' => "1",
            ]);

            $params = [];
            $params['include_external_user_ids'] = $array_user;
            $params['headings'] = [
                "zh-Hans" => "电子账单支付成功",
                "en"      => "E-Bill Payment Successful",
                "ms"      => "E-Bill Payment Successful",
            ];
            $params['contents'] = [
                "zh-Hans" => "您的电子账单已被批准。支付成功。",
                "en"      => "Your E-Bill are approved. Payment Successful",
                "ms"      => "Your E-Bill are approved. Payment Successful",
            ];
        }

        if ($request->status == 'reject') {
            $eBillListing->update(['status' => 'reject']);
            $notification = Notification::create([
                'title_text' => "E-Bill Payment are Reject",
                'description_text' => "Your E-Bill are Reject. Payment Unsuccessful. Please call the admin.",
                'language_shortkey' => "en",
                'user_id' => $id,
                'is_active' => "1",
            ]);

            $params = [];
            $params['include_external_user_ids'] = $array_user;
            $params['headings'] = [
                "zh-Hans" => "电子账单支付不成功",
                "en"      => "E-Bill Payment are Reject",
                "ms"      => "E-Bill Payment are Reject",
            ];
            $params['contents'] = [
                "zh-Hans" => "您的电子账单被拒绝。付款不成功。请打电话给管理员。",
                "en"      => "Your E-Bill are Reject. Payment Unsuccessful. Please call the admin.",
                "ms"      => "Your E-Bill are Reject. Payment Unsuccessful. Please call the admin.",
            ];
        }

        OneSignal::sendNotificationCustom($params);

        return (new EBillListingResource($eBillListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EBillListing $eBillListing)
    {
        abort_if(Gate::denies('e_bill_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eBillListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function generate_rental_fee()
    {
        global $RentPayment;
        global $eBillListing;
        global $notification;

        $rent = Rent::where('status', '=', 'rented')->get();
        foreach ($rent as $r) {
            $now = Carbon::now();
            $month = $now->format('m');
            $year = $now->format('Y');

            if ($r->day_of_month == $now->day && $now->gt($r->start_rent_day)) {
                $diff = $now->diffInDays(Carbon::parse($r->start_rent_day));

                switch ($month) {
                    case '1':
                        if ($diff < 31) {
                            $amount = ($r->rent_fee / 31) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '2':
                        if ($diff < 30) {
                            $amount = ($r->rent_fee / 30) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '3':
                        if ($year / 4 != 0) {
                            if ($diff < 28) {
                                $amount = ($r->rent_fee / 28) * $diff;
                                $RentPayment = [
                                    'type' => "Rent",
                                    'amount' => number_format($amount, 2),
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'project_id' => $r->unit_owner->project_code_id,
                                    'unit_id' => $r->unit_owner->unit_id,
                                    'username_id' => $r->unit_owner->owner->id,
                                    'status' => "outstanding",
                                ];
                                $notification = [
                                    'title_text' => "Rent E-Bill",
                                    'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                    'language_shortkey' => "en",
                                    'user_id' => $r->unit_owner->owner->id,
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'is_active' => "1",
                                ];
                            } else {
                                $amount = $r->rent_fee;
                                $RentPayment = [
                                    'type' => "Rent",
                                    'amount' => number_format($amount, 2),
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'project_id' => $r->unit_owner->project_code_id,
                                    'unit_id' => $r->unit_owner->unit_id,
                                    'username_id' => $r->unit_owner->owner->id,
                                    'status' => "outstanding",
                                ];
                                $notification = [
                                    'title_text' => "Rent E-Bill",
                                    'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                    'language_shortkey' => "en",
                                    'user_id' => $r->unit_owner->owner->id,
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'is_active' => "1",
                                ];
                            }
                        } else if ($year / 4 == 0) {
                            if ($diff < 29) {
                                $amount = ($r->rent_fee / 29) * $diff;
                                $RentPayment = [
                                    'type' => "Rent",
                                    'amount' => number_format($amount, 2),
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'project_id' => $r->unit_owner->project_code_id,
                                    'unit_id' => $r->unit_owner->unit_id,
                                    'username_id' => $r->unit_owner->owner->id,
                                    'status' => "outstanding",
                                ];
                                $notification = [
                                    'title_text' => "Rent E-Bill",
                                    'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                    'language_shortkey' => "en",
                                    'user_id' => $r->unit_owner->owner->id,
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'is_active' => "1",
                                ];
                            } else {
                                $amount = $r->rent_fee;
                                $RentPayment = [
                                    'type' => "Rent",
                                    'amount' => number_format($amount, 2),
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'project_id' => $r->unit_owner->project_code_id,
                                    'unit_id' => $r->unit_owner->unit_id,
                                    'username_id' => $r->unit_owner->owner->id,
                                    'status' => "outstanding",
                                ];
                                $notification = [
                                    'title_text' => "Rent E-Bill",
                                    'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                    'language_shortkey' => "en",
                                    'user_id' => $r->unit_owner->owner->id,
                                    'expired_date' => $now->addMonth()->toDateTimeString(),
                                    'is_active' => "1",
                                ];
                            }
                        }

                        break;

                    case '4':
                        if ($diff < 31) {
                            $amount = ($r->rent_fee / 31) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '5':
                        if ($diff < 30) {
                            $amount = ($r->rent_fee / 30) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '6':
                        if ($diff < 31) {
                            $amount = ($r->rent_fee / 31) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '7':
                        if ($diff < 30) {
                            $amount = ($r->rent_fee / 30) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '8':
                        if ($diff < 31) {
                            $amount = ($r->rent_fee / 31) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '9':
                        if ($diff < 31) {
                            $amount = ($r->rent_fee / 31) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '10':
                        if ($diff < 30) {
                            $amount = ($r->rent_fee / 30) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    case '11':
                        if ($diff < 31) {
                            $amount = ($r->rent_fee / 31) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;
                    case '12':
                        if ($diff < 30) {
                            $amount = ($r->rent_fee / 30) * $diff;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        } else {
                            $amount = $r->rent_fee;
                            $RentPayment = [
                                'type' => "Rent",
                                'amount' => number_format($amount, 2),
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'project_id' => $r->unit_owner->project_code_id,
                                'unit_id' => $r->unit_owner->unit_id,
                                'username_id' => $r->unit_owner->owner->id,
                                'status' => "outstanding",
                            ];
                            $notification = [
                                'title_text' => "Rent E-Bill",
                                'description_text' => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                                'language_shortkey' => "en",
                                'user_id' => $r->unit_owner->owner->id,
                                'expired_date' => $now->addMonth()->toDateTimeString(),
                                'is_active' => "1",
                            ];
                        }
                        break;

                    default:
                        # code...
                        break;
                }

                $array_id = array((String)($r->unit_owner->owner->id));
                
                $params = [];
                $params['include_external_user_ids'] = $array_id;
                $params['headings'] = [
                    "zh-Hans" => "租金账单",
                    "en"      => "Rent E-Bill",
                    "ms"      => "Rent E-Bill"
                ];
                $params['contents'] = [
                    "zh-Hans" => "租金费用是RM " . number_format($amount, 2) . "请在" . $now->addMonth()->toDateTimeString() . "还钱。",
                    "en"      => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                    "ms"      => "The Fee is RM " . number_format($amount, 2) . ". Please Submit at " . $now->addMonth()->toDateTimeString() . ". Remark: Outstanding",
                ];

                OneSignal::sendNotificationCustom($params);

                if (EBillListing::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereIn('unit_id', UnitManagement::select('id')->where('unit_code', $r->unit_owner->unit_code))
                    ->get()->isEmpty()
                ) {
                    $eBillListing = EBillListing::create($RentPayment);
                    $notification = Notification::create($notification);
                } 
            }
        }

        return (new EBillListingResource($eBillListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function call_pg(Request $request)
    {
        $redirect_data = [
            'id'                => $request->id,
            'status'            => 'on_hold',
            'payment_method_id' => 2
        ];
        // $plaintext      = base64_encode(json_encode($redirect_data));
        // $cipher         = 'ASD-456-JKL';
        // $ciphertext_raw = openssl_encrypt($plaintext, $cipher, '$secretKey', $options=OPENSSL_RAW_DATA, '$productKey');
        // $hmac           = hash_hmac('sha256', $ciphertext_raw, '$secretKey', $as_binary=true);
        // $ciphertext     = base64_encode('$productKey'.$hmac.$ciphertext_raw );

        // return $ciphertext;

        $params = [];
        $params['redirect_url']       = env('APP_URL') . '/api/v1/e-bill-listings/redirect?data=' . json_encode($redirect_data);
        $params['client_transaction'] = $request->id;
        $params['gate_id']            = '10';
        $params['product_key']        = 'u64QSdIJnJqe3z2t';
        $params['secret_key']         = 'vZHkgu6eyjJuXxZpUclO8TOd8qDVR7R2';
        $params['amount']             = $request->amount;

        $response = Http::withHeaders([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json'
        ])->post('https://pg.techworlds.com.my/api/v1/top-ups/user', $params);

        if ($response->throw()) {
            return $response->throw()->json();
        }

        // 如果状态码是 500 层级的错误
        if ($response->serverError()) {
            return [
                'Response Body'   => $response->body(),
                'Response Status' => $response->status()
            ];
        }

        // 如果状态码是 400 层级的错误（401，402，403，404……）
        if ($response->clientError()) {
            return [
                'Response Body'   => $response->body(),
                'Response Status' => $response->status()
            ];
        }

        // 如果状态码 大于 400
        if ($response->failed()) {
            return [
                'Response Body'   => $response->body(),
                'Response Status' => $response->status()
            ];
        }

        // 如果状态码在 200 - 300之间
        if ($response->successful()) {
            return [
                'Response Body'   => $response->body(),
                'Response Status' => $response->status()
            ];
        }
    }

    public function redirect(Request $request)
    {
        $data = json_decode($request->data);
        $ebill  = EBillListing::find($data->id);
        $update = $ebill->update([
            'status'            => $data->status,
            'payment_method_id' => $data->payment_method_id
        ]);

        return ($update) ? view('/welcome') : view('/');
        // try {
        //     $c     = base64_decode($request);
        //     $ivlen = openssl_cipher_iv_length($cipher = 'ASD-456-JKL');
        //     $iv2   = substr($c, 0, $ivlen);
        //     if ($iv2 != '$productKey'){
        //         return "Sign error";
        //     }else{
        //         $hmac = substr($c, $ivlen, $sha2len = 32);
        //         $ciphertext_raw = substr($c, $ivlen + $sha2len);
        //         $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, '$secretKey', $options = OPENSSL_RAW_DATA, '$productKey');
        //         $calcmac = hash_hmac('sha256', $ciphertext_raw, '$secretKey', $as_binary = true);
        //         if (hash_equals($hmac, $calcmac))
        //         {
        //             return base64_decode($original_plaintext);
        //         } else {
        //             return "Sign error";
        //         }
        //     }
        // } catch (\Exception $e) {
        //     return "Sign error";
        // }

        // Sign error : your secretKey or productKey is invalid
    }

    public function call_back(Request $request)
    {
        $update = null;
        $ebill = EBillListing::find($request->client_transaction);
        if ($ebill) {
            if ($request->return_status == 'approve') {
                $update = $ebill->update([
                    'status' => 'paid'
                ]);
            } elseif ($request->return_status == 'reject') {
                $update = $ebill->update([
                    'status' => 'reject'
                ]);
            }
        }

        if ($update) {
            // send successful notice to admin or user
        } else {
            // send failed notice to admin or user
        }

        return json_encode(['status' => 'successful']);
    }
}
