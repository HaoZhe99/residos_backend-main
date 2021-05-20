<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQrRequest;
use App\Http\Requests\UpdateQrRequest;
use App\Http\Resources\Admin\QrResource;
use App\Models\GateHistory;
use App\Models\Gateway;
use App\Models\Qr;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QrApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('qr_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $qr = Qr::with(['username', 'project_code']);

        if ($request->has('project_code_id')) {
            $qr->where('project_code_id', $request->project_code_id);
        }

        return new QrResource($qr->get());
    }

    public function store(Request $request)
    {
        $code = '';
        while ($code == '') {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 12; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            // return $randomString;
            $code = strtoupper($randomString);
            $qrs = Qr::where('code', $code)->get();
            if ($qrs->isEmpty()) {
                break;
            }
        }
        $request['status'] = 1;
        $request['code'] = $code;
        $request['expired_at'] = now();

        $qr = Qr::create($request->all());

        return (new QrResource($qr))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Qr $qr)
    {
        abort_if(Gate::denies('qr_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QrResource($qr->load(['username', 'project_code']));
    }

    public function update(UpdateQrRequest $request, Qr $qr)
    {
        $qr->update($request->all());

        return (new QrResource($qr))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Qr $qr)
    {
        abort_if(Gate::denies('qr_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $qr->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function scanQrCode($qrcode, Gateway $gateway, $type)
    {
        $res = array();

        if (strlen($qrcode) == 12) {
            $qr = Qr::with(['username', 'unit_owner'])
                ->where('code', $qrcode)
                ->where('status', 1);

            if ($qr->get()->isNotEmpty()) {
                $res = $qr->get();
                $qr->update(['status' => 0]);

                $history = GateHistory::create([
                    'gate_code'     => "Gate Code",
                    'username_id'   => $res[0]->username_id,
                    'gateway_id'    => $gateway->id,
                    'qr_id'         => $res[0]->id,
                    'type'          => $type,
                    'unit_id'       => $res[0]->unit_owner_id,
                ]);

                $gateway->update(['last_active' => now()]);
            }
        }

        return new QrResource($res);
    }
}
