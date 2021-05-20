<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBankAccListingRequest;
use App\Http\Requests\StoreBankAccListingRequest;
use App\Http\Requests\UpdateBankAccListingRequest;
use App\Models\BankAccListing;
use App\Models\BankName;
use App\Models\ProjectListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BankAccListingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bank_acc_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BankAccListing::with(['bank_name', 'project_code'])
                ->select(sprintf('%s.*', (new BankAccListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bank_acc_listing_show';
                $editGate      = 'bank_acc_listing_edit';
                $deleteGate    = 'bank_acc_listing_delete';
                $crudRoutePart = 'bank-acc-listings';

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
            $table->editColumn('bank_account', function ($row) {
                return $row->bank_account ? $row->bank_account : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });
            $table->editColumn('balance', function ($row) {
                return $row->balance ? $row->balance : "";
            });
            $table->addColumn('bank_name_bank_name', function ($row) {
                return $row->bank_name ? $row->bank_name->bank_name : '';
            });

            $table->addColumn('project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_active', 'bank_name', 'project_code']);

            return $table->make(true);
        }

        return view('admin.bankAccListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bank_acc_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bank_names = BankName::all()->pluck('bank_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id');

        return view('admin.bankAccListings.create', compact('bank_names', 'project_codes'));
    }

    public function store(StoreBankAccListingRequest $request)
    {
        $bankAccListing = BankAccListing::create($request->all());

        return redirect()->route('admin.bank-acc-listings.index');
    }

    public function edit(BankAccListing $bankAccListing)
    {
        abort_if(Gate::denies('bank_acc_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bank_names = BankName::all()->pluck('bank_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id');

        $bankAccListing->load('bank_name', 'project_codes');

        return view('admin.bankAccListings.edit', compact('bank_names', 'project_codes', 'bankAccListing'));
    }

    public function update(UpdateBankAccListingRequest $request, BankAccListing $bankAccListing)
    {
        $bankAccListing->update($request->all());

        return redirect()->route('admin.bank-acc-listings.index');
    }

    public function show(BankAccListing $bankAccListing)
    {
        abort_if(Gate::denies('bank_acc_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankAccListing->load('bank_name', 'project_codes');

        return view('admin.bankAccListings.show', compact('bankAccListing'));
    }

    public function destroy(BankAccListing $bankAccListing)
    {
        abort_if(Gate::denies('bank_acc_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankAccListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyBankAccListingRequest $request)
    {
        BankAccListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
