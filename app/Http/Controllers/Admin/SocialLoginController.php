<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySocialLoginRequest;
use App\Models\SocialLogin;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SocialLoginController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('social_login_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialLogins = SocialLogin::all();

        return view('admin.socialLogins.index', compact('socialLogins'));
    }

    public function create()
    {
        abort_if(Gate::denies('social_login_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.socialLogins.create');
    }

    public function store(Request $request)
    {
        $socialLogin = SocialLogin::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'secret' => $request->secret,
            'redirect' => $request->redirect,
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => 0,
        ]);

        return redirect()->route('admin.social-logins.index');
    }

    public function edit(SocialLogin $socialLogin)
    {
        abort_if(Gate::denies('social_login_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.socialLogins.edit', compact('socialLogin'));
    }

    public function update(Request $request, SocialLogin $socialLogin)
    {
        $socialLogin->update($request->all());

        return redirect()->route('admin.social-logins.index');
    }

    public function show(SocialLogin $socialLogin)
    {
        abort_if(Gate::denies('social_login_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.socialLogins.show', compact('socialLogin'));
    }

    public function destroy(SocialLogin $socialLogin)
    {
        abort_if(Gate::denies('social_login_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialLogin->delete();

        return back();
    }

    public function massDestroy(MassDestroySocialLoginRequest $request)
    {
        SocialLogin::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
