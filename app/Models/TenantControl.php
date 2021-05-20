<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class TenantControl extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'tenant_controls';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'disable' => 'Disable',
        'room' => 'Room',
        'unit' => 'Unit',
    ];

    protected $fillable = [
        'tenant_id',
        'rent_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class, 'rent_id');
    }
}
