<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payroll;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $hidden = ['created_at', 'updated_at'];

    public function getImageAttribute($image)
    {
        return asset(\Storage::url($image ?: 'public/uploads/default.jpg'));
    }

    public function payrolls(){
        return $this->hasMany(Payroll::class);
    }
}
