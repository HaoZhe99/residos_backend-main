<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeveloperListingRequest;
use App\Http\Requests\StoreDeveloperListingRequest;
use App\Http\Requests\UpdateDeveloperListingRequest;
use App\Models\DeveloperListing;
use App\Models\Pic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DeveloperListingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('developer_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DeveloperListing::with(['pic'])
                ->select(sprintf('%s.*', (new DeveloperListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'developer_listing_show';
                $editGate      = 'developer_listing_edit';
                $deleteGate    = 'developer_listing_delete';
                $crudRoutePart = 'developer-listings';

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
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ? $row->company_name : "";
            });
            $table->editColumn('contact', function ($row) {
                return $row->contact ? $row->contact : "";
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('website', function ($row) {
                return $row->website ? $row->website : "";
            });
            $table->editColumn('fb', function ($row) {
                return $row->fb ? $row->fb : "";
            });
            $table->editColumn('linked_in', function ($row) {
                return $row->linked_in ? $row->linked_in : "";
            });
            $table->addColumn('pic_name', function ($row) {
                return $row->pic ? $row->pic->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'pic']);

            return $table->make(true);
        }

        return view('admin.developerListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('developer_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pics = Pic::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.developerListings.create', compact('pics'));
    }

    public function store(StoreDeveloperListingRequest $request)
    {
        $developerListing = DeveloperListing::create($request->all());

        return redirect()->route('admin.developer-listings.index');
    }

    public function edit(DeveloperListing $developerListing)
    {
        abort_if(Gate::denies('developer_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pics = Pic::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $developerListing->load('pic');

        return view('admin.developerListings.edit', compact('pics', 'developerListing'));
    }

    public function update(UpdateDeveloperListingRequest $request, DeveloperListing $developerListing)
    {
        $developerListing->update($request->all());

        return redirect()->route('admin.developer-listings.index');
    }

    public function show(DeveloperListing $developerListing)
    {
        abort_if(Gate::denies('developer_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $developerListing->load('pic');

        return view('admin.developerListings.show', compact('developerListing'));
    }

    public function destroy(DeveloperListing $developerListing)
    {
        abort_if(Gate::denies('developer_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $developerListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeveloperListingRequest $request)
    {
        DeveloperListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
