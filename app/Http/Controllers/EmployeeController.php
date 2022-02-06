<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store(Request $request){

        $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'phone' => 'required|phone|unique:users',
           'address' => 'required|string',
           'image' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048',
           'salary' => 'required|numeric'
        ]);

        $employee = Employee::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'salary' => $request['salary']
        ]);

        if($request->file('image')) {
            $file = $request->file('image');
            $employee->image = Storage::put('public/uploads/employees',$request->file('image'));
            $employee->save();
        }

        return response()
            ->json([
                'saved' => true,
                'result' => $employee,
                'status' => 200
            ]);
    }
}
