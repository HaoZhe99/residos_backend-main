<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFacilityListingRequest;
use App\Http\Requests\StoreFacilityListingRequest;
use App\Http\Requests\UpdateFacilityListingRequest;
use App\Models\FacilityCategory;
use App\Models\FacilityListing;
use App\Models\ProjectListing;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FacilityListingController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('facility_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FacilityListing::with(['category', 'project_code'])
                ->select(sprintf('%s.*', (new FacilityListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'facility_listing_show';
                $editGate      = 'facility_listing_edit';
                $deleteGate    = 'facility_listing_delete';
                $crudRoutePart = 'facility-listings';

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
            $table->editColumn('facility_code', function ($row) {
                return $row->facility_code ? $row->facility_code : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? FacilityListing::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('open', function ($row) {
                return $row->open ? $row->open : "";
            });
            $table->editColumn('closed', function ($row) {
                return $row->closed ? $row->closed : "";
            });
            $table->addColumn('category_category', function ($row) {
                return $row->category ? $row->category->category : '';
            });

            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image', 'category', 'project_code']);

            return $table->make(true);
        }

        return view('admin.facilityListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('facility_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = FacilityCategory::all()->pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.facilityListings.create', compact('categories', 'project_codes'));
    }

    public function store(StoreFacilityListingRequest $request)
    {
        $facilityListing = FacilityListing::create($request->all());

        if ($request->input('image', false)) {
            $facilityListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $facilityListing->id]);
        }

        return redirect()->route('admin.facility-listings.index');
    }

    public function edit(FacilityListing $facilityListing)
    {
        abort_if(Gate::denies('facility_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = FacilityCategory::all()->pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facilityListing->load('category', 'project_code');

        return view('admin.facilityListings.edit', compact('categories', 'project_codes', 'facilityListing'));
    }

    public function update(UpdateFacilityListingRequest $request, FacilityListing $facilityListing)
    {
        $facilityListing->update($request->all());

        if ($request->input('image', false)) {
            if (!$facilityListing->image || $request->input('image') !== $facilityListing->image->file_name) {
                if ($facilityListing->image) {
                    $facilityListing->image->delete();
                }

                $facilityListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($facilityListing->image) {
            $facilityListing->image->delete();
        }

        return redirect()->route('admin.facility-listings.index');
    }

    public function show(FacilityListing $facilityListing)
    {
        abort_if(Gate::denies('facility_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityListing->load('category', 'project_code');

        return view('admin.facilityListings.show', compact('facilityListing'));
    }

    public function destroy(FacilityListing $facilityListing)
    {
        abort_if(Gate::denies('facility_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacilityListingRequest $request)
    {
        FacilityListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('facility_listing_create') && Gate::denies('facility_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FacilityListing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
