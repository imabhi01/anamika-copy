<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

class Expense extends Model
{
    use HasFactory, HasManyRelation;

    protected $fillable = [
        'vendor_id', 'date', 'due_date', 'discount',
        'terms_and_conditions', 'reference'
    ];

    protected $guarded = [
        'number', 'sub_total', 'total'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(ExpenseItem::class);
    }

    public function setSubTotalAttribute($value)
    {
        $this->attributes['sub_total'] = $value;
        $discount = $this->attributes['discount'];
        $this->attributes['total'] = $value - (($value * $discount) / 100);
    }

    public function scopeSearch($query)
    {
        $term = "%". request('q') ."%";

        $query->whereHas('vendor', function($query) use ($term){
            $query->where('firstname', 'like', $term)
                ->orWhere('lastname', 'like', $term)
                ->orWhere('number', 'like', $term);
        });
    }
}
