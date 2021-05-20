<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class VisitorControl extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'visitor_controls';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'enable'  => 'Enable',
        'disable' => 'Disable',
    ];

    protected $fillable = [
        'username_id',
        'add_by_id',
        'status',
        'favourite',
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

    public function add_by()
    {
        return $this->belongsTo(User::class, 'add_by_id');
    }
}
