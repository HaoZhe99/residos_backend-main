<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContentTypeRequest;
use App\Http\Requests\StoreContentTypeRequest;
use App\Http\Requests\UpdateContentTypeRequest;
use App\Models\ContentType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ContentTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('content_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ContentType::query()->select(sprintf('%s.*', (new ContentType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'content_type_show';
                $editGate      = 'content_type_edit';
                $deleteGate    = 'content_type_delete';
                $crudRoutePart = 'content-types';

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
            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_active']);

            return $table->make(true);
        }

        return view('admin.contentTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('content_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contentTypes.create');
    }

    public function store(StoreContentTypeRequest $request)
    {
        $contentType = ContentType::create($request->all());

        return redirect()->route('admin.content-types.index');
    }

    public function edit(ContentType $contentType)
    {
        abort_if(Gate::denies('content_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contentTypes.edit', compact('contentType'));
    }

    public function update(UpdateContentTypeRequest $request, ContentType $contentType)
    {
        $contentType->update($request->all());

        return redirect()->route('admin.content-types.index');
    }

    public function show(ContentType $contentType)
    {
        abort_if(Gate::denies('content_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contentTypes.show', compact('contentType'));
    }

    public function destroy(ContentType $contentType)
    {
        abort_if(Gate::denies('content_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentType->delete();

        return back();
    }

    public function massDestroy(MassDestroyContentTypeRequest $request)
    {
        ContentType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
