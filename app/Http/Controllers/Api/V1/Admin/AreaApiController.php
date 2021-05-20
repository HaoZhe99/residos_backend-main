<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Http\Resources\Admin\AreaResource;
use App\Models\Area;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AreaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AreaResource(Area::all());
    }

    public function store(StoreAreaRequest $request)
    {
        $area = Area::create($request->all());

        return (new AreaResource($area))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Area $area)
    {
        abort_if(Gate::denies('area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AreaResource($area);
    }

    public function update(UpdateAreaRequest $request, Area $area)
    {
        $area->update($request->all());

        return (new AreaResource($area))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Area $area)
    {
        abort_if(Gate::denies('area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $area->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function area_filter()
    {
        $area = Area::select('area')->get()->unique('area');

        return new AreaResource($area);
    }

    public function postcode_filter(Request $request)
    {
        $area = Area::all()->whereIn('area', $request->area);

        return new AreaResource($area);
    }
}
