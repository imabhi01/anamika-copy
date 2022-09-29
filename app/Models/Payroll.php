<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Http\Traits\NepaliDateConverter;

class Payroll extends Model
{
    use HasFactory, NepaliDateConverter;

    private $month_name = array('ब‌ैशाख', 'जेठ', 'असार', 'साउन', 'भदौ', 'असोज', 'कार्तिक', 'मङ्सिर', 'पुस', 'माघ', 'फाल्गुण', 'चैत');

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
       return $this->month_name[intVal(date('m', strtotime($this->date)))-1];
    }
}
