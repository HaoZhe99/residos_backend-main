<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class GateHistory extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'gate_histories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'gate_code',
        'type',
        'username_id',
        'gateway_id',
        'qr_id',
        'unit_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function username()
    {
        return $this->belongsTo(User::class, 'username_id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }

    public function qr()
    {
        return $this->belongsTo(Qr::class, 'qr_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitManagement::class, 'unit_id');
    }
}
