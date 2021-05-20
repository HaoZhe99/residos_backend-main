<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFeedbackListingRequest;
use App\Http\Requests\StoreFeedbackListingRequest;
use App\Http\Requests\UpdateFeedbackListingRequest;
use App\Models\FeedbackCategory;
use App\Models\FeedbackListing;
use App\Models\ProjectListing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FeedbackListingController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('feedback_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FeedbackListing::with(['category', 'project_code', 'created_by'])
                ->select(sprintf('%s.*', (new FeedbackListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'feedback_listing_show';
                $editGate      = 'feedback_listing_edit';
                $deleteGate    = 'feedback_listing_delete';
                $crudRoutePart = 'feedback-listings';

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
            $table->addColumn('category_category', function ($row) {
                return $row->category ? $row->category->category : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('send_to', function ($row) {
                return $row->send_to ? $row->send_to : "";
            });
            $table->editColumn('reply', function ($row) {
                return $row->reply ? $row->reply : "";
            });
            $table->editColumn('reply_photo', function ($row) {
                if (!$row->reply_photo) {
                    return '';
                }

                $links = [];

                foreach ($row->reply_photo as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->addColumn('project_code_project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : '';
            });

            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->editColumn('file', function ($row) {
                if ($photo = $row->file) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'reply_photo', 'project_code', 'created_by', 'file']);

            return $table->make(true);
        }

        return view('admin.feedbackListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('feedback_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = FeedbackCategory::all()->pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.feedbackListings.create', compact('categories', 'project_codes', 'created_bies'));
    }

    public function store(StoreFeedbackListingRequest $request)
    {
        $feedbackListing = FeedbackListing::create($request->all());

        foreach ($request->input('reply_photo', []) as $file) {
            $feedbackListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('reply_photo');
        }

        if ($request->input('file', false)) {
            $feedbackListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $feedbackListing->id]);
        }

        return redirect()->route('admin.feedback-listings.index');
    }

    public function edit(FeedbackListing $feedbackListing)
    {
        abort_if(Gate::denies('feedback_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = FeedbackCategory::all()->pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_codes = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $feedbackListing->load('category', 'project_code', 'created_by');

        return view('admin.feedbackListings.edit', compact('categories', 'project_codes', 'created_bies', 'feedbackListing'));
    }

    public function update(UpdateFeedbackListingRequest $request, FeedbackListing $feedbackListing)
    {
        $feedbackListing->update($request->all());

        if (count($feedbackListing->reply_photo) > 0) {
            foreach ($feedbackListing->reply_photo as $media) {
                if (!in_array($media->file_name, $request->input('reply_photo', []))) {
                    $media->delete();
                }
            }
        }

        $media = $feedbackListing->reply_photo->pluck('file_name')->toArray();

        foreach ($request->input('reply_photo', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $feedbackListing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('reply_photo');
            }
        }

        if ($request->input('file', false)) {
            if (!$feedbackListing->file || $request->input('file') !== $feedbackListing->file->file_name) {
                if ($feedbackListing->file) {
                    $feedbackListing->file->delete();
                }

                $feedbackListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($feedbackListing->file) {
            $feedbackListing->file->delete();
        }

        return redirect()->route('admin.feedback-listings.index');
    }

    public function show(FeedbackListing $feedbackListing)
    {
        abort_if(Gate::denies('feedback_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackListing->load('category', 'project_code', 'created_by');

        return view('admin.feedbackListings.show', compact('feedbackListing'));
    }

    public function destroy(FeedbackListing $feedbackListing)
    {
        abort_if(Gate::denies('feedback_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeedbackListingRequest $request)
    {
        FeedbackListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('feedback_listing_create') && Gate::denies('feedback_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FeedbackListing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
