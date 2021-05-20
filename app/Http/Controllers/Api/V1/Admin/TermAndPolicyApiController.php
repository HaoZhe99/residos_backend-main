<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTermAndPolicyRequest;
use App\Http\Requests\UpdateTermAndPolicyRequest;
use App\Http\Resources\Admin\TermAndPolicyResource;
use App\Models\TermAndPolicy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TermAndPolicyApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('term_and_policy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $termAndPolicy = TermAndPolicy::with(['project_code']);

        if ($request->has('project_code_id')) {
            $termAndPolicy->where('project_code_id', $request->project_code_id);
        }

        return new TermAndPolicyResource($termAndPolicy->get());
    }

    public function store(StoreTermAndPolicyRequest $request)
    {
        $termAndPolicy = TermAndPolicy::create($request->all());

        return (new TermAndPolicyResource($termAndPolicy))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TermAndPolicy $termAndPolicy)
    {
        abort_if(Gate::denies('term_and_policy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TermAndPolicyResource($termAndPolicy);
    }

    public function update(UpdateTermAndPolicyRequest $request, TermAndPolicy $termAndPolicy)
    {
        $termAndPolicy->update($request->all());

        return (new TermAndPolicyResource($termAndPolicy))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TermAndPolicy $termAndPolicy)
    {
        abort_if(Gate::denies('term_and_policy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $termAndPolicy->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
