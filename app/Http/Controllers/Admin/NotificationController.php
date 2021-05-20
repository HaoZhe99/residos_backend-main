<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use OneSignal;

class NotificationController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('notifications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Notification::with(['roles','users'])
                ->select(sprintf('%s.*', (new Notification)->table))
                ->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'notifications_show';
                $editGate      = 'notification_edit';
                $deleteGate    = 'notifications_delete';
                $crudRoutePart = 'notifications';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('title_text', function ($row) {
                return $row->title_text ? $row->title_text : "";
            });
            $table->editColumn('description_text', function ($row) {
                return $row->description_text ? $row->description_text : "";
            });
            $table->editColumn('image', function ($row) {
                if (!$row->image) {
                    return '';
                }

                $links = [];

                foreach ($row->image as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('language_shortkey', function ($row) {
                return $row->language_shortkey ? $row->language_shortkey : "";
            });
            $table->editColumn('url', function ($row) {
                return $row->url ? $row->url : "";
            });
            $table->editColumn('expired_date', function ($row) {
                return $row->expired_date ? $row->expired_date : "";
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });
            $table->editColumn('role', function ($row) {
                return $row->roles ? $row->roles->title : '';
            });

            $table->editColumn('user', function ($row) {
                return $row->users ? $row->users->name : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'role', 'user', 'is_active', 'image']);

            return $table->make(true);
        }

        return view('admin.notifications.index');
    }

    public function create()
    {
        abort_if(Gate::denies('notifications_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $users = User::all()->pluck('name', 'id');

        $languages = Language::all();

        return view('admin.notifications.create', compact('roles', 'users', 'languages'));
    }

    public function store(StoreNotificationRequest $request)
    {
        $array_language = $request->input('language_shortkey');
        $array_title = $request->input('title_text');
        $array_description = $request->input('description_text');
        $array_role = $request->input('role_id');
        $arraylength = count($array_language);

        // User Only
        if ($array_role == null) {
            $notification = Notification::create([
                'title_text' => $array_title[0],
                'description_text' => $array_description[0],
                'language_shortkey' => $array_language[0],
                'user_id' => $request->user_id,
                'url' => $request->url,
                'expired_date' => $request->expired_date,
                'is_active' => $request->is_active,
            ]);

            $array_user = array($request->user_id);

            $params = [];
            $params['include_external_user_ids'] = $array_user;
            $params['headings'] = [
                $array_language[0] => $array_title[0]
            ];
            $params['contents'] = [
                $array_language[0] => $array_title[0]
            ];

            OneSignal::sendNotificationCustom($params);
        }else{
            // Role Only
            for ($i=0; $i < $arraylength; $i++) {
                $notification = Notification::create([
                    'title_text' => $array_title[$i],
                    'description_text' => $array_description[$i],
                    'language_shortkey' => $array_language[$i],
                    'role_id' => $array_role[0],
                    'url' => $request->url,
                    'expired_date' => $request->expired_date,
                    'is_active' => $request->is_active,
                ]);

                $params = [];
                $params['include_external_role_ids'] = $array_role[0];
                $params['headings'] = [
                    $array_language[0] => $array_title[0]
                ];
                $params['contents'] = [
                    $array_language[$i] => $array_title[$i]
                ];

                OneSignal::sendNotificationCustom($params);
            }
        }

        foreach ($request->input('image', []) as $file) {
            $notification->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $notification->id]);
        }

        return redirect()->route('admin.notifications.index');
    }

    public function show(Notification $userAlert)
    {
        abort_if(Gate::denies('notifications_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->load('roles');

        return view('admin.notifications.show', compact('userAlert'));
    }

    public function destroy(Notification $userAlert)
    {
        abort_if(Gate::denies('notifications_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Notification::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function read(Request $request)
    {
        $alerts = \Auth::user()->userUserAlerts()->where('read', false)->get();

        foreach ($alerts as $alert) {
            $pivot       = $alert->pivot;
            $pivot->read = true;
            $pivot->save();
        }
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('notifications_create') && Gate::denies('notifications_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new notifications();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
