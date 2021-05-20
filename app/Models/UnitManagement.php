<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class   UnitManagement extends Model implements HasMedia
{
    use SoftDeletes, HasFactory,InteractsWithMedia;

    protected $appends = [
        'spa',
    ];

    public $table = 'unit_mangements';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'unit_code',
        'floor_size',
        'bed_room',
        'toilet',
        'floor_level',
        'carpark_slot',
        'bumi_lot',
        'block',
        'status',
        'balcony',
        'project_code_id',
        'unit_id',
        'owner_id',
        'unit_owner',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'pending'       => 'Pending',
        'new launch'    => 'New Launch',
        'owned'         => 'Owned',
        'selling'       => 'Selling',
        'rented'        => 'Rented',
        'owned - empty' => 'Owned - Empty',
        'rent - entire' => 'Rent - Entire',
        'rent - room'   => 'Rent - Room',
        'moving out'    => 'Moving Out',
        'moving in'     => 'Moving In',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function project_code()
    {
        return $this->belongsTo(ProjectListing::class, 'project_code_id');
    }

    public function unit()
    {
        return $this->belongsTo(AddUnit::class, 'unit_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getSpaAttribute()
    {
        return $this->getMedia('spa')->last();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }
}
