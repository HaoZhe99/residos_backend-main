<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEBillListingRequest;
use App\Http\Requests\StoreEBillListingRequest;
use App\Http\Requests\UpdateEBillListingRequest;
use App\Models\BankAccListing;
use App\Models\EBillListing;
use App\Models\PaymentMethod;
use App\Models\ProjectListing;
use App\Models\UnitManagement;
use App\Models\Notification;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use OneSignal;

class EBillListingController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('e_bill_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])
                ->select(sprintf('%s.*', (new EBillListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'e_bill_listing_show';
                $editGate      = 'e_bill_listing_edit';
                $deleteGate    = 'e_bill_listing_delete';
                $crudRoutePart = 'e-bill-listings';
                $approveGate   = 'e_bill_listing_edit';
                $rejectGate    = 'e_bill_listing_edit';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'approveGate',
                    'rejectGate'
                ));
            });

            $query->whereDate('expired_date', '>=', $request->min_date);
            $query->whereDate('expired_date', '<=', $request->max_date);

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? EBillListing::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->addColumn('payment_method', function ($row) {
                return $row->payment_method ? $row->payment_method->method : "";
            });
            $table->editColumn('expired_date', function ($row) {
                return $row->expired_date ? $row->expired_date : "";
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->addColumn('project_project_code', function ($row) {
                return $row->project ? $row->project->project_code : '';
            });

            $table->addColumn('unit_unit_code', function ($row) {
                return $row->unit ? $row->unit->unit_code : '';
            });

            $table->addColumn('bank_acc_bank_account', function ($row) {
                return $row->bank_acc ? $row->bank_acc->bank_account : '';
            });

            $table->addColumn('username_name', function ($row) {
                return $row->username ? $row->username->name : '';
            });

            $table->editColumn('receipt', function ($row) {
                return $row->receipt ? '<a href="' . $row->receipt->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? EBillListing::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'unit', 'bank_acc', 'username', 'receipt']);

            return $table->make(true);
        }

        return view('admin.eBillListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('e_bill_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitManagement::all()->pluck('unit_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bank_accs = BankAccListing::all()->pluck('bank_account', 'id')->prepend(trans('global.pleaseSelect'), '');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment_method = PaymentMethod::all()->pluck('method', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eBillListings.create', compact('projects', 'units', 'bank_accs', 'usernames', 'payment_method'));
    }

    public function store(StoreEBillListingRequest $request)
    {
        $eBillListing = EBillListing::create($request->all());

        $notification = Notification::create([
            'title_text' => $request->input('type') . " E-Bill",
            'description_text' => "The Fee is RM " . $request->input('amount') . ". Please Submit at " . $request->input('expired_date') . ". Remark: " . $request->input('remark'),
            'language_shortkey' => "en",
            'user_id' => $request->username_id,
            'expired_date' => $request->expired_date,
            'is_active' => $request->is_active,
        ]);

        $array_user = array($request->username_id);

        $params = [];
        $params['include_external_user_ids'] = $array_user;
        $params['headings'] = [
            "zh-Hans" => $request->input('type') . " 账单",
            "en"      => $request->input('type') . " E-Bill",
            "ms"      => $request->input('type') . " E-Bill"
        ];
        $params['contents'] = [
            "zh-Hans" => $request->input('type') . " 账单",
            "en"      => $request->input('type') . " E-Bill",
            "ms"      => $request->input('type') . " E-Bill"
        ];

        OneSignal::sendNotificationCustom($params);

        if ($request->input('receipt', false)) {
            $eBillListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('receipt'))))->toMediaCollection('receipt');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eBillListing->id]);
        }

        return redirect()->route('admin.e-bill-listings.index');
    }

    public function edit(EBillListing $eBillListing)
    {
        abort_if(Gate::denies('e_bill_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitManagement::all()->pluck('unit_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bank_accs = BankAccListing::all()->pluck('bank_account', 'id')->prepend(trans('global.pleaseSelect'), '');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment_method = PaymentMethod::all()->pluck('method', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eBillListing->load('project', 'unit', 'bank_acc', 'username', 'payment_method');

        return view('admin.eBillListings.edit', compact('projects', 'units', 'bank_accs', 'usernames', 'eBillListing', 'payment_method'));
    }

    public function update(UpdateEBillListingRequest $request, EBillListing $eBillListing)
    {
        $eBillListing->update($request->all());

        if ($request->input('receipt', false)) {
            if (!$eBillListing->receipt || $request->input('receipt') !== $eBillListing->receipt->file_name) {
                if ($eBillListing->receipt) {
                    $eBillListing->receipt->delete();
                }

                $eBillListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('receipt'))))->toMediaCollection('receipt');
            }
        } elseif ($eBillListing->receipt) {
            $eBillListing->receipt->delete();
        }

        return redirect()->route('admin.e-bill-listings.index');
    }

    public function show(EBillListing $eBillListing)
    {
        abort_if(Gate::denies('e_bill_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eBillListing->load('project', 'unit', 'bank_acc', 'username', 'payment_method');

        return view('admin.eBillListings.show', compact('eBillListing'));
    }

    public function destroy(EBillListing $eBillListing)
    {
        abort_if(Gate::denies('e_bill_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eBillListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyEBillListingRequest $request)
    {
        EBillListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('e_bill_listing_create') && Gate::denies('e_bill_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EBillListing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function owner_approval_payement(UpdateEBillListingRequest $request, EBillListing $eBillListing)
    {
        $id = $request->id;
        $user_id = User::all()->where('name', $request->username)->first();
        $array_user = array((String)$user_id->id);

        if($request->status === "paid"){
            $status = EBillListing::find($id);
            $status->status = "paid";
            $status->save();
            $notification = Notification::create([
                'title_text' => "E-Bill Payment Successful",
                'description_text' => "Your E-Bill are approved. Payment Successful",
                'language_shortkey' => "en",
                'user_id' => $user_id->id,
                'expired_date' => $request->expired_date,
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
        } else if ($request->status === "reject") {
            $status = EBillListing::find($id);
            $status->status = "reject";
            $status->save();
            $notification = Notification::create([
                'title_text' => "E-Bill Payment are Reject",
                'description_text' => "Your E-Bill are Reject. Payment Unsuccessful. Please call the admin.",
                'language_shortkey' => "en",
                'user_id' => $user_id->id,
                'expired_date' => $request->expired_date,
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
            OneSignal::sendNotificationCustom($params);
        }



        return redirect()->route('admin.e-bill-listings.index');
    }
}
