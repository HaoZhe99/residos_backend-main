<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventListingRequest;
use App\Http\Requests\StoreEventListingRequest;
use App\Http\Requests\UpdateEventListingRequest;
use App\Models\EventCategory;
use App\Models\EventListing;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EventListingController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('event_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EventListing::with(['catogery', 'created_by', 'user_group'])
                ->select(sprintf('%s.*', (new EventListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'event_listing_show';
                $editGate      = 'event_listing_edit';
                $deleteGate    = 'event_listing_delete';
                $crudRoutePart = 'event-listings';

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
            $table->editColumn('event_code', function ($row) {
                return $row->event_code ? $row->event_code : "";
            });
            $table->addColumn('catogery_cateogey', function ($row) {
                return $row->catogery ? $row->catogery->cateogey : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('language', function ($row) {
                return $row->language ? $row->language : "";
            });
            $table->editColumn('payment', function ($row) {
                return $row->payment ? $row->payment : "";
            });
            $table->editColumn('participants', function ($row) {
                return $row->participants ? $row->participants : "";
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
            $table->editColumn('organized_by', function ($row) {
                return $row->organized_by ? $row->organized_by : "";
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? EventListing::STATUS_SELECT[$row->status] : '';
            });
            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->addColumn('user_group_title', function ($row) {
                return $row->user_group ? $row->user_group->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'catogery', 'image', 'created_by', 'user_group']);

            return $table->make(true);
        }

        return view('admin.eventListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('event_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catogeries = EventCategory::all()->pluck('cateogey', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_groups = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eventListings.create', compact('catogeries', 'created_bies', 'user_groups'));
    }

    public function store(StoreEventListingRequest $request)
    {
        $eventListing = EventListing::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $eventListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eventListing->id]);
        }

        return redirect()->route('admin.event-listings.index');
    }

    public function edit(EventListing $eventListing)
    {
        abort_if(Gate::denies('event_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catogeries = EventCategory::all()->pluck('cateogey', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_groups = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eventListing->load('catogery', 'created_by', 'user_group');

        return view('admin.eventListings.edit', compact('catogeries', 'created_bies', 'user_groups', 'eventListing'));
    }

    public function update(UpdateEventListingRequest $request, EventListing $eventListing)
    {
        $eventListing->update($request->all());

        if (count($eventListing->image) > 0) {
            foreach ($eventListing->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }

        $media = $eventListing->image->pluck('file_name')->toArray();

        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $eventListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.event-listings.index');
    }

    public function show(EventListing $eventListing)
    {
        abort_if(Gate::denies('event_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventListing->load('catogery', 'created_by', 'user_group');

        return view('admin.eventListings.show', compact('eventListing'));
    }

    public function destroy(EventListing $eventListing)
    {
        abort_if(Gate::denies('event_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventListingRequest $request)
    {
        EventListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('event_listing_create') && Gate::denies('event_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EventListing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
