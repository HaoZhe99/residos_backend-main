<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreNoticeBoardRequest;
use App\Http\Requests\UpdateNoticeBoardRequest;
use App\Http\Resources\Admin\NoticeBoardResource;
use App\Models\NoticeBoard;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoticeBoardApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('notice_board_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NoticeBoardResource(NoticeBoard::all());
    }

    public function store(StoreNoticeBoardRequest $request)
    {
        $noticeBoard = NoticeBoard::create($request->all());

        if ($request->file('image', false)) {
            $noticeBoard->addMedia(/*storage_path('tmp/uploads/' . */$request->file('image')/*)*/)->toMediaCollection('image');
        }

        return (new NoticeBoardResource($noticeBoard))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(NoticeBoard $noticeBoard)
    {
        abort_if(Gate::denies('notice_board_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NoticeBoardResource($noticeBoard);
    }

    public function update(UpdateNoticeBoardRequest $request, NoticeBoard $noticeBoard)
    {
        $noticeBoard->update($request->all());

        if ($request->file('image', false)) {
            if (!$noticeBoard->image || $request->file('image') !== $noticeBoard->image->file_name) {
                if ($noticeBoard->image) {
                    $noticeBoard->image->delete();
                }

                $noticeBoard->addMedia(/*storage_path('tmp/uploads/' .*/ $request->file('image')/*)*/)->toMediaCollection('image');
            }
        } 
        // elseif ($noticeBoard->image) {
        //     $noticeBoard->image->delete();
        // }

        return (new NoticeBoardResource($noticeBoard))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(NoticeBoard $noticeBoard)
    {
        abort_if(Gate::denies('notice_board_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $noticeBoard->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
