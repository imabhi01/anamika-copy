<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['vendor_name'];
    }
}
