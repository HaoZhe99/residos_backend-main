<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventCategoryRequest;
use App\Http\Requests\StoreEventCategoryRequest;
use App\Http\Requests\UpdateEventCategoryRequest;
use App\Models\EventCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EventCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('event_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EventCategory::query()->select(sprintf('%s.*', (new EventCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'event_category_show';
                $editGate      = 'event_category_edit';
                $deleteGate    = 'event_category_delete';
                $crudRoutePart = 'event-categories';

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
            $table->editColumn('cateogey', function ($row) {
                return $row->cateogey ? $row->cateogey : "";
            });
            $table->editColumn('is_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_enable ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_enable']);

            return $table->make(true);
        }

        return view('admin.eventCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('event_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventCategories.create');
    }

    public function store(StoreEventCategoryRequest $request)
    {
        $eventCategory = EventCategory::create($request->all());

        return redirect()->route('admin.event-categories.index');
    }

    public function edit(EventCategory $eventCategory)
    {
        abort_if(Gate::denies('event_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventCategories.edit', compact('eventCategory'));
    }

    public function update(UpdateEventCategoryRequest $request, EventCategory $eventCategory)
    {
        $eventCategory->update($request->all());

        return redirect()->route('admin.event-categories.index');
    }

    public function show(EventCategory $eventCategory)
    {
        abort_if(Gate::denies('event_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventCategories.show', compact('eventCategory'));
    }

    public function destroy(EventCategory $eventCategory)
    {
        abort_if(Gate::denies('event_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventCategoryRequest $request)
    {
        EventCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
