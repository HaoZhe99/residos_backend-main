<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTermAndPolicyRequest;
use App\Http\Requests\StoreTermAndPolicyRequest;
use App\Http\Requests\UpdateTermAndPolicyRequest;
use App\Models\ProjectListing;
use App\Models\TermAndPolicy;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TermAndPolicyController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('term_and_policy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TermAndPolicy::with(['project_code'])->select(sprintf('%s.*', (new TermAndPolicy)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'term_and_policy_show';
                $editGate      = 'term_and_policy_edit';
                $deleteGate    = 'term_and_policy_delete';
                $crudRoutePart = 'term-and-policies';

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
            $table->editColumn('title_zh', function ($row) {
                return $row->title_zh ? $row->title_zh : "";
            });
            $table->editColumn('title_en', function ($row) {
                return $row->title_en ? $row->title_en : "";
            });
            $table->editColumn('title_ms', function ($row) {
                return $row->title_ms ? $row->title_ms : "";
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? TermAndPolicy::TYPE_SELECT[$row->type] : '';
            });

            $table->editColumn('project_code', function ($row) {
                return $row->project_code ? $row->project_code->project_code : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.termAndPolicies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('term_and_policy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes  = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.termAndPolicies.create', compact('project_codes'));
    }

    public function store(StoreTermAndPolicyRequest $request)
    {
        $termAndPolicy = TermAndPolicy::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $termAndPolicy->id]);
        }

        return redirect()->route('admin.term-and-policies.index');
    }

    public function edit(TermAndPolicy $termAndPolicy)
    {
        abort_if(Gate::denies('term_and_policy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project_codes  = ProjectListing::all()->pluck('project_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.termAndPolicies.edit', compact('termAndPolicy', 'project_codes'));
    }

    public function update(UpdateTermAndPolicyRequest $request, TermAndPolicy $termAndPolicy)
    {
        $termAndPolicy->update($request->all());

        return redirect()->route('admin.term-and-policies.index');
    }

    public function show(TermAndPolicy $termAndPolicy)
    {
        abort_if(Gate::denies('term_and_policy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.termAndPolicies.show', compact('termAndPolicy'));
    }

    public function destroy(TermAndPolicy $termAndPolicy)
    {
        abort_if(Gate::denies('term_and_policy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $termAndPolicy->delete();

        return back();
    }

    public function massDestroy(MassDestroyTermAndPolicyRequest $request)
    {
        TermAndPolicy::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('term_and_policy_create') && Gate::denies('term_and_policy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new TermAndPolicy();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
