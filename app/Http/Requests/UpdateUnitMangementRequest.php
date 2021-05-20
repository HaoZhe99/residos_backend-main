<?php

namespace App\Http\Requests;

use App\Models\UnitMangement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitMangementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_mangement_edit');
    }

    public function rules()
    {
        return [
            'unit_code'       => [
                'string',
                'nullable',
            ],
            'floor_size'      => [
                'string',
                'required',
            ],
            'bed_room'        => [
                'string',
                'required',
            ],
            'toilet'          => [
                'string',
                'required',
            ],
            // 'floor_level'     => [
            //     'string',
            //     'nullable',
            // ],
            'carpark_slot'    => [
                'string',
                'nullable',
            ],
            // 'block'           => [
            //     'string',
            //     'nullable',
            // ],
            'project_code_id' => [
                'required',
                'integer',
            ],
            'unit_id'         => [
                'required',
                'integer',
            ],
        ];
    }
}
