<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitorControlRequest;
use App\Http\Requests\UpdateVisitorControlRequest;
use App\Http\Resources\Admin\VisitorControlResource;
use App\Models\VisitorControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorControlApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('visitor_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new AddVisitorResource(AddVisitor::with(['username', 'add_by'])->get());

        $addVisitors = VisitorControl::with(['username', 'add_by']);
        if($request->has('add_by_id')){
            $addVisitors->where('add_by_id', $request->add_by_id);
        }

        if($request->has('favourite')){
            $addVisitors->where('favourite', $request->favourite);
        }

        return new VisitorControlResource($addVisitors->get());
    }

    public function store(StoreVisitorControlRequest $request)
    {
        $check = VisitorControl::where('username_id', $request->username_id)->where('add_by_id', $request->add_by_id)->first();
        
        if($check == null){
            $addVisitor = VisitorControl::create($request->all());
            
            return (new VisitorControlResource($addVisitor))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        return (new VisitorControlResource($check));
    }

    public function show(VisitorControl $addVisitor)
    {
        abort_if(Gate::denies('visitor_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VisitorControlResource($addVisitor->load(['username', 'add_by']));
    }

    public function update(UpdateVisitorControlRequest $request, $id)
    {
        VisitorControl::find($id)->update($request->all());
        $addVisitor = VisitorControl::find($id);

        return (new VisitorControlResource($addVisitor))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VisitorControl $addVisitor)
    {
        abort_if(Gate::denies('visitor_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addVisitor->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
