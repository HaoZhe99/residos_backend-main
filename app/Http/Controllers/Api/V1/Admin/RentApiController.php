<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Resources\Admin\RentResource;
use App\Models\Rent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('rent_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rent = Rent::with(['tenant', 'amenities', 'unit_owner', 'unit_owner.unit']);

        if ($request->has('unit_owner_id')) {
            $rent->where('unit_owner_id', $request->unit_owner_id);
        }

        if ($request->has('status')) {
            $rent->where('status', $request->status);
        }

        return new RentResource($rent->get());
    }

    public function store(StoreRentRequest $request)
    {
        $rent = Rent::create($request->all());
        $rent->amenities()->sync($request->input('amenities', []));

        if ($request->file('image', false)) {
            $rent->addMedia(/*storage_path('tmp/uploads/' . basename(*/$request->file('image')/*))*/)->toMediaCollection('image');
        }

        foreach ($request->file('image', []) as $file) {
            $rent->addMedia(/*storage_path('tmp/uploads/' . basename(*/$file/*))*/)->toMediaCollection('image');
        }

        return (new RentResource($rent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Rent $rent)
    {
        abort_if(Gate::denies('rent_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RentResource($rent->load(['tenant', 'amenities', 'unit_owner']));
    }

    public function update(Request $request, Rent $rent)
    {
        $rent->update($request->all());
        $rent->amenities()->sync($request->input('amenities', []));

        if ($request->file('image', false)) {
            if (!$rent->image[0] || $request->file('image') !== $rent->image[0]->file_name) {
                if ($rent->image[0]) {
                    $rent->image[0]->delete();
                }

                $rent->addMedia(/*storage_path('tmp/uploads/' . */$request->file('image')/*)*/)->toMediaCollection('image');
            }
        }
        // elseif ($rent->image) {
        //     $rent->image->delete();
        // }
        $media = $rent->image->pluck('file_name')->toArray();
        foreach ($request->file('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $rent->addMedia(/*storage_path('tmp/uploads/' . basename(*/$file/*))*/)->toMediaCollection('image');
            }
        }

        return (new RentResource($rent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    public function update_status($id, Request $request)
    {
        $rent = Rent::find($id);
        $rent->update($request->all());

        return (new RentResource($rent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Rent $rent)
    {
        abort_if(Gate::denies('rent_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
