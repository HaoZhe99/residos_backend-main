<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class VehicleModel extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'vehicle_models';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_SELECT = [
        'car'        => 'Car',
        'motorcycle' => 'Motorcycle',
        'van'        => 'Van',
        'bus'        => 'Bus',
        'lorry'      => 'Lorry',
    ];

    protected $fillable = [
        'brand_id',
        'model',
        'is_enable',
        'type',
        'color',
        'variant',
        'series',
        'release_year',
        'seat_capacity',
        'length',
        'width',
        'height',
        'wheel_base',
        'kerb_weight',
        'fuel_tank',
        'front_brake',
        'rear_brake',
        'front_suspension',
        'rear_suspension',
        'steering',
        'engine_cc',
        'compression_ratio',
        'peak_power_bhp',
        'peak_torque_nm',
        'engine_type',
        'fuel_type',
        'driven_wheel_drive',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class, 'brand_id');
    }
}
