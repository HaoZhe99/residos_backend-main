<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class AdvanceSetting extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'advance_settings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_SELECT = [
        'unit'          => 'Unit',
        'tenant'        => 'Tenant',
        'water Utility' => 'Water Utility',
        'QR'            => 'QR',
    ];

    protected $fillable = [
        'type',
        'key',
        'status',
        'project_code',
        'amount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
