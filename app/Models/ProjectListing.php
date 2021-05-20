<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class ProjectListing extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'project_listings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TENURE_SELECT = [
        'freehold'  => 'Freehold',
        'leaseHold' => 'LeaseHold',
    ];

    const TYPE_SELECT = [
        'pending'  => 'Pending',
        'approve'  => 'Approve',
        'reject' => 'Reject',
    ];

    protected $fillable = [
        'project_code',
        'name',
        'type_id',
        'address',
        'developer_id',
        'tenure',
        'completion_date',
        'status',
        'sales_gallery',
        'website',
        'fb',
        'block',
        'unit',
        'is_new',
        'area_id',
        'pic_id',
        'create_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }

    public function developer()
    {
        return $this->belongsTo(DeveloperListing::class, 'developer_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function pic()
    {
        return $this->belongsTo(Pic::class, 'pic_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by');
    }
}
