<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\BankAccListing;
use App\Models\ProjectListing;
use App\Models\Transaction;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Transaction::with(['project_code', 'bank_acc', 'username'])
                ->select(sprintf('%s.*', (new Transaction)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'transaction_show';
                $editGate      = 'transaction_edit';
                $deleteGate    = 'transaction_delete';
                $crudRoutePart = 'transactions';

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
            $table->editColumn('bill_code', function ($row) {
                return $row->bill_code ? $row->bill_code : "";
            });
            $table->editColumn('credit', function ($row) {
                return $row->credit ? $row->credit : "";
            });
            $table->editColumn('debit', function ($row) {
                return $row->debit ? $row->debit : "";
            });
            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->addColumn('bank_acc_bank_account', function ($row) {
                return $row->bank_acc ? $row->bank_acc->bank_account : '';
            });

            $table->addColumn('username_name', function ($row) {
                return $row->username ? $row->username->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project_code', 'bank_acc', 'username']);

            return $table->make(true);
        }

        return view('admin.transactions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bank_accs = BankAccListing::all()->pluck('bank_account', 'id')->prepend(trans('global.pleaseSelect'), '');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.transactions.create', compact('project_codes', 'bank_accs', 'usernames'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bank_accs = BankAccListing::all()->pluck('bank_account', 'id')->prepend(trans('global.pleaseSelect'), '');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transaction->load('project_code', 'bank_acc', 'username');

        return view('admin.transactions.edit', compact('project_codes', 'bank_accs', 'usernames', 'transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->load('project_code', 'bank_acc', 'username');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyTransactionRequest $request)
    {
        Transaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
