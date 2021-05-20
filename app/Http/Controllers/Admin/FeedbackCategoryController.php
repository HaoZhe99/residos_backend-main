<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFeedbackCategoryRequest;
use App\Http\Requests\StoreFeedbackCategoryRequest;
use App\Http\Requests\UpdateFeedbackCategoryRequest;
use App\Models\FeedbackCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FeedbackCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('feedback_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FeedbackCategory::query()->select(sprintf('%s.*', (new FeedbackCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'feedback_category_show';
                $editGate      = 'feedback_category_edit';
                $deleteGate    = 'feedback_category_delete';
                $crudRoutePart = 'feedback-categories';

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
            $table->editColumn('category', function ($row) {
                return $row->category ? $row->category : "";
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_active']);

            return $table->make(true);
        }

        return view('admin.feedbackCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('feedback_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.feedbackCategories.create');
    }

    public function store(StoreFeedbackCategoryRequest $request)
    {
        $feedbackCategory = FeedbackCategory::create($request->all());

        return redirect()->route('admin.feedback-categories.index');
    }

    public function edit(FeedbackCategory $feedbackCategory)
    {
        abort_if(Gate::denies('feedback_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.feedbackCategories.edit', compact('feedbackCategory'));
    }

    public function update(UpdateFeedbackCategoryRequest $request, FeedbackCategory $feedbackCategory)
    {
        $feedbackCategory->update($request->all());

        return redirect()->route('admin.feedback-categories.index');
    }

    public function show(FeedbackCategory $feedbackCategory)
    {
        abort_if(Gate::denies('feedback_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.feedbackCategories.show', compact('feedbackCategory'));
    }

    public function destroy(FeedbackCategory $feedbackCategory)
    {
        abort_if(Gate::denies('feedback_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeedbackCategoryRequest $request)
    {
        FeedbackCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
