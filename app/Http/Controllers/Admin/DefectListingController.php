<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDefectListingRequest;
use App\Http\Requests\StoreDefectListingRequest;
use App\Http\Requests\UpdateDefectListingRequest;
use App\Models\DefectCategory;
use App\Models\DefectListing;
use App\Models\ProjectListing;
use App\Models\StatusControl;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DefectListingController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('defect_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DefectListing::with(['category', 'status_control', 'project_code'])
                ->select(sprintf('%s.*', (new DefectListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'defect_listing_show';
                $editGate      = 'defect_listing_edit';
                $deleteGate    = 'defect_listing_delete';
                $crudRoutePart = 'defect-listings';

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
            $table->editColumn('case_code', function ($row) {
                return $row->case_code ? $row->case_code : "";
            });
            $table->addColumn('category_defect_cateogry', function ($row) {
                return $row->category ? $row->category->defect_cateogry : '';
            });

            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('image', function ($row) {
                if (!$row->image) {
                    return '';
                }

                $links = [];

                foreach ($row->image as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : "";
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : "";
            });
            $table->editColumn('incharge_person', function ($row) {
                return $row->incharge_person ? $row->incharge_person : "";
            });
            $table->editColumn('contractor', function ($row) {
                return $row->contractor ? $row->contractor : "";
            });
            $table->addColumn('status_control_status', function ($row) {
                return $row->status_control ? $row->status_control->status : '';
            });

            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'image', 'status_control', 'project_code']);

            return $table->make(true);
        }

        return view('admin.defectListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('defect_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = DefectCategory::all()->pluck('defect_cateogry', 'id')->prepend(trans('global.pleaseSelect'), '');

        $status_controls = StatusControl::all()->pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.defectListings.create', compact('categories', 'status_controls', 'project_codes'));
    }

    public function store(StoreDefectListingRequest $request)
    {
        $defectListing = DefectListing::create($request->validated());

        foreach ($request->input('image', []) as $file) {
            $defectListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $defectListing->id]);
        }

        return redirect()->route('admin.defect-listings.index');
    }

    public function edit(DefectListing $defectListing)
    {
        abort_if(Gate::denies('defect_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = DefectCategory::all()->pluck('defect_cateogry', 'id')->prepend(trans('global.pleaseSelect'), '');

        $status_controls = StatusControl::all()->pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $defectListing->load('category', 'status_control', 'project_code');

        return view('admin.defectListings.edit', compact('categories', 'status_controls', 'project_codes', 'defectListing'));
    }

    public function update(UpdateDefectListingRequest $request, DefectListing $defectListing)
    {
        $defectListing->update($request->validated());

        if (count($defectListing->image) > 0) {
            foreach ($defectListing->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }

        $media = $defectListing->image->pluck('file_name')->toArray();

        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $defectListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.defect-listings.index');
    }

    public function show(DefectListing $defectListing)
    {
        abort_if(Gate::denies('defect_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $defectListing->load('category', 'status_control', 'project_code');

        return view('admin.defectListings.show', compact('defectListing'));
    }

    public function destroy(DefectListing $defectListing)
    {
        abort_if(Gate::denies('defect_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $defectListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyDefectListingRequest $request)
    {
        DefectListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('defect_listing_create') && Gate::denies('defect_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DefectListing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
