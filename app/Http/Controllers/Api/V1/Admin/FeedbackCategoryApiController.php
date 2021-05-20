<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackCategoryRequest;
use App\Http\Requests\UpdateFeedbackCategoryRequest;
use App\Http\Resources\Admin\FeedbackCategoryResource;
use App\Models\FeedbackCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedbackCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('feedback_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeedbackCategoryResource(FeedbackCategory::all());
    }

    public function store(StoreFeedbackCategoryRequest $request)
    {
        $feedbackCategory = FeedbackCategory::create($request->all());

        return (new FeedbackCategoryResource($feedbackCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FeedbackCategory $feedbackCategory)
    {
        abort_if(Gate::denies('feedback_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeedbackCategoryResource($feedbackCategory);
    }

    public function update(UpdateFeedbackCategoryRequest $request, FeedbackCategory $feedbackCategory)
    {
        $feedbackCategory->update($request->all());

        return (new FeedbackCategoryResource($feedbackCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FeedbackCategory $feedbackCategory)
    {
        abort_if(Gate::denies('feedback_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
