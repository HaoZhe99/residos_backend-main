<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPaymentMethodRequest;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentSettingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('payment_method_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PaymentMethod::query()->select(sprintf('%s.*', (new PaymentMethod)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'payment_method_show';
                $editGate      = 'payment_method_edit';
                $deleteGate    = 'payment_method_delete';
                $crudRoutePart = 'payment-settings';

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
            $table->editColumn('method', function ($row) {
                return $row->method ? $row->method : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('in_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->in_enable ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'in_enable']);

            return $table->make(true);
        }

        return view('admin.payment-settings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('payment_method_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.payment-settings.create');
    }

    public function store(StorePaymentMethodRequest $request)
    {
        $paymentMethod = PaymentMethod::create($request->all());

        return redirect()->route('admin.payment-settings.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('payment_method_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentMethod = PaymentMethod::find($id)->first();

        return view('admin.payment-settings.edit', compact('paymentMethod'));
    }

    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        PaymentMethod::find($id)->first()->update($request->all());

        return redirect()->route('admin.payment-settings.index');
    }

    public function show($id)
    {
        abort_if(Gate::denies('payment_method_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentMethod = PaymentMethod::find($id)->first();

        return view('admin.payment-settings.show', compact('paymentMethod'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('payment_method_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        PaymentMethod::find($id)->first()->delete();

        return back();
    }

    public function massDestroy(MassDestroyPaymentMethodRequest $request)
    {
        PaymentMethod::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

