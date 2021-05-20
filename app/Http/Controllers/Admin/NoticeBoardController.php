<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyNoticeBoardRequest;
use App\Http\Requests\StoreNoticeBoardRequest;
use App\Http\Requests\UpdateNoticeBoardRequest;
use App\Models\NoticeBoard;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Str;
use App\Models\User;
use OneSignal;

class NoticeBoardController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('notice_board_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = NoticeBoard::query()->select(sprintf('%s.*', (new NoticeBoard)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'notice_board_show';
                $editGate      = 'notice_board_edit';
                $deleteGate    = 'notice_board_delete';
                $crudRoutePart = 'notice-boards';

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
            $table->editColumn('title_zh', function ($row) {
                return $row->title_zh ? $row->title_zh : "";
            });
            $table->editColumn('title_en', function ($row) {
                return $row->title_en ? $row->title_en : "";
            });
            $table->editColumn('title_ms', function ($row) {
                return $row->title_ms ? $row->title_ms : "";
            });

            $table->editColumn('post_to', function ($row) {
                return $row->post_to ? $row->post_to : "";
            });
            $table->editColumn('pinned', function ($row) {
                return $row->pinned ? $row->pinned : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });
            $table->editColumn('post_by', function ($row) {
                return $row->post_by ? $row->post_by : "";
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

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.noticeBoards.index');
    }

    public function create()
    {
        abort_if(Gate::denies('notice_board_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.noticeBoards.create');
    }

    public function store(StoreNoticeBoardRequest $request)
    {
        $noticeBoard = NoticeBoard::create($request->all());

        if ($request->input('image', false)) {
            $noticeBoard->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $noticeBoard->id]);
        }

        // $params = [];
        // $params['include_external_user_ids'] = array();

        // $users = User::select('id')->get();
        // foreach ($users as $user) {
        //     array_push($params['include_external_user_ids'], $user->id);
        // }

        // $params['headings'] = [
        //     "zh-Hans" => $request->title_zh,
        //     "en"      => $request->title_en,
        //     "ms"      => $request->title_ms
        // ];
        // $params['contents'] = [
        //     "zh-Hans" => Str::replaceFirst('<p>', '', (Str::replaceFirst('</p>', '', $request->content_zh))),
        //     "en"      => Str::replaceFirst('<p>', '', (Str::replaceFirst('</p>', '', $request->content_en))),
        //     "ms"      => Str::replaceFirst('<p>', '', (Str::replaceFirst('</p>', '', $request->content_ms)))
        // ];
        // OneSignal::sendNotificationCustom($params);

        return redirect()->route('admin.notice-boards.index');
    }

    public function edit(NoticeBoard $noticeBoard)
    {
        abort_if(Gate::denies('notice_board_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.noticeBoards.edit', compact('noticeBoard'));
    }

    public function update(UpdateNoticeBoardRequest $request, NoticeBoard $noticeBoard)
    {
        $noticeBoard->update($request->all());

        if ($request->input('image', false)) {
            if (!$noticeBoard->image || $request->input('image') !== $noticeBoard->image->file_name) {
                if ($noticeBoard->image) {
                    $noticeBoard->image->delete();
                }

                $noticeBoard->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($noticeBoard->image) {
            $noticeBoard->image->delete();
        }

        return redirect()->route('admin.notice-boards.index');
    }

    public function show(NoticeBoard $noticeBoard)
    {
        abort_if(Gate::denies('notice_board_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.noticeBoards.show', compact('noticeBoard'));
    }

    public function destroy(NoticeBoard $noticeBoard)
    {
        abort_if(Gate::denies('notice_board_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $noticeBoard->delete();

        return back();
    }

    public function massDestroy(MassDestroyNoticeBoardRequest $request)
    {
        NoticeBoard::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('notice_board_create') && Gate::denies('notice_board_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new NoticeBoard();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
