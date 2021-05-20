<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentTypeRequest;
use App\Http\Requests\UpdateContentTypeRequest;
use App\Http\Resources\Admin\ContentTypeResource;
use App\Models\ContentType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('content_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentTypeResource(ContentType::all());
    }

    public function store(StoreContentTypeRequest $request)
    {
        $contentType = ContentType::create($request->all());

        return (new ContentTypeResource($contentType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ContentType $contentType)
    {
        abort_if(Gate::denies('content_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentTypeResource($contentType);
    }

    public function update(UpdateContentTypeRequest $request, ContentType $contentType)
    {
        $contentType->update($request->all());

        return (new ContentTypeResource($contentType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ContentType $contentType)
    {
        abort_if(Gate::denies('content_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
