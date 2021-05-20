<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use App\Models\EBillListing;
use App\Models\Transaction;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reports.index');
    }

    public function detail(Request $request)
    {
        global $query;
        global $query2;
        global $min_date;
        global $max_date;
        global $keyword;
        global $total_price;
        global $unit_price;
        global $quantity;

        $date = request();
        $type = $date->type;
        $min_date = $date->min_date;
        $max_date = $date->max_date;
        $keyword = $date->keyword;

        switch ($keyword) {
            case 'Yesterday':
                $lastday = Carbon::now()->subdays(1);
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereDate('created_at', $lastday)->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereDate('created_at', $lastday)->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'Today':
                $today = Carbon::now();
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereDate('created_at', $today)->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereDate('created_at', $today)->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'last_week':
                $last_week = Carbon::today()->subWeek()->startOfWeek();
                $last_day = Carbon::today()->subWeek()->endOfWeek();
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereBetween('created_at', [$last_week, $last_day])->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereBetween('created_at', [$last_week, $last_day])->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'this_week':
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d');
                $weekEndDate = $now->endOfWeek()->format('Y-m-d');
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereBetween('created_at', [$weekStartDate, $weekEndDate])->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereBetween('created_at', [$weekStartDate, $weekEndDate])->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'last_month':
                $last_month = Carbon::now()->subMonth()->month;
                $this_year = Carbon::now()->year;
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereMonth('created_at', $last_month)->whereYear('created_at', $this_year)->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereMonth('created_at', $last_month)->whereYear('created_at', $this_year)->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'this_month':
                $this_month = Carbon::now()->month;
                $this_year = Carbon::now()->year;
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereMonth('created_at', $this_month)->whereYear('created_at', $this_year)->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereMonth('created_at', $this_month)->whereYear('created_at', $this_year)->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'last_year':
                $last_year = date('Y', strtotime('-1 year'));
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereYear('created_at', $last_year)->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereYear('created_at', $last_year)->orderBy('created_at', 'ASC')->get();
                }
                break;
            case 'this_year':
                $this_year = Carbon::now()->year;
                if ($request->type == 'eBilling') {
                    $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereYear('created_at', $this_year)->orderBy('created_at', 'ASC')->get();
                } elseif ($request->type == 'transaction') {
                    $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereYear('created_at', $this_year)->orderBy('created_at', 'ASC')->get();
                }
                break;
            default:
                if ($request->type == 'eBilling') {
                    if ($min_date == $max_date) {
                        $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereDate('created_at', date($max_date))->orderBy('created_at', 'ASC')->get();
                    }else {
                        $query = EBillListing::with(['project', 'unit', 'bank_acc', 'username', 'payment_method'])->whereBetween('created_at', [$min_date, $max_date])->orderBy('created_at', 'ASC')->get();
                    }
                    if ($request->ajax()) {
                        $table = Datatables::of($query);

                        $table->addColumn('placeholder', '&nbsp;');
                        $table->addColumn('actions', '&nbsp;');

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

                        $table->rawColumns(['project', 'unit', 'bank_acc', 'username', 'receipt']);

                        return $table->make(true);
                    }
                    return view('admin.reports.detail', compact('type'));
                } elseif ($request->type == 'transaction') {
                    if ($min_date == $max_date) {
                        $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereDate('created_at', date($max_date))->orderBy('created_at', 'ASC')->get();
                    }else {
                        $query = Transaction::with(['project_code', 'bank_acc', 'username'])->whereBetween('created_at', [$min_date, $max_date])->orderBy('created_at', 'ASC')->get();
                    }
                    if ($request->ajax()) {
                        $table = Datatables::of($query);

                        $table->editColumn('id', function ($row) {
                            return $row->id ? $row->id : "";
                        });
                        $table->editColumn('bill_code', function ($row) {
                            return $row->bill_code ? $row->bill_code : "";
                        });
                        $table->editColumn('credit', function ($row) {
                            return $row->credit ? $row->credit : "0";
                        });
                        $table->editColumn('debit', function ($row) {
                            return $row->debit ? $row->debit : "0";
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

                        $table->rawColumns(['project_code', 'bank_acc', 'username']);

                        return $table->make(true);
                    }
                    return view('admin.reports.detail', compact('type'));
                }
                break;
        }

        switch ($type) {
            case 'eBilling':
                if ($request->ajax()) {
                    $table = Datatables::of($query);

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
                    $table->editColumn('created_at', function ($row) {
                        return $row->created_at ? $row->created_at : '';
                    });

                    $table->rawColumns(['project', 'unit', 'bank_acc', 'username', 'receipt']);

                    return $table->make(true);
                }
                return view('admin.reports.detail', compact('type'));
                break;
            case 'transaction':
                if ($request->ajax()) {
                    $table = Datatables::of($query);

                    $table->editColumn('id', function ($row) {
                        return $row->id ? $row->id : "";
                    });
                    $table->editColumn('bill_code', function ($row) {
                        return $row->bill_code ? $row->bill_code : "";
                    });
                    $table->editColumn('credit', function ($row) {
                        return $row->credit ? $row->credit : "0";
                    });
                    $table->editColumn('debit', function ($row) {
                        return $row->debit ? $row->debit : "0";
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
                    $table->editColumn('created_at', function ($row) {
                        return $row->created_at ? $row->created_at : '';
                    });

                    $table->rawColumns(['project_code', 'bank_acc', 'username']);

                    return $table->make(true);
                }
                return view('admin.reports.detail', compact('type'));
                break;
        }
    }
}
