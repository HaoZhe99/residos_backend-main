<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class EBillListing extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'e_bill_listings';

    protected $appends = [
        'receipt',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'outstanding' => 'Outstanding',
        'overdue'     => 'OverDue',
        'pending'     => 'Pending',
        'paid'        => 'Paid',
        'reject'      => 'Reject',
        'on_hold'     => 'On Hold',
    ];

    protected $fillable = [
        'type',
        'amount',
        'expired_date',
        'remark',
        'project_id',
        'unit_id',
        'bank_acc_id',
        'username_id',
        'payment_method_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_SELECT = [
        'Maintenance'     => 'Maintenance',
        'Water Utilities' => 'Water Utilities',
        'Car Park'        => 'Car Park',
        'Facility'        => 'Facility',
        'Event'           => 'Event',
        'Rent'            => 'Rent',
        'User Slot Fee'   => 'User Slot Fee',
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

    public function project()
    {
        return $this->belongsTo(ProjectListing::class, 'project_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitManagement::class, 'unit_id');
    }

    public function bank_acc()
    {
        return $this->belongsTo(BankAccListing::class, 'bank_acc_id');
    }

    public function username()
    {
        return $this->belongsTo(User::class, 'username_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function getReceiptAttribute()
    {
        $file = $this->getMedia('receipt')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
}
