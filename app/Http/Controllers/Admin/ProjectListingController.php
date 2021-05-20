<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProjectListingRequest;
use App\Http\Requests\StoreProjectListingRequest;
use App\Http\Requests\UpdateProjectListingRequest;
use App\Models\Area;
use App\Models\DeveloperListing;
use App\Models\Notification;
use App\Models\Pic;
use App\Models\ProjectListing;
use App\Models\ProjectType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use OneSignal;

class ProjectListingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('project_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProjectListing::with(['type', 'developer', 'area', 'pic', 'user'])
                ->select(sprintf('%s.*', (new ProjectListing)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'project_listing_show';
                $editGate      = 'project_listing_edit';
                $deleteGate    = 'project_listing_delete';
                $approveGate   = 'project_listing_edit';
                $rejectGate   = 'project_listing_edit';
                $crudRoutePart = 'project-listings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'approveGate',
                    'rejectGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $query->whereDate('completion_date', '>=', $request->min_date);
            $query->whereDate('completion_date', '<=', $request->max_date);

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('project_code', function ($row) {
                return $row->project_code ? $row->project_code : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->addColumn('type_type', function ($row) {
                return $row->type ? $row->type->type : '';
            });

            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });
            $table->addColumn('developer_company_name', function ($row) {
                return $row->developer ? $row->developer->company_name : '';
            });

            $table->editColumn('tenure', function ($row) {
                return $row->tenure ? ProjectListing::TENURE_SELECT[$row->tenure] : '';
            });

            $table->editColumn('completion_date', function ($row) {
                return $row->completion_date ? $row->completion_date : "";
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? ProjectListing::TYPE_SELECT[$row->status] : '';
            });

            $table->editColumn('sales_gallery', function ($row) {
                return $row->sales_gallery ? $row->sales_gallery : "";
            });
            $table->editColumn('website', function ($row) {
                return $row->website ? $row->website : "";
            });
            $table->editColumn('fb', function ($row) {
                return $row->fb ? $row->fb : "";
            });
            $table->editColumn('block', function ($row) {
                return $row->block ? $row->block : "";
            });
            $table->editColumn('unit', function ($row) {
                return $row->unit ? $row->unit : "";
            });
            $table->editColumn('is_new', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_new ? 'checked' : null) . '>';
            });
            $table->addColumn('area_area', function ($row) {
                return $row->area ? $row->area->area : '';
            });

            $table->addColumn('pic_name', function ($row) {
                return $row->pic ? $row->pic->name : '';
            });

            $table->addColumn('create_by', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'type', 'developer', 'is_new', 'area', 'pic', 'user']);

            return $table->make(true);
        }

        return view('admin.projectListings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('project_listing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = ProjectType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $developers = DeveloperListing::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pics = Pic::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.projectListings.create', compact('types', 'developers', 'areas', 'pics', 'users'));
    }

    public function store(StoreProjectListingRequest $request)
    {
        $projectListing = ProjectListing::create($request->all());

        return redirect()->route('admin.project-listings.index');
    }

    public function edit(ProjectListing $projectListing)
    {
        abort_if(Gate::denies('project_listing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = ProjectType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $developers = DeveloperListing::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pics = Pic::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projectListing->load('type', 'developer', 'area', 'pic', 'user');

        return view('admin.projectListings.edit', compact('types', 'developers', 'areas', 'pics', 'users', 'projectListing'));
    }

    public function update(UpdateProjectListingRequest $request, ProjectListing $projectListing)
    {
        $projectListing->update($request->all());

        return redirect()->route('admin.project-listings.index');
    }

    public function show(ProjectListing $projectListing)
    {
        abort_if(Gate::denies('project_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectListing->load('type', 'developer', 'area', 'pic', 'user');

        return view('admin.projectListings.show', compact('projectListing'));
    }

    public function destroy(ProjectListing $projectListing)
    {
        abort_if(Gate::denies('project_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectListing->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectListingRequest $request)
    {
        ProjectListing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function approve_project(Request $request, ProjectListing $projectListing)
    {
        $id = $request->id;
        $user_id = User::all()->where('id', $request->create_by)->first();
        // dd($user_id);
        $array_user = array((string)$user_id->id);

        if ($request->status === "approve") {
            $status = ProjectListing::find($id);
            $status->status = "approve";
            $status->save();
            $notification = Notification::create([
                'title_text' => "Project Request Successful",
                'description_text' => "Your New Project Request Approved. Request Successful",
                'language_shortkey' => "en",
                'user_id' => $id,
                'is_active' => "1",
            ]);

            $params = [];
            $params['include_external_user_ids'] = $array_user;
            $params['headings'] = [
                "zh-Hans" => "新项目添加成功",
                "en"      => "New Project Request Successful",
                "ms"      => "New Project Request Successful",
            ];
            $params['contents'] = [
                "zh-Hans" => "您的添加新项目已被批准。添加成功。",
                "en"      => "Your Request New Project Approved. Request Successful",
                "ms"      => "Your Request New Project Approved. Request Successful",
            ];
        }

        if ($request->status === "reject") {
            $status = ProjectListing::find($id);
            $status->status = "reject";
            $status->save();
            $notification = Notification::create([
                'title_text' => "Project Request Reject",
                'description_text' => "Your New Project Request Reject. Request Unsuccessful. Please call the admin.",
                'language_shortkey' => "en",
                'user_id' => $id,
                'is_active' => "1",
            ]);

            $params = [];
            $params['include_external_user_ids'] = $array_user;
            $params['headings'] = [
                "zh-Hans" => "新项目添加不成功",
                "en"      => "New Project Request Reject",
                "ms"      => "New Project Request Reject",
            ];
            $params['contents'] = [
                "zh-Hans" => "您的添加新项目已被拒绝。添加不成功。请打电话给管理员。",
                "en"      => "Your Request New Project Reject. Request Unsuccessful. Please call the admin.",
                "ms"      => "Your Request New Project Reject. Request Unsuccessful. Please call the admin.",
            ];
        }

        OneSignal::sendNotificationCustom($params);

        return redirect()->route('admin.project-listings.index');
    }
}
