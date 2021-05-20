<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class DeveloperListing extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'developer_listings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_name',
        'contact',
        'address',
        'email',
        'website',
        'fb',
        'linked_in',
        'pic_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function pic()
    {
        return $this->belongsTo(Pic::class, 'pic_id');
    }
}
