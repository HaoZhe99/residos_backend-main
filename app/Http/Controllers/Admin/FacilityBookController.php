<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFacilityBookRequest;
use App\Http\Requests\StoreFacilityBookRequest;
use App\Http\Requests\UpdateFacilityBookRequest;
use App\Models\FacilityBook;
use App\Models\FacilityListing;
use App\Models\ProjectListing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FacilityBookController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('facility_book_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FacilityBook::with(['username', 'project_code', 'facility_code'])
                ->select(sprintf('%s.*', (new FacilityBook)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'facility_book_show';
                $editGate      = 'facility_book_edit';
                $deleteGate    = 'facility_book_delete';
                $crudRoutePart = 'facility-books';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $query->whereDate('date' , '>=' , $request->min_date);
            $query->whereDate('date' , '<=' , $request->max_date);

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });
            $table->addColumn('username_name', function ($row) {
                return $row->username ? $row->username->name : '';
            });

            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->addColumn('facility_code_facility_code', function ($row) {
                return $row->facility_code ? $row->facility_code->facility_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'username', 'project_code', 'facility_code']);

            return $table->make(true);
        }

        return view('admin.facilityBooks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('facility_book_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facility_codes = FacilityListing::all()->pluck('facility_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.facilityBooks.create', compact('usernames', 'project_codes', 'facility_codes'));
    }

    public function store(StoreFacilityBookRequest $request)
    {
        $facilityBook = FacilityBook::create($request->all());

        return redirect()->route('admin.facility-books.index');
    }

    public function edit(FacilityBook $facilityBook)
    {
        abort_if(Gate::denies('facility_book_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facility_codes = FacilityListing::all()->pluck('facility_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facilityBook->load('username', 'project_code', 'facility_code');

        return view('admin.facilityBooks.edit', compact('usernames', 'project_codes', 'facility_codes', 'facilityBook'));
    }

    public function update(UpdateFacilityBookRequest $request, FacilityBook $facilityBook)
    {
        $facilityBook->update($request->all());

        return redirect()->route('admin.facility-books.index');
    }

    public function show(FacilityBook $facilityBook)
    {
        abort_if(Gate::denies('facility_book_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityBook->load('username', 'project_code', 'facility_code');

        return view('admin.facilityBooks.show', compact('facilityBook'));
    }

    public function destroy(FacilityBook $facilityBook)
    {
        abort_if(Gate::denies('facility_book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityBook->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacilityBookRequest $request)
    {
        FacilityBook::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
