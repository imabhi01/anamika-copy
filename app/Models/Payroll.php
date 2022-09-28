<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Http\Traits\NepaliDateConverter;

class Payroll extends Model
{
    use HasFactory, NepaliDateConverter;

    protected $guarded = [];

    protected $fillable = [
        'employee_id', 'date', 'salary', 'bonus', 'status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['nepaliMonth'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getNepaliMonthAttribute($value) {
        $date = $this->get_nepali_date(date("Y", strtotime($value)), date("m", strtotime($value)), date("d", strtotime($value)));
        return $date['M']; 
    }
}
