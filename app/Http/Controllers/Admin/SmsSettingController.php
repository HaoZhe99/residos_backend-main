<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SMS;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsSettingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sms_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.smsSettings.index');
    }

    public function edit(SMS $sms_setting)
    {
        abort_if(Gate::denies('sms_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.smsSettings.edit', compact('sms_setting'));
    }

    public function update(Request $request, SMS $sms_setting)
    {
        $sms_setting->update($request->all());

        return redirect("/admin/sms-settings/1/edit");
    }
}
