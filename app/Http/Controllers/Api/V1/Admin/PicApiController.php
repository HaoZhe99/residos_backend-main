<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePicRequest;
use App\Http\Requests\UpdatePicRequest;
use App\Http\Resources\Admin\PicResource;
use App\Models\Pic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PicApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PicResource(Pic::all());
    }

    public function store(StorePicRequest $request)
    {
        $pic = Pic::create($request->all());

        return (new PicResource($pic))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pic $pic)
    {
        abort_if(Gate::denies('pic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PicResource($pic);
    }

    public function update(UpdatePicRequest $request, Pic $pic)
    {
        $pic->update($request->all());

        return (new PicResource($pic))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Pic $pic)
    {
        abort_if(Gate::denies('pic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pic->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
