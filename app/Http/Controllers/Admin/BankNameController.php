<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBankNameRequest;
use App\Http\Requests\StoreBankNameRequest;
use App\Http\Requests\UpdateBankNameRequest;
use App\Models\BankName;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BankNameController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bank_name_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BankName::query()
                ->select(sprintf('%s.*', (new BankName)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bank_name_show';
                $editGate      = 'bank_name_edit';
                $deleteGate    = 'bank_name_delete';
                $crudRoutePart = 'bank-names';

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
            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : "";
            });
            $table->editColumn('bank_name', function ($row) {
                return $row->bank_name ? $row->bank_name : "";
            });
            $table->editColumn('swift_code', function ($row) {
                return $row->swift_code ? $row->swift_code : "";
            });
            $table->editColumn('bank_code', function ($row) {
                return $row->bank_code ? $row->bank_code : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.bankNames.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bank_name_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bankNames.create');
    }

    public function store(StoreBankNameRequest $request)
    {
        $bankName = BankName::create($request->all());

        return redirect()->route('admin.bank-names.index');
    }

    public function edit(BankName $bankName)
    {
        abort_if(Gate::denies('bank_name_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bankNames.edit', compact('bankName'));
    }

    public function update(UpdateBankNameRequest $request, BankName $bankName)
    {
        $bankName->update($request->all());

        return redirect()->route('admin.bank-names.index');
    }

    public function show(BankName $bankName)
    {
        abort_if(Gate::denies('bank_name_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bankNames.show', compact('bankName'));
    }

    public function destroy(BankName $bankName)
    {
        abort_if(Gate::denies('bank_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankName->delete();

        return back();
    }

    public function massDestroy(MassDestroyBankNameRequest $request)
    {
        BankName::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
