<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class FamilyControl extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'family_controls';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const ACTIVITY_LOGS_SELECT = [
        '0' => 'Disable',
        '1' => 'Enable',
        '2' => 'Pending',
    ];

    protected $fillable = [
        'family_id',
        'unit_owner_id',
        'activity_logs',
        'from_family',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function family()
    {
        return $this->belongsTo(User::class, 'family_id');
    }

    public function unit_owner()
    {
        return $this->belongsTo(UnitManagement::class, 'unit_owner_id');
    }
}
