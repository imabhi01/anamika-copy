<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Employee;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'date', 'salary', 'bonus', 'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
