<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class WaterUtilityPayment extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    // protected $appends = [
    //     'receipt',
    // ];

    public $table = 'water_utility_payments';

    protected $dates = [
        'last_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // const STATUS_SELECT = [
    //     'outstanding' => 'Outstanding',
    //     'pending'     => 'Pending',
    //     'paid'        => 'Paid',
    //     'overdue'     => 'Overdue',
    //     'reject'      => 'Reject',
    // ];

    protected $fillable = [
        'unit_owner_id',
        'name',
        'last_date',
        'last_meter',
        'this_meter',
        'prev_consume',
        'this_consume',
        'variance',
        // 'amount',
        // 'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function unit_owner()
    {
        return $this->belongsTo(UnitManagement::class, 'unit_owner_id');
    }

    public function getLastDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setLastDateAttribute($value)
    {
        $this->attributes['last_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getReceiptAttribute()
    {
        return $this->getMedia('receipt')->last();
    }
}
