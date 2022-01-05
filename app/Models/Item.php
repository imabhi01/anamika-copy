<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'unit_price',
        'description',
        'unit'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['item_name'];
    }

}
