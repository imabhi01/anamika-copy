<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

class Invoice extends Model
{
    use HasFactory;
    
    use HasManyRelation;

    protected $fillable = [
        'customer_id', 'date', 'due_date', 'discount',
        'terms_and_conditions', 'reference'
    ];

    protected $guarded = [
        'number', 'sub_total', 'total'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
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

        $query->join('customers', 'invoices.customer_id', 'customers.id')
            ->where(function ($query) use ($term) {
                $query->where('firstname', 'like', $term)
                    ->orWhere('lastname', 'like', $term)
                    ->orWhere('number', 'like', $term)
                    ->paginate(request('total_rows')
            );
        });
    }
}
