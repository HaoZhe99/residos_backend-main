<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPicRequest;
use App\Http\Requests\StorePicRequest;
use App\Http\Requests\UpdatePicRequest;
use App\Models\Pic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PicController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('pic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Pic::query()
                ->select(sprintf('%s.*', (new Pic)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'pic_show';
                $editGate      = 'pic_edit';
                $deleteGate    = 'pic_delete';
                $crudRoutePart = 'pics';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('contact', function ($row) {
                return $row->contact ? $row->contact : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : "";
            });
            $table->editColumn('fb', function ($row) {
                return $row->fb ? $row->fb : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.pics.index');
    }

    public function create()
    {
        abort_if(Gate::denies('pic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pics.create');
    }

    public function store(StorePicRequest $request)
    {
        $pic = Pic::create($request->all());

        return redirect()->route('admin.pics.index');
    }

    public function edit(Pic $pic)
    {
        abort_if(Gate::denies('pic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pics.edit', compact('pic'));
    }

    public function update(UpdatePicRequest $request, Pic $pic)
    {
        $pic->update($request->all());

        return redirect()->route('admin.pics.index');
    }

    public function show(Pic $pic)
    {
        abort_if(Gate::denies('pic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pics.show', compact('pic'));
    }

    public function destroy(Pic $pic)
    {
        abort_if(Gate::denies('pic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pic->delete();

        return back();
    }

    public function massDestroy(MassDestroyPicRequest $request)
    {
        Pic::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
