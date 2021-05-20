<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyContentListingRequest;
use App\Http\Requests\StoreContentListingRequest;
use App\Http\Requests\UpdateContentListingRequest;
use App\Models\ContentListing;
use App\Models\ContentType;
use App\Models\ProjectListing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use OneSignal;

class ContentListingController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('content_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ContentListing::with(['type', 'project_code', 'users'])
                ->select(sprintf('%s.*', (new ContentListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'content_listing_show';
                $editGate      = 'content_listing_edit';
                $deleteGate    = 'content_listing_delete';
                $crudRoutePart = 'content-listings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            // $query->whereDate('expired_date' , '>=' , $request->min_date);
            // $query->whereDate('expired_date' , '<=' , $request->max_date);

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('type_type', function ($row) {
                return $row->type ? $row->type->type : '';
            });

            $table->editColumn('type.is_active', function ($row) {
                return $row->type ? (is_string($row->type) ? $row->type : $row->type->is_active) : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('pinned', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->pinned ? 'checked' : null) . '>';
            });
            $table->editColumn('language', function ($row) {
                return $row->language ? $row->language : "";
            });
            $table->editColumn('created_by', function ($row) {
                return $row->created_by ? $row->created_by : "";
            });
            $table->editColumn('send_to', function ($row) {
                return $row->send_to ? $row->send_to : "";
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
            $table->editColumn('url', function ($row) {
                return $row->url ? $row->url : "";
            });
            $table->editColumn('user_group', function ($row) {
                return $row->user_group ? $row->user_group : "";
            });
            $table->editColumn('expired_date', function ($row) {
                return $row->expired_date ? $row->expired_date : "";
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });
            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });
            $table->editColumn('user', function ($row) {
                $labels = [];

                foreach ($row->users as $user) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $user->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'type', 'pinned', 'image', 'is_active', 'project_code']);

            return $table->make(true);
        }

        return view('admin.contentListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('content_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = ContentType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id');

        return view('admin.contentListings.create', compact('types', 'project_codes', 'users'));
    }

    public function store(Request $request)
    {
        $contentListing = ContentListing::create($request->all());

        if ($request->type_id == 2) {
            $contentListing->users()->sync($request->input('users', []));
            // return dd('hi');
            $params = [];
            $params['include_external_user_ids'] = $request->input('users', []);
            $params['contents'] = [
                // "title" => $request->title,
                "zh-Hans" => $request->title . PHP_EOL . $request->description,
                "en"      => $request->title . PHP_EOL . $request->description,
                "ms"      => $request->title . PHP_EOL . $request->description
            ];

            OneSignal::sendNotificationCustom($params);
        }

        foreach ($request->input('image', []) as $file) {
            $contentListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $contentListing->id]);
        }

        return redirect()->route('admin.content-listings.index');
    }

    public function edit(ContentListing $contentListing)
    {
        abort_if(Gate::denies('content_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = ContentType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contentListing->load('type', 'project_code');

        return view('admin.contentListings.edit', compact('types', 'project_codes', 'contentListing'));
    }

    public function update(UpdateContentListingRequest $request, ContentListing $contentListing)
    {
        $contentListing->update($request->all());

        if (count($contentListing->image) > 0) {
            foreach ($contentListing->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }

        $media = $contentListing->image->pluck('file_name')->toArray();

        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $contentListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.content-listings.index');
    }

    public function show(ContentListing $contentListing)
    {
        abort_if(Gate::denies('content_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentListing->load('type', 'project_code');

        return view('admin.contentListings.show', compact('contentListing'));
    }

    public function destroy(ContentListing $contentListing)
    {
        abort_if(Gate::denies('content_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyContentListingRequest $request)
    {
        ContentListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('content_listing_create') && Gate::denies('content_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ContentListing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function read(Request $request)
    {
        $alerts = \Auth::user()->userUserAlerts()->where('read', false)->get();

        foreach ($alerts as $alert) {
            $pivot       = $alert->pivot;
            $pivot->read = true;
            $pivot->save();
        }
    }
}
